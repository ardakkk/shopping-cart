@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            @if(count($errors)>0)
                <div class="alert alert-danger">
                    @foreach($errors as $error)
                        <p>{{$error}}</p>
                    @endforeach
                </div>
            @endif
            <h1>Sign In</h1>
            <form action="{{route('user.signin')}}" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Sign In</button>
                {{csrf_field()}}
            </form>
        </div>
    </div>
@endsection