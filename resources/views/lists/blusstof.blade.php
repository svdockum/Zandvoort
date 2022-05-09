@extends('layouts.app')
@section('content')

<h3>Blusstoffen aanpassen</h3>

                <label for="merk">Selecteer Merk</label>
                <select id="merk">
                <option value="0" disabled selected value></option>
              
              @foreach($brands as $brand)

                     <option value="{{$brand->id}}" @if ($brand->id == $brandid) selected @endif>{{$brand->name}}</option>
                
                 @endforeach
                 </select>

@if ($brandid > 0)
<form action="{{ url('lists/blusstof')}}" method="POST">
    {!! csrf_field() !!}
<label>Blusstof naam</label>
<input id="blusstofid" name="blusstofid" type="hidden" value="0">
<input id="brandid" name="brandid" type="hidden" value="{{$brandid}}">
<input type="text" id="blusstofname" name="blusstofname"></input>
<input type="submit" value="Toevoegen" id="button"> 
</form>
<table>

<tbody>
@foreach($blusstoffen as $blusstof)

<tr>
<td>
{{$blusstof->name}}
</td>
<td>
<a href="#" class="edit" data-blusstofid="{{$blusstof->id}}" data-blusstofname="{{$blusstof->name}}">Aanpassen</a>
</td>
</tr>


@endforeach
</tbody>
</table>

@endif

@endsection

@section('scripts')

<script>


$('#merk').select2({ 
        createSearchChoice:function(term, data) { 
        if ($(data).filter(function() { 
            return this.text.localeCompare(term)===0; 
        }).length===0) 
        {return {id:term, text:term};} 
    },
    multiple: false,
    tags: true,
    selectOnBlur: true
    });

$('#merk').on('select2:select',function(){

      location.href = '<?php echo url('/lists/blusstof/') ?>/' + $(this).val() ;

});

var currentedit = 0;

$('.edit').on('click', function(){

	$('#blusstofname').val($(this).data('blusstofname'));
	currentedit = $(this).data('blusstofid');
	$('#button').prop('value','Aanpassen');
	$('#blusstofid').prop('value',currentedit);

});


</script>
@endsection