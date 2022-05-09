@extends('layouts.app')
@section('content')

<h3>Blus types aanpassen</h3>

                <label for="merk">Selecteer Merk</label>
                <select id="merk">
                <option value="0" disabled selected value></option>
              
              @foreach($brands as $brand)

                     <option value="{{$brand->id}}" @if ($brand->id == $brandid) selected @endif>{{$brand->name}}</option>
                
                 @endforeach
                 </select>

@if ($brandid > 0)



  <label for="blusstof">Selecteer Blusstof</label>
                <select id="blusstof">
                <option value="0" disabled selected value></option>
              
              @foreach($blusstoffen as $blusstof)

                     <option value="{{$blusstof->id}}" @if ($blusstof->id == $blusstofid) selected @endif>{{$blusstof->name}}</option>
                
                 @endforeach
                 </select>




@endif
@if ($brandid > 0 && $blusstofid > 0)
<form action="{{ url('lists/type')}}" method="POST">
    {!! csrf_field() !!}
<label>Typenaam</label>
<input id="typeid" name="typeid" type="hidden" value="0">
<input id="brandid" name="brandid" type="hidden" value="{{$brandid}}">
<input id="stofid" name="stofid" type="hidden" value="{{$blusstofid}}">

<input type="text" id="typename" name="typename"></input>
<input type="submit" value="Toevoegen" id="button"> 
</form>
<table>

<tbody>
@foreach($types as $type)

<tr>
<td>
{{$type->name}}
</td>
<td>
<a href="#" class="edit" data-typeid="{{$type->id}}" data-typename="{{$type->name}}">Aanpassen</a>
</td>
</tr>


@endforeach
</tbody>
</table>

@endif

@endsection

@section('scripts')

<script>


$('#merk,#blusstof').select2({ 
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

      location.href = '<?php echo url('/lists/blustype/') ?>/' + $(this).val() ;

});

$('#blusstof').on('select2:select',function(){

      location.href = '<?php echo url('/lists/blustype/') ?>/' + $('#merk').val() + '/' + $(this).val() ;
 console.log('<?php echo url('/lists/blustype/') ?>/' + $('#merk').val() + '/' + $(this).val());
});

var currentedit = 0;

$('.edit').on('click', function(){

	$('#typename').val($(this).data('typename'));
	currentedit = $(this).data('typeid');
	$('#button').prop('value','Aanpassen');
	$('#typeid').prop('value',currentedit);

});


</script>
@endsection