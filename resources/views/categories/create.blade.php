@extends("layouts.global")

@section("title")
    Create Categories
@endsection

@section("content")
    <div class="col-md-8">
        <h3>Create Categories</h3>
        <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
            @csrf
            <label for="name">Category Name</label>
            <input type="text" name="name" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}" value="{{old('name')}}">
            <div class="invalid-feedback">
                {{$errors->first('name')}}
            </div>
            <br>

            <label for="image">Category Image</label>
            <input type="file" name="image" id="image" class="form-control {{$errors->first('image') ? 'is-invalid' : ''}}">
            <div class="invalid-feedback">
                {{$errors->first('image')}}
            </div>
            <br>

            <input type="submit" class="btn btn-primary btn-sm float-right" value="Save">
            <br><br>
        </form>
        <br>
    </div>
@endsection