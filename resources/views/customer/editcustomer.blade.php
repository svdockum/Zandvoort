@extends('layouts.app')

@section('content')
<h4>Aanpassen klant: {{$customer->name}}
</h4>
<p style="color:red;">{{ Session::get('error')}}</p>


                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ url('/customer/update/' . $customer->id) }}">
                        {!! csrf_field() !!}

<div class="row">
<div class="small-6 columns">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Klantnaam</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ $customer->name }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('contactperson') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Contact persoon</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="contactperson" value="{{ $customer->contactperson }}">

                                @if ($errors->has('contactperson'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contactperson') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Adres</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ $customer->email1 }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                          <div class="form-group{{ $errors->has('phone1') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Telefoon nummer</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="phone1" value="{{ $customer->phone1 }}">

                                @if ($errors->has('phone1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('phone2') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Mobiel</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="phone2" value="{{ $customer->phone2 }}">

                                @if ($errors->has('phone2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('isNood') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Noodverlichting</label>

                            <div class="col-md-6">
                                <input type="checkbox" @if($customer->isNood) checked @endif class="form-control" name="isNood" value="1" >
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('isAlarm') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Alarm</label>

                            <div class="col-md-6">
                                <input type="checkbox" @if($customer->isAlarm) checked @endif class="form-control" name="isAlarm" value="1" >
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('isBMI') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">BMI</label>

                            <div class="col-md-6">
                                <input type="checkbox" @if($customer->isBMI) checked @endif class="form-control" name="isBMI" value="1" >
                            </div>
                        </div>
                      
                          
                   </div>



                   <div class="small-6 columns">


               <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Straat</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="street" value="{{ $customer->street }}">

                                @if ($errors->has('street'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('street') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('housenumber') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Huisnummer</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="housenumber" value="{{ $customer->housenumber }}">

                                @if ($errors->has('housenumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('housenumber') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('postalcode') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Postcode</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="postalcode" value="{{ $customer->postalcode }}">

                                @if ($errors->has('postalcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('postalcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                      
                          <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Plaats</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="city" value="{{ $customer->city }}">

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                       
                          
                  <div class="form-group{{ $errors->has('werknummer') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Werknummer</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="werknummer" value="{{ old('werknummer') }}">

                                @if ($errors->has('werknummer'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('werknummer') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       
                        <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Logo</label>
                           @if (empty($customer->logo))
                                       <img style="height: 100px;" src="https://placehold.it/250x100/eeeeee?text=Geen logo" />
                                   @else 
                                    <img style="height: 100px;" src="{{ 'customerlogos/'. $customer->id . '/' . $customer->logo}}" />
                                    @endif

                            <div class="col-md-6">
                                <input type="file" class="form-control" name="logo" value="{{ $customer->logo }}">

                                @if ($errors->has('logo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                    </div>
                    </div>
                    <div class="row" style="margin-top: 2rem;">
                    <div class="small-10 columns">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="button">
                                    <i class="fa fa-btn fa-user"></i>Klant Aanpassen
                                </button>
                                                            
                                 
                                <a href="#" class="button back">
                                    <i class="fa fa-btn fa fa-caret-left"></i>Terug
                                </a><br><br><br>
                                @if (in_array(\Auth::user()->role,[1]))
                    <a href="{{url('/customer/delete/' . $customer->id)}}" class="button delete" id="delete">
                                    <i class="fa fa-btn fa-trash"></i>Klant verwijderen
                                </a>@endif
                            </div>
                        </div>
                    </form>

                    </div>
                    <div class="small-2 columns">
                                </div>
                    </div>
@endsection

@section('scripts')

<script>

$('.delete').click(function(e){

    var txt;
var r = confirm("Weet je zeker dat je deze klant wil verwijderen?");
if (r == true) {
    //don't do anything
} else {
    e.preventDefault();
}

});

$('.back').click(function(e){
    e.preventDefault();

    //redirect back
    var url = '<?php echo url('/customer/'. $customer->id);?>';
    window.location.href = url;
});
</script>

@endsection