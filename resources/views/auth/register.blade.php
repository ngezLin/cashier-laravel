<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration | Po Depo</title>

    @include('templates.script')

</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="card card-outline card-dark">
        <div class="card-header text-center">
        <a href="#" class="h1"><b>Po</b>Depo</a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">Register</p>

        <!-- Display validation errors if any -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <input id="name-input" type="text" name="name" class="form-control" placeholder="Full name" value="{{ old('name') }}" required autofocus>
            <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input id="email-input" type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
            <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input id="password-input" type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input id="password-confirmation-input" type="password" name="password_confirmation" class="form-control" placeholder="Retype password" required>
            <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <select id="input-role" name="role" class="form-control" required>
            <option value="" disabled selected>Select Role</option>
            {{-- <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option> --}}
            <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
            </select>
        </div>
        <div class="row">
            <div class="col-8">
            <div class="icheck-dark">
                <input type="checkbox" name="terms" id="agreeTerms" value="agree" required>
                <label for="agreeTerms">
                I agree to the <a href="#">terms</a>
                </label>
            </div>
            </div>
            <div class="col-4">
            <button type="submit" class="btn btn-dark btn-block">Register</button>
            </div>
        </div>
        </form>

        <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
    </div>
    </div>
</div>

</body>
</html>
