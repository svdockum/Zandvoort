@extends('layouts.app_forcustomer')
@section('content')
<div class="row ">
    <div class="small-10 columns">
        <div class="row">
            <div class="small-4 medium-4 medium-4 columns text-center">
                @if (empty($customer->logo))
                                       <img style="height: 100px;" src="https://placehold.it/250x100/eeeeee?text=Geen logo" />
                                   @else 
                                    <img style="height: 100px;" src="{{ asset('customerlogos/'. $customer->id . '/' . $customer->logo)}}" />
                                    @endif
                
            </div>
            <div class="small-8 columns align-middle">
                <h3>{{$customer->name}} </h3>
                <label for="locations">Selecteer locatie</label>
                <select id="locations">
                <option value="0" disabled selected value></option>
                <option value="-1">Alles</option>
                 @foreach ($locations as $location)

                     <option value="{{$location->id}}">{{$location->name}}</option>
                
                 @endforeach
                 </select>
            </div>
        </div>
        
    </div>
   

    <!-- <div class="small-2 columns align-middle text-right">
    <a href=" {{url('/customer/'.$customer->id. '/location/list')}}" class="button" style="width: 100%"><i class="fa fa-map-marker fa-fw"></i>Locaties</a>
    -->
</div>


<div class="row align-middle" style="margin-top:1rem;">
    <div class="small-12 columns">
        
        <div class="row">
            <div class="small-2 columns"><h2>Overzicht</h2>
            </div>
            <div class="small-10 columns"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="small-12 columns">
        <input type="text" id="search" placeholder="Zoek op straatnaam, postcode, plaats en aanmaak datum...">
        <table id="overview">
            <thead>
                <tr>
                    <th class="text-center">Type</th>
                    <th class="text-center">Jaar</th>
                    <th style="width: 200px;">Locatie</th>
                    <th>Gemaakt door</th>
                    <th>Aanmaak datum</th>
                     <th class="text-center">Gereed</th>
                    
                     <th class="text-center">PDF</th>
                    
                </tr>
            </thead>
            <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td class="text-center">
                        @if ($report->category == 'blusmiddelen')
                        <span class="fa-stack fa-lg textred">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-fire-extinguisher"></i>
                        </span>
                        @endif
                        @if ($report->category == 'keerkleppen')
                        <span class="fa-stack fa-lg textblue">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-code-fork" style="margin-left: 2px;"></i>
                        </span>
                        @endif
                         @if ($report->category == 'noodverlichting')
                        <span class="fa-stack fa-lg textgreen">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-lightbulb-o" style="margin-left: 1px;"></i>
                        </span>
                        @endif
                    </td>
                    <td class="text-center">{{$report->created_at->format('Y')}}</td>
                    <?php
                   
                    $location = App\Location::find($report->location_id);
                    ?>
                    <td>{{$location->name}}<br><small>{{$location->street}} {{$location->housenumber}} {{$location->city}}
                    </small></td>
                    <td><?php 
$username = \App\User::find($report->user_id)->name;
 if (!empty($report->otheruser)) {
    $username = $report->otheruser;
 }
 echo $username;
                        ?></td>
                    <td>{{$report->created_at->format('d-m-Y | H:i')}}</td>
                    <td class="text-center">@if (empty($report->report_ready)) <i class="fa fa-times textred"></i> @else <i class="fa fa-check textgreen"></i> @endif</td>
                  
                    <td class="text-center align-middle" style="padding-top: 1.5rem;">
                    <a class="button" href="{{ url('/report/pdf/' . $report->id) }}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                    </td>
                   
                </tr>
               @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')

<script>

new Tablesort(document.getElementById('overview'));

$('#locations').select2({ 
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

$('#locations').on('select2:select',function(){

      location.href = '<?php echo url('/klant/') ?>/' + $(this).val() ;

});

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