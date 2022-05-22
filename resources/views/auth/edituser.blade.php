@extends('layouts.app')

@section('content')
<p>Pas de gegevens van de gebruiker aan. Het wachtwoord veld kan je leeglaten als je dat niet wil aanpassen.</p>
                    <form class="form-horizontal" method="POST" action="{{ url('/user/update/' . $user->id) }}">
                        {!! csrf_field() !!}
                        <input type="hidden" value="/user/overview" name="redirect"></input>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Naam</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Adres</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Wachtwoord</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Wachtwoord herhalen</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Type gebruiker</label>

                            <div class="col-md-6">
                                <select name="role" id="role">
                                    <option value="3" <?php if ($user->role == 3) echo 'selected'; ?>>Gebruiker</option>
                                    <option value="1" <?php if ($user->role == 1) echo 'selected';?>>Beheerder</option>
                                </select>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="button">
                                    <i class="fa fa-btn fa-user"></i>Gebruiker aanpassen
                                </button>
                                 <a href="{{ url('/user/overview')}}" class="button"><i class="fa fa-btn fa fa-caret-left"></i>Terug naar Overzicht</a>
                            </div>
                        </div>
                    </form>
@endsection
