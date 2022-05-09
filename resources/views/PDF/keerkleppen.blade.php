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
<img src="{{asset('images/voorblad-keerkleppen.jpg')}}" style="width: 900px;">
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
			<tr><td><img src="{{asset('images/advies.png')}}" style="width: 200px;margin-top:10px;" ></td></tr>
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

<table class="border smalltext" style="width: 1000px;font-size: 9px;">
<!-- max 675px -->
<thead> <tr> 
<th style="width: 25px">Pos.</th> 
<th style="width: 35px">Etage</th> 
<th style="width: 85px">Ruimte</th> 
<th style="width: 115px">Toestel</th> 
<th style="width: 60px">Bev.</th> 
<th style="width: 60px">Plaats bev.</th> 
<th style="width: 30px">Fitting</th>
<th style="width: 25px;text-align: center;">Ø</th> 
<th style="width: 30px;text-align: center;">Drukvast</th> 
<th style="width: 85px;text-align: center;">Resultaat</th> 
<th>Opmerkingen</th>
</tr></thead>
<tbody>
@if (!empty($rows))
@foreach ($rows as $row)

<tr>
<td style="text-align: center;">{{$row['pos']}}</td>
<td>{{$row['etage']}}</td>
<td>{{$row['location']}}</td>
<td>{{$row['brand']}}</td>
<td>{{$row['type']}}</td>
<td>{{$row['result']}}</td>
<td>{{$row['fabrication_year']}}</td>
<td style="text-align: center;">{{$row['diameter']}}</td>
<?php if (!empty($row['drukvast']) &&  $row['drukvast'] == 'Ja') { 
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

<!--<td style="text-align:center;background-color: {{$color}};color: {{$textcolor}}">{{ $yesno}}</td> -->

<td style="text-align: center;"><img src="{{ asset('images/' . $image)}}" style="width: 20px;margin: 5px;" /></td>

<?php if ((!empty($row['yes-no']) &&  $row['yes-no'] == 'Ja') || (!empty($row['yes_no']) &&  $row['yes_no'] == 'Ja')) { 
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

<!--<td style="text-align:center;background-color: {{$color}};color: {{$textcolor}}">{{ $yesno}}</td>-->
<td style="text-align: center;"><img src="{{ asset('images/' . $image)}}" style="width: 20px;margin: 5px;" /></td>
<td>{{$row['remarks']}}</td>
</tr>
@endforeach
@endif
</tbody>
</table>
</div>



@endsection