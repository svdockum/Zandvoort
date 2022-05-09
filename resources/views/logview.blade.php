@extends('layouts.app')
@section('content')

<a href="{{ url('/customer/' . $customerid )}}" class="button" style="width: 100%"></i>Naar Rapportage Overzicht</a>
<a href="{{ url('/customer/archive/' . $customerid )}}" class="button" style="width: 100%"></i>Naar Archieflijst</a>

<table>
<thead>
    <tr>
    <th>Aangemaakt</th>
    <th>Persoon</th>
    <th>Category</th>
    <th>Aantal regels</th>
    <th>Details</th>
</thead>
  @foreach ($entries as $entry)


<?php

$c = 0;

$json = json_decode($entry->json,true);

if ($json != null) $c = count($json);

?>
<tr>
<td class="text-center">{{$entry->created_at->format('d-m-Y | H:i')}}</td>
<td><?php 
                    $username=  '';
                    if (!empty($entry->user_id)) {
                        $username = \App\User::find($entry->user_id)->name;
                    }
                     if (!empty($entry->otheruser)) {
                        $username = $entry->otheruser;
                     }
                     echo $username;
                        ?></td>
                        <td>{{$entry->category}}</td>
<td>{{$c}}</td>
<td><a target="_blank" href="{{ url('/loglines/' . $entry->id )}}">Details (opent in nieuw scherm)</a></td>
</tr>


  
  @endforeach
</table>

@endsection