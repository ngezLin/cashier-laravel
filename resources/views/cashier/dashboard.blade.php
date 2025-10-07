{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cashier Dashboard</title>
</head>
<body>
    <h2>Welcome to the Cashier Dashboard</h2>

    <p>You are logged in as a <strong>Cashier</strong>.</p>

    <ul>
        <li><a href="{{ route('cashier.transactions.index') }}">Start New Transaction</a></li>
    </ul>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html> --}}

@include('templates.script')
@extends('templates.dashboard')
