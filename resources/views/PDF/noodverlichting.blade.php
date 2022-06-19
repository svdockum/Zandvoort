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
	<td style="vertical-align: top;border-right: 1px solid #cccccc">
		<table>
				<tr><td>Uitgevoerd door:</td></tr>
			<tr><td><img src="{{asset('images/zandvoortlogo.jpg')}}" style="height: 110px;margin-top:5px;" ></td></tr>
		</table>	
	</td>
	<td style="vertical-align: top;">
		<table style="margin-left: 20px;">
			<tr><td colspan="2">
			{{$location->name}}<br>
			{{$location->street}} {{$location->housenumber}}, 
			{{$location->postalcode}} {{$location->city}}
			{{$report->name}}
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
	<td style="width:500px;">
		<img src="{{asset('images/noodcert.jpg')}}" style="width: 490px;">
	</td>
	<td>
	<table style="margin-left:30px;">
	<tr>
		<td>Heesterseweg 29</td>
	<td>T: 073 5326018</td>
	</tr>
		<tr>
		<td>5386 KT Geffen</td>
	<td>F: 073 5323986</td>
	</tr>
	<tr>
		<td colspan="2">info@hvanzandvoort-electrotechniek.nl</td>
		</tr>
		<tr><td colspan="2">
			www.hvanzandvoort-electrotechniek.nl</td>
	</tr>
	</table>
</td>
</table>

<div class="page-break"></div>

<div class="landscape"></div>

<table class="border smalltext" style="width: 1000px">
<!-- max 675px -->
<thead> <tr> 
<th style="width: 70px">Pos.</th> 
<th style="width: 65px">Locatie</th> 
<th style="width: 115px">Ruimte</th> 
<th style="width: 115px">Picto</th> 
<th style="width: 115px">Armatuur</th> 
<th style="width: 85px">Montage datum accu</th> 
<th style="width: 130px">Tests</th> 
<th>Opmerkingen</th>
</tr></thead>
<tbody>
@if (!empty($rows))
@foreach ($rows as $row)

<tr @if(!empty($row['ok']) &&  $row['ok'] == 'Ja')) @else style="background-color:#FF695B;" @endif>
<td style="text-align: center;">{{$row['pos']}}</td>
<td>{{$row['etage']}}</td>
<td>{{$row['location']}}</td>
<td>{{$row['picto']}}</td>
<td>{{$row['arm_merk']}}<br>{{$row['arm_type']}}<br>{{$row['arm_nr']}}</td>
<td>{{$row['bat_nr']}}</td>
<td>
<?php if (!empty($row['handtest']) &&  $row['handtest'] == 'Ja') { 
		$yesno = "Ja";
	} 
	else { 
		$yesno = "Nee";
	} ?>

Hand: {{$yesno}}
<br>
<?php if (!empty($row['lbcont_verv']) &&  $row['lbcont_verv'] == 'Ja') { 
		$yesno = "Ja";
	} 
	else { 
		$yesno = "Nee";
	} ?>

Batt verv.: {{$yesno}}
<br>
<?php if (!empty($row['damage']) &&  $row['damage'] == 'Ja') { 
		$yesno = "Ja";
	} 
	else { 
		$yesno = "Nee";
	} ?>
Schade controle: {{$yesno}}
<br>
<?php if (!empty($row['ok']) && $row['ok'] == 'Ja') { 
		$yesno = "Ja";
	} 
	else { 
		$yesno = "Nee";
	} ?>
Goedgekeurd: {{$yesno}}
</td>
<td>{{$row['remarks']}}</td>
</tr>
@endforeach
@endif
</tbody>
</table>
</div>



@endsection