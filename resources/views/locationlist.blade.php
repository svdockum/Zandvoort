@extends('layouts.app')
@section('content')


 <div class="row">
            <div class="small-12 columns">
                <h2>Locatie lijst voor <strong>{{$customer->name}}</strong></h2>
            </div>
        </div>

<div class="row">
            <div class="small-12 columns">
               <a class="button" href=" {{url('/customer/'.$customer->id. '/location/create')}}"><i class="fa fa-btn fa fa-plus"></i>Locatie toevoegen</a>
                <a class="button" href=" {{url('/customer/'.$customer->id)}}"><i class="fa fa-btn fa fa-caret-left"></i>Terug naar klant details</a>
            </div>
        </div>
<hr>
 <input type="text" id="search" placeholder="Zoek op straatnaam, postcode, plaats...">
<table id="overview">
   
    <thead>
           <th >Naam</th>
                    <th>Straat + Huisnummer</th>
                    <th style="width: 200px;">Postcode</th>
                    <th>Plaats</th>
                    <th>Google maps</th>
                     <th>Aanpassen</th>
                  </thead>
   <tbody>
       
   
<?php 
foreach ($locations as $location) {

    ?>
    <tr>
    <td>
                                <a href="{{ url('/customer/' . $customer->id . '/location/edit/' . $location->id) }}"><h4 style="margin-bottom: 0px;"> {{$location->name}}</h4></a>
                        @if ($location->isKeerBlus)
                       <span class="fa-stack fa-lg textred" style="font-size: 0.7rem;">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-fire-extinguisher" style="margin-left: 7px;"></i>
                        </span>
                        <span class="fa-stack fa-lg textblue" style="font-size: 0.7rem;">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-code-fork" style="margin-left: 8px;"></i>
                        </span>
                        @endif
                         @if ($location->isNood)
                        <span class="fa-stack fa-lg textgreen" style="font-size: 0.7rem;">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-lightbulb-o" style="margin-left: 8px;"></i>
                        </span>
                        @endif
                        </td>
                        <td>
                                {{$location->street}} {{$location->housenumber}}
</td><td>{{$location->postalcode}}</td><td>{{$location->city}}</td>

                             <td>
                                  <a href="https://www.google.nl/maps/place/{{$location->street}}+{{$location->housenumber}},+{{$location->postalcode}}+{{$location->city}}" target="_blank" class=""><i class="fa fa-map-marker fa-fw"></i>Google Maps</a></td>
                <td>
                      <a class="button" href="{{ url('/customer/' . $customer->id . '/location/edit/' . $location->id) }}"><i class="fa fa-pencil-square-o"></i>Aanpassen</a>
                    </td>
                    </tr>
<?php
}
?>
     
     </tbody>

</table>  
   
@endsection
@section('scripts')
<script>

var $rows = $('#overview tbody tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});

</script>
@endsection
