@extends("layouts.global")

@section("title")
    Detail User
@endsection

@section("content")
    <div class="col-md-10">
        <h3>Detail User</h3>
        <div class="card">
            <div class="card-header bg-info"></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        @if($user->avatar)
                            <img src="{{asset('public/storage/'.$user->avatar)}}" class="img-responsive" style="max-width:350px" height="250px">
                        @else 
                            No avatar
                        @endif
                        <br><br>
                    </div>
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <table class="table  table-striped">
                            <tr>
                                <th>Name</th>
                                <th>{{$user->name}}</th>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <th>{{$user->username}}</th>
                            </tr>
                            <tr>
                                <th>E-mail</th>
                                <th>{{$user->email}}</th>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <th>{{$user->phone}}</th>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <th>{{$user->address}}</th>
                            </tr>
                            <tr>
                                <th>Roles</th>
                                <th>
                                    @foreach(json_decode($user->roles) as $role)
                                        @if($role == "ADMIN")
                                        <span class="badge badge-danger">{{$role}}</span>
                                        @elseif($role == "STAFF")
                                        <span class="badge badge-warning">{{$role}}</span>
                                        @elseif($role == "CUSTOMER")
                                        <span class="badge badge-success">{{$role}}</span>
                                        @endif
                                    @endforeach
                                </th>
                            <tr>
                                <th>Status</th>
                                <th>
                                    @if($user->status == "ACTIVE")
                                        <span class="badge badge-success">{{$user->status}}</span>
                                    @else
                                        <span class="badge badge-danger">{{$user->status}}</span>
                                    @endif
                                </th>
                            </tr>
                            </tr>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection