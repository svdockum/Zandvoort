@extends('layouts.app')
@section('content')


<div class="row align-middle" style="margin-top:1rem;">
    <div class="small-12 columns">
        
        <div class="row">
            <div class="small-10 columns"><h2>Overzicht Laatste Rapportages</h2>
            </div>
            <div class="small-2 columns"></div>
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
                     <th class="text-center">Aanp.</th>
                     <th class="text-center">Kopie</th>
                     @if (in_array(\Auth::user()->role,[1]))
                     <th class="text-center">PDF</th>
                      @endif
                     @if (in_array(\Auth::user()->email,['jordi@bcobrandpreventie.nl']) || in_array(\Auth::user()->role,[1]))
                     <th class="text-center">Verw.</th>
                    @endif
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
                    <td><?php $user = App\User::find($report->user_id);  
                        if (!empty($user))echo $user->name; ?></td>
                    <td>{{$report->created_at->format('d-m-Y | H:i')}}</td>
                    <td class="text-center">@if (empty($report->report_ready)) <i class="fa fa-times textred"></i> @else <i class="fa fa-check textgreen"></i> @endif</td>
                    <td class="text-center align-middle" style="padding-top: 1.5rem;">
                    <a class="button" href="{{url('/customer/' . $report->customer_id . '/' . $report->category . '/location/' . $location->id . '/' . $report->id)}}"><i class="fa fa-pencil-square-o"></i></a></td>
                    <td class="text-center align-middle" style="padding-top: 1.5rem;">
                    <a class="button" href="{{ url('/report/replicate/'.$report->id)}}"><i class="fa fa-clone"></i></a></td>
                    @if (in_array(\Auth::user()->role,[1]))
                    <td class="text-center align-middle" style="padding-top: 1.5rem;">
                    <a class="button" href="{{ url('/report/pdf/' . $report->id) }}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                    </td>
                    @endif
                     @if (in_array(\Auth::user()->email,['jordi@bcobrandpreventie.nl']) || in_array(\Auth::user()->role,[1]))
                    <td class="text-center align-middle" style="padding-top: 1.5rem;">
                   <a class="button delete" href="{{url('/report/delete/' . $report->id)}}" ><i class="fa fa-trash"></i></a></td>@endif
                    <!-- <i class="fa fa-check textgreen"></i><i class="fa fa-times textred"></i>
                     --></td>
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

$('.delete').click(function(e){

    var txt;
var r = confirm("Weet je zeker dat je het rapport wil verwijderen?");
if (r == true) {
    //don't do anything
} else {
    e.preventDefault();
}

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