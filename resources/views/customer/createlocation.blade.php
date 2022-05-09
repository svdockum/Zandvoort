@extends('layouts.app')

@section('content')
<p>Hier kan je een nieuwe locatie aanmaken voor de klant: <strong>{{ $customer->name }}</strong>.
<br>Als de locatioe al bestaat, controle op naam, dan wordt er niets aangepast en komt er een foutmelding.
</p>
<p style="color:red;">{{ Session::get('error')}}</p>

                    <form class="form-horizontal" method="POST" action="{{ url('/location/add') }}">
                        {!! csrf_field() !!}
<input type="hidden" name="customer_id" value="{{ $customer->id}}"> 
<div class="row">
<div class="small-6 columns">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Locatie naam</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

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
                                <input type="text" class="form-control" name="contactperson" value="{{ old('contactperson') }}">

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
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

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
                                <input type="text" class="form-control" name="phone1" value="{{ old('phone1') }}">

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
                                <input type="text" class="form-control" name="phone2" value="{{ old('phone2') }}">

                                @if ($errors->has('phone2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                   </div>
                   <div class="small-6 columns">


               <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Straat</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="street" value="{{ old('street') }}">

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
                                <input type="text" class="form-control" name="housenumber" value="{{ old('housenumber') }}">

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
                                <input type="text" class="form-control" name="postalcode" value="{{ old('postalcode') }}">

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
                                <input type="text" class="form-control" name="city" value="{{ old('city') }}">

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                         <div class="form-group{{ $errors->has('isKeerBlus') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Is een Keerklep/Blusmiddelen locatie</label>

                            <div class="col-md-6">
                                <input type="checkbox" @if(isset($location) && $location->isKeerBlus) checked @else checked @endif class="form-control" name="isKeerBlus" value="1">

                                @if ($errors->has('isKeerBlus'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('isKeerBlus') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                           <div class="form-group{{ $errors->has('isNood') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Is een Noodverlichting locatie</label>

                            <div class="col-md-6">
                                <input type="checkbox" @if(isset($location) && $location->isNood) checked @endif class="form-control" name="isNood" value="1" >
                            </div>
                        </div>



                    </div>
                    </div>
                    <div class="row">
                    <div class="small-12 columns">


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="button">
                                    <i class="fa fa-btn fa-user"></i>Locatie Aanmaken
                                </button>
                                <br>

                                <button type="button" class="button" onclick="javascript:history.go(-1);return false;">
                                    <i class="fa fa-btn fa fa-caret-left"></i>Terug
                                </button>
                                
                                
                            </div>
                        </div>
                    </form>

                    </div>
                    </div>


@endsection
