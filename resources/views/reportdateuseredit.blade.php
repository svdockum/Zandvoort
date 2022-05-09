@extends('layouts.app')
@section('content')

<form action="{{ url('/wachtwoord')}}" method="POST">
    {!! csrf_field() !!}
<label>Vul een nieuwe datum in. Deze overschrijft de originele aanmaak datum.</label>
<div class="row">
<div class="small-3 columns">
<label for="day">Dag</label>
<input type="number" id="day" name="day" value="{{\App\Report::find($reportid)->created_at->format('d')}}"></input>
</div>
<div class="small-3 columns">
<label for="day">Maand</label>
<input type="number" id="month" name="month" value="{{\App\Report::find($reportid)->created_at->format('n')}}"></input>
</div>
<div class="small-3 columns end">
<label for="day">Jaar</label>
<input type="number" id="year" name="year" value="{{\App\Report::find($reportid)->created_at->format('Y')}}"></input>
</div>
</div>
<label>Selecteer een andere controleur. Staat de naam hier niet bij, maak er dan eerst 1 aan bij het gebruikers overzicht. Gebruik - om de originele naam weer terug te zetten.</label>
<!-- <input type="text" id="contr" name="contr" value="{{ \App\Report::find($reportid)->otheruser}}"></input> -->
<?php 
$items = \App\User::all(); ?>
<select id="contr" name="contr">
 <option value="">-</option>
	 @foreach($items as $item)
      <option value="{{$item->name}}" @if ($item->name == \App\Report::find($reportid)->otheruser) selected @endif>{{$item->name}}</option>
    @endforeach
</select>

<input type="submit" value="Aanpassen" id="button" class="button"> 

</form>
   <a href="#" class="button back">
                                    <i class="fa fa-btn fa fa-caret-left"></i>Terug
                                </a>
@endsection

@section('scripts')

<?php
	$cid = $lid ='';
	
	$report = \App\Report::find($reportid);
	$cid = $report->customer_id;
	$lid = $report->location_id;
	$cat = $report->category;
	?>

<script>

$('#button').click(function(e){
	e.preventDefault();

	//post to 
	$.post( "<?php echo url('/editreportdateuser') . '/' . $reportid; ?>", { 
		date: $('#year').val() + '-' + $('#month').val() + '-' + $('#day').val() , 
		contr: $('#contr').val() } );
	//redirect back
	var url = '<?php echo url('/customer/'. $cid.'/' . $cat  .'/location/'.$lid .'/' . $reportid);?>';
	window.location.href = url;

});



$('.back').click(function(e){
	e.preventDefault();

	//redirect back
	var url = '<?php echo url('/customer/'. $cid.'/' . $cat  .'/location/'.$lid .'/' . $reportid);?>';
	window.location.href = url;

});



</script>

@endsection