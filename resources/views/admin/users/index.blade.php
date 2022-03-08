@extends('layouts.admin')

@section('content')
    <h1>Users</h1>
    <table class="table">
        <thead>
          <tr>
            <th>Id</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>status</th>
            <th>Created</th>
            <th>Updated</th>
          </tr>
        </thead>
        <tbody>

            @if ($users)
                @foreach ($users as $user )
                    <tr>
                        <td>{{$user->id}}</td>
                        {{--  <td>{{$user->photo ? $user->photo->file :"no user photo"}}</td>  --}}
                        {{--  <td><img height="50px" src="{{$user->photo ? $user->photo->file :"no user photo"}}" alt=""></td>  --}}



                        <td><img height="100px" width="100px" src="{{$user->photo ?url('/') . '/images/users/' . $user->photo->file  :'https://via.placeholder.com/100'}}" alt="" class="img-responsive img-rounded"></td>
                        <td> <a href="{{route('users.edit',$user->id)}}">{{$user->name}}</a></td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role ?$user->role->name :"User has no role"}}</td>
                        <td>{{$user->role->name}}</td>
                        <td>{{$user->is_active ==1?'Active':'Not Active'}}</td>
                        <td>{{$user->created_at->diffForHumans()}}</td>
                        <td>{{$user->updated_at->diffForHumans()}}</td>
                    </tr>

                @endforeach
            @endif
        </tbody>
      </table>
@endsection
