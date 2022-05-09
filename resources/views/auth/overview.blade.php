@extends('layouts.app')

@section('content')
 <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Aangemaakt op</th>
                    <th>Laatste login</th>
                    <th></th>
                     <th></th>
                </tr>
            </thead>

    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
            <td>{{ $user->last_loggedin->format('d-m-Y H:i') }}</td>
            <td>
                <form action="{{ url('/user/edit/'.$user->id)}}" method="POST"> 
                {{ csrf_field() }}
                <input class="button tiny "type="submit" value="Aanpassen"></input>
                </form>
                </td>
                <td>
                <form action="{{ url('/user/delete/' . $user->id) }}" method="POST"> 
                {{ csrf_field() }}
                <input class="button tiny " type="submit" value="Verwijderen"></input>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

        </table>
    </div>

    <a href="{{ url('/user/create') }}" class="btn btn-success">Gebruiker toevoegen</a>

</div>

@endsection