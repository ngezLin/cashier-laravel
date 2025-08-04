<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Po Depo</title>

    @include('templates.script')

</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-dark">
    <div class="card-header text-center">
        <a href="#" class="h1"><b>Po</b>Depo</a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" required autofocus>
            <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
            <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">
                Remember Me
                </label>
            </div>
            </div>
            <div class="col-4">
            <button type="submit" class="btn btn-dark btn-block">Sign In</button>
            </div>
        </div>
        </form>

        <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">Register</a>
        </p>
    </div>
    </div>
</div>

</body>
</html>
