@extends("layouts.global")

@section("title")
    Edit User
@endsection

@section("content")
    <div class="col-md-8">
        <h3>Edit User</h3>
        <form action="{{route('users.update', ['id' => $user->id])}}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
        @csrf
        <input type="hidden" value="PUT" name="_method">

        <label for="name">Name</label>
        <input type="text" name="name" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}" id="name" value="{{old('name') ? old('name') : $user->name}}">
        <div class="invalid-feedback">
            {{$errors->first('name')}}
        </div>
        <br>

        <label for="status">Status</label>
        <br>
        <input {{$user->status == "ACTIVE" ? "checked" : ""}} type="radio" name="status" id="active" value="ACTIVE">
        <label for="active">Active</label>
        <input {{$user->status == "INACTIVE" ? "checked" : ""}} type="radio" name="status" id="inactive" value="INACTIVE">
        <label for="inactive">Inactive</label>
        <br><br>

        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" id="username" value="{{$user->username}}" disabled>
        <br>

        <label for="">Roles</label>
        <br>
        <input type="checkbox" {{in_array("ADMIN", json_decode($user->roles)) ? "checked" : ""}} name="roles[]" class="{{$errors->first('roles') ? 'is-invalid' : ''}}" id="ADMIN" value="ADMIN">
        <label for="ADMIN">Administrator</label>
        <input type="checkbox" {{in_array("STAFF", json_decode($user->roles)) ? "checked" : ""}} name="roles[]" class="{{$errors->first('roles') ? 'is-invalid' : ''}}" id="STAFF" value="STAFF">
        <label for="STAFF">Staff</label>
        <input type="checkbox" name="roles[]" {{in_array("CUSTOMER", json_decode($user->roles)) ? "checked" : ""}} id="CUSTOMER" class="{{$errors->first('name') ? 'is-invalid' : ''}}" value="CUSTOMER">
        <label for="CUSTOMER">Customer</label>
        <div class="invalid-feedback">
            {{$errors->first('roles')}}
        </div>
        <br>

        <br>
        <label for="phone">Phone Number</label>
        <input type="text" name="phone" class="form-control {{$errors->first('phone') ? 'is-invalid' : ''}}" id="phone" value="{{old('phone') ? old('phone') : $user->phone}}">
        <div class="invalid-feedback">
            {{$errors->first('phone')}}
        </div>
        <br>

        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control {{$errors->first('address') ? 'is-invalid' : ''}}">{{old('address') ? old('address') : $user->address}}</textarea>
        <div class="invalid-feedback">
            {{$errors->first('address')}}
        </div>
        <br>

        <label for="avatar">Avatar</label>
        <br>
        Current Avatar : <br>
        @if($user->avatar)
            <img src="{{asset('public/storage/'.$user->avatar)}}" width="120px">
            <br>
        @else
            No Avatar
        @endif
        <br>
        <input type="file" name="avatar" class="form-control" id="avatar">
        <small class="text-muted ">Keep it blank if you don't want to change avatar</small>
        <br>

        <hr class="my-3">

      <label for="email">Email</label>
      <input class="form-control" type="text" name="email" id="email" value="{{$user->email}}" disabled/>
      <br>

      <input class="btn btn-primary float-right" type="submit" value="Save"/>
      <br>
      <br>
    </form>
    <br>
    </div>
@endsection