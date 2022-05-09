@extends('layouts.app')
@section('content')
<div class="row ">
    <div class="small-10 columns">
        <div class="row">
            <div class="small-4 columns text-center">
                 @if (empty($customer->logo))
                                       <img style="height: 100px;" src="https://placehold.it/250x100/eeeeee?text=Geen logo" />
                                   @else 
                                    <img style="height: 100px;" src="{{ url('/customerlogos/'. $customer->id . '/' . $customer->logo)}}" />
                                    @endif
                
            </div>
            <div class="small-8 columns align-middle">
                <h2>{{$customer->name}} </h2>
               
            </div>
        </div>
        
    </div>
            <div class="small-2 columns text-right">
               <a class="button" href=" {{url('/customer/'.$customer->id. '/location/create')}}"><i class="fa fa-btn fa fa-plus"></i>Locatie toevoegen</a>
                <a class="button" href=" {{url('/customer/'.$customer->id)}}"><i class="fa fa-btn fa fa-caret-left"></i>Terug naar klant details</a>
            </div>
  
</div>
<hr>

 <div class="row">
            <div class="small-12 columns">
                <h3>Selecteer locatie voor <strong>{{ ucfirst($type) }}</strong> keuring</h3>
            </div>
        </div>

<?php 
foreach ($locations as $location) {

    ?>
    <hr style="height: 1px;">
    <div class="row">
            <div class="small-12 columns">
                <div class="row align-middle">
                    
                    <div class="small-9 columns">
                        <div class="row">
                            <div class="small-12 columns">
                                <a href="{{ url('/customer/' . $customer->id . '/' . $type . '/location/' . $location->id) }}"><h4>{{$location->name}}</h4></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-12 columns">
                                <p>{{$location->street}} {{$location->housenumber}}, {{$location->postalcode}}, {{$location->city}}
                                 <a href="https://www.google.nl/maps/place/{{$location->street}}+{{$location->housenumber}},+{{$location->postalcode}}+{{$location->city}}" target="_blank" class=""><i class="fa fa-map-marker fa-fw"></i>Google Maps</a></p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="small-3 columns">
                         <a href="{{ url('/customer/' . $customer->id . '/' . $type . '/location/' . $location->id) }}" class="button large @if ($type == 'blusmiddelen') alert @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif">Maak Rapport <i class="fa fa-btn fa fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
<?php
}
?>
       
   
@endsection