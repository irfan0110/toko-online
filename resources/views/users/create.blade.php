@extends("layouts.global")

@section("title") 
    Create Users 
@endsection

@section("content")
    <div class="col-md-8">
    <h3>Create New Users</h3>
    <form action="{{route("users.store")}}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}" id="name" placeholder="Full Name" value="{{old('name')}}">
        <div class="invalid-feedback">   
            {{$errors->first('name')}} 
        </div> 
        <br>

        <label for="username">Username</label>
        <input type="text" name="username" class="form-control {{$errors->first('username') ? 'is-invalid' : ''}}" id="username" placeholder="Username" value="{{old('username')}}">
        <div class="invalid-feedback">   
            {{$errors->first('username')}} 
        </div>
        <br>

        <label for="">Roles</label>
        <br>
        <input class ="{{$errors->first('roles') ? 'is-invalid' : ''}}" type="checkbox" name="roles[]" id="ADMIN" value="ADMIN">
        <label for="ADMIN">Administrator</label>
        <input class="{{$errors->first('roles') ? 'is-invalid' : ''}}" type="checkbox" name="roles[]" id="STAFF" value="STAFF">
        <label for="STAFF">Staff</label>
        <input class="{{$errors->first('roles') ? 'is-invalid' : ''}}" type="checkbox" name="roles[]" id="CUSTOMER" value="CUSTOMER">
        <label for="CUSTOMER">Customer</label>
        <div class="invalid-feedback">   
            {{$errors->first('roles')}} 
        </div>
        <br>

        <br>
        <label for="phone">Phone Number</label>
        <input type="text" name="phone" class="form-control {{$errors->first('phone') ? 'is-invalid' : ''}}" id="phone" placeholder="Phone Number" value="{{old('phone')}}">
        <div class="invalid-feedback">   
            {{$errors->first('phone')}} 
        </div>
        <br>

        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control {{$errors->first('address') ? 'is-invalid' : ''}}">{{old('address')}}</textarea>
        <div class="invalid-feedback">   
            {{$errors->first('address')}} 
        </div>
        <br>

        <label for="avatar">Avatar</label>
        <br>
        <input type="file" name="avatar" class="form-control" id="avatar">
        <br>

        <hr class="my-3">

      <label for="email">Email</label>
      <input class="form-control {{$errors->first('email') ? 'is-invalid' : ''}}" placeholder="user@mail.com" type="text" name="email" id="email" value="{{old('email')}}"/>
      <div class="invalid-feedback">   
            {{$errors->first('email')}} 
        </div>
      <br>

      <label for="password">Password</label>
      <input class="form-control {{$errors->first('password') ? 'is-invalid' : ''}}" placeholder="password" type="password" name="password" id="password"/>
      <div class="invalid-feedback">   
            {{$errors->first('password')}} 
        </div>
      <br>

      <label for="password_confirmation">Password Confirmation</label>
      <input class="form-control {{$errors->first('password_confirmation') ? 'is-invalid' : ''}}" placeholder="password confirmation" type="password" name="password_confirmation" id="password_confirmation"/>
      <div class="invalid-feedback">   
            {{$errors->first('password_confirmation')}} 
        </div>
      <br>

      <input class="btn btn-primary float-right" type="submit" value="Save"/>
      <br>
      <br>
    </form>
    <br>
    </div>
    
@endsection