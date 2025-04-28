@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Email Verification Required</h1>
        <p>We have sent a verification email to your address. Please click the link in the email to verify your account.</p>
        <p>If you did not receive the email, you can <a href="{{ route('verification.resend') }}">request another</a>.</p>
    </div>
@endsection
