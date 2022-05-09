@extends('layouts.app')

<!-- Main Content -->
@section('content')

<div class="container">
    <div class="row">
        <div class="small-12 columns">
            <div class="callout">
                <div><h3>Wachtwoord opnieuw instellen</h3>
                </div>
                <div class="panel-body">
                   <p>Vul je e-mail adres hieronder in en je krijgt een speciale link om je wachtwoord opnieuw in te stellen.</p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {!! csrf_field() !!}

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

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="button">
                                    <i class="fa fa-btn fa-envelope"></i>Stuur de herstel link via e-mail.
                                </button>
                            </div>
                        </div>
                         @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
