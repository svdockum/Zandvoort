@extends('layouts.app')

@section('content')
 <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}

<div class="container">
  <div class="callout">
                <div class="panel-heading"></div>
                <div class="panel-body">
    <div class="row">
        <div class="small-6 columns">
          
                   
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Adres</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong style="color:red;">{{ $errors->first('email') }}</strong>
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
                                        <strong style="color:red;">{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">Onthouden
                                    </label>
                                </div>
                            </div>
                        </div>

                    
                </div>
        <div class="small-6 columns">
                                <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="button" style="margin-top: 1.6rem;">
                                    <i class="fa fa-btn fa-sign-in"></i>Aanmelden
                                </button>
                                <br>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Wachtwoord vergeten?</a>
                            </div>
                        </div>

        </div>
    </div>
            </div>
        </div>
</div>
</form>
@endsection

