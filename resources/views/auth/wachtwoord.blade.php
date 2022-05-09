@extends('layouts.app')
@section('content')

<form action="{{ url('/wachtwoord')}}" method="POST">
    {!! csrf_field() !!}
<label>Vul je nieuwe wachtwoord in. Na 'aanpassen' ga je terug naar het hoofdscherm en is je wachtwoord aangepast.</label>
<input type="text" id="pass" name="pass"></input>
<input type="submit" value="Aanpassen" id="button"> 
</form>

@endsection

