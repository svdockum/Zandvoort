@extends('layouts.pdf')
@section('content')

<?php
$username = '';
$customer = App\Customer::find($report->customer_id);
$location = App\Location::find($report->location_id);
$user = App\User::find($report->user_id);
if (empty($user)) {
	$username = '-';
}
else {
	$username = $user->name;
}
?>

<div style="text-align: center;">
<img src="{{asset('images/voorblad-noodverlichting.jpg')}}" style="width: 900px;">
</div>

<table style="margin-left: 50px;">
<tr><td>In opdracht van:</td></tr>
<tr>
			@if (!empty($customer->logo)) 
		<td style="width: 250px;height: 90px">
			<img style="height: 90px;" src="{{ asset('customerlogos/'. $customer->id . '/' . $customer->logo)}}" />
		</td>
		<td style="padding-left: 60px;">
		@else
		<td style="height: 100px">
			@endif
				<span style="font-size: 1.5rem;">{{$customer->name}}</span>
	
</td>
</tr>
</table>


<table style="margin-left: 50px;">
	<tr>
	<td style="width: 250px;vertical-align: top;border-right: 1px solid #cccccc">
		<table>
				<tr><td>Uitgevoerd door:</td></tr>
			<tr><td><img src="{{asset('images/bco.png')}}" style="width: 200px;margin-top:10px;" ></td></tr>
		</table>	
	</td>
	<td style="vertical-align: top;">
		<table style="margin-left: 40px;">
			<tr><td colspan="2">
			{{ $location->name}}<br>
			{{$location->street}} {{$location->housenumber}}, 
			{{$location->postalcode}} {{$location->city}}
			
			</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td style="width: 200px;">Uitvoerdatum</td>
						<td>: {{$report->created_at->format('d-m-Y')}}</td></tr>
						<tr><td style="width: 200px;">Uitgevoerd door</td><td>: <?php

 if (!empty($report->otheruser)) {
    $username = $report->otheruser;
 }
 echo $username;
?>
</td></tr>
						<tr><td style="width: 200px;">Aantal gecontroleerd</td><td>: {{$gecontroleerd}}</td></tr>
						<tr><td style="width: 200px;">Aantal afgekeurd</td><td>: {{$afgekeurd}}</td>
						</tr>
						</table>
	</td>
	</tr>
</table>
<br>
<table style="margin-left: 50px;border-top:1px solid #cccccc;">
<tr><td>&nbsp;</td></tr>
<tr>
<td style="width:250px;">
<img src="{{asset('images/bluscert.jpg')}}" style="width: 200px;">
</td>
<td style="width: 200px;">
<table>
<tr>
<td style="width: 20px;">A:</td>
<td>Galliershof 22</td>
</tr>
<tr>
<td style="width: 20px;"></td>
<td>
	5349 BV Oss
</td>
</tr>
</table>
</td>
<td style="width: 200px;">
<table>
<tr>
<td style="width: 20px;">T:</td>
<td>0412-649120</td>
</tr>
<tr>
<td style="width: 20px;">F:</td>
<td>0412-640493
</td>
</tr>
</table>
</td>
<td style="width: 200px;">
<table>
<tr>
<td style="width: 20px;">E:</td>
<td>info@gijsenadvies.nl</td>
</tr>
<tr>
<td style="width: 20px;">W:</td>
<td>www.gijsenadvies.nl
</td>
</tr>
</table>
</td>
</table>

<div class="page-break"></div>

<div class="landscape"></div>

<table class="border smalltext" style="width: 1000px">
<!-- max 675px -->
<thead> <tr> 
<th style="width: 70px">Volgnr.</th> 
<th style="width: 65px">Verdieping</th> 
<th style="width: 115px">Ruimte</th> 
<th style="width: 130px">Merk/Type/Soort</th> 
<th style="width: 60px">Fab. Jaar Accu</th> 
<th style="width: 60px">LED/TL</th> 
<th style="width: 40px">Volt</th> 
<th style="width: 40px">Amp</th> 
<th style="width: 40px">Watt</th> 
<th style="width: 40px">Perm.</th> 
<th style="width: 40px">Goed?</th> 
<th>Opmerkingen</th>
</tr></thead>
<tbody>
@if (!empty($rows))
@foreach ($rows as $row)

<tr @if(!empty($row['ok']) &&  $row['ok'] == 'Ja')) @else style="background-color:#FF695B;" @endif>
<td style="text-align: center;">{{$row['pos']}}</td>
<td>{{$row['etage']}}</td> 
<td>{{$row['location']}}</td> 
<td>{{$row['arm_merk']}}<br>{{$row['arm_type']}}<br>{{$row['arm_nr']}}</td> 
<td>{{$row['fabaccu']}}</td> 
<td>{{$row['picto']}}</td> 
<td>{{$row['volt']}}</td> 
<td>{{$row['amp']}}</td> 
<td>{{$row['watt']}}</td> 
<td>
<?php if (!empty($row['permanent']) && $row['permanent'] == 'Ja') { 
		$yesno = "Ja";
	} 
	else { 
		$yesno = "Nee";
	} ?>
{{$yesno}}
</td>
<?php if ((!empty($row['yes-no']) &&  $row['yes-no'] == 'Ja') || (!empty($row['yes_no']) &&  $row['yes_no'] == 'Ja') || (!empty($row['ok']) &&  $row['ok'] == 'Ja')) { 
		$yesno = "Ja";
		$color = '#fff';
		$textcolor = '#000';
	$image = 'check.png';
	} 
	else { 
		$yesno = "Nee";
	$color = '#FF7B6A';
	$textcolor = '#fff';
$image = 'notchecked.png';
		} ?>


<td style="text-align: center;"><img src="{{ asset('images/' . $image)}}" style="width: 20px;margin: 5px;" /></td>
<td>{{$row['remarks']}}</td>
</tr>
@endforeach
@endif
</tbody>
</table>
</div>



@endsection