@extends('layouts.app')
@section('content')

<form action="{{ url('lists/blusbrand')}}" method="POST">
    {!! csrf_field() !!}
<label>Merknaam</label>
<input id="brandid" name="brandid" type="hidden" value="0">
<input type="text" id="brandname" name="brandname"></input>
<input type="submit" value="Toevoegen" id="button"> 
</form>
<table>

<tbody>
@foreach($brands as $brand)

<tr>
<td>
{{$brand->name}}
</td>
<td>
<a href="#" class="edit" data-brandid="{{$brand->id}}" data-brandname="{{$brand->name}}">Aanpassen</a>
</td>
</tr>


@endforeach
</tbody>
</table>

@endsection

@section('scripts')

<script>

var currentedit = 0;

$('.edit').on('click', function(){

	$('#brandname').val($(this).data('brandname'));
	currentedit = $(this).data('brandid');
	$('#button').prop('value','Aanpassen');
	$('#brandid').prop('value',currentedit);

});


$('#button').on('click',function(){

	if (currentedit == 0) {
		//create new, refresh page

	}
	else {

	}
});

</script>
@endsection