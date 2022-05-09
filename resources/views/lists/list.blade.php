@extends('layouts.app')
@section('content')

<form action="{{ url('lists/nood/'. $model. '/'. $filter)}}" method="POST">
    {!! csrf_field() !!}
<label>Optie Naam voor lijst: <strong>{{ $filter }}</strong></label>
<input id="id" name="id" type="hidden" value="0">
<input type="text" id="name" name="name"></input>
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
<a href="#" class="edit" data-id="{{$brand->id}}" data-name="{{$brand->name}}">Aanpassen</a>
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

	$('#name').val($(this).data('name'));
	currentedit = $(this).data('id');
	$('#button').prop('value','Aanpassen');
	$('#id').prop('value',currentedit);

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