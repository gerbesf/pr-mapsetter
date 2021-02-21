@extends('admin.template')
@section('main')

    <div class="row">
        <div class="col-md-6">

            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach

            <div class="">

                <h3>Admin Login</h3>

                <form action="/auth" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark">Log in</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

@endsection
