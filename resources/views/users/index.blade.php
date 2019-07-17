@extends("layouts.global")

@section("title")
    Users List 
@endsection

@section("content")
    <div class="col-md-12">
        <h3>List Users</h3>
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif 
        <br>
        <div class="row">
            <div class="col-md-6">
                <a href="{{route('users.create')}}" class="btn btn-primary"> <i class="fas fa-plus" aria-hidden="true"></i> Add New User</a>
            </div>
            <div class="col-md-6">
                <form action="{{route('users.index')}}">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="keyword" class="form-control" value="{{Request::get('keyword')}}" placeholder="Find All Data">
                        </div>
                        <div class="col-md-6">
                            <input {{Request::get('status') == 'ACTIVE' ? 'checked' : ''}} type="radio" name="status" id="active" value="ACTIVE">
                            <label for="active">Active</label>
                            <input {{Request::get('status') == 'INACTIVE' ? 'checked' : ''}} type="radio" name="status" id="inactive" value="INACTIVE">
                            <label for="inactive">Inactive</label>
                            <input type="submit" value="Filter" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <br>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><b>No</b></th>
                    <th><b>Name</b></th>
                    <th><b>Username</b></th>
                    <th><b>Email</b></th>
                    <th><b>Avatar</b></th>
                    <th><b>Status</b></th>
                    <th><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($users as $user)
                <tr>
                    <td>{{$no}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @if($user->avatar)
                        <img src="{{asset('public/storage/'.$user->avatar)}}" width="70px">
                        @else 
                            No Avatar
                        @endif
                    </td>
                    <td>
                        @if($user->status == "ACTIVE")
                            <span class="badge badge-success">{{$user->status}}</span>
                        @else
                            <span class="badge badge-danger">{{$user->status}}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('users.edit',['id'=>$user->id])}}" class="btn btn-info btn-sm text-white"><i class="fa fa-edit"></i> Edit</a>
                        <form action="{{route('users.destroy',['id' => $user->id])}}" onsubmit="return confirm('Delete this user permanently?')" class="d-inline" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                        <a href="{{route('users.show', ['id' => $user->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-address-card"></i> Detail</a>
                    </td>
                </tr>
                <?php $no++ ?>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan=10>
                        {{$users->appends(Request::all())->links()}}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection