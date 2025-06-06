{{-- resources/views/auth/login.blade.php --}}

@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div style="max-width: 400px; margin: 2rem auto;">
    <!-- Status Message -->
    @if (session('status'))
        <div style="margin-bottom: 1rem; color: green;">
            {{ session('status') }}
        </div>
    @endif

    <!-- Error Validation -->
    @if ($errors->any())
        <div style="margin-bottom: 1rem; color: red;">
            <ul style="padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Header -->
        <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Login</h2>

        <!-- Email Field -->
        <div style="margin-bottom: 1rem;">
            <label for="email" style="display: block; margin-bottom: 0.5rem;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 6px;">
        </div>

        <!-- Password Field -->
        <div style="margin-bottom: 1rem;">
            <label for="password" style="display: block; margin-bottom: 0.5rem;">Password</label>
            <input id="password" type="password" name="password" required
                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 6px;">
        </div>

        <!-- Remember Me Checkbox -->
        <div style="margin-bottom: 1rem;">
            <label style="display: flex; align-items: center;">
                <input type="checkbox" name="remember" style="margin-right: 0.5rem;">
                <span>Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                style="width: 100%; background-color: #2563eb; color: white; padding: 0.75rem; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
                Masuk
            </button>
        </div>
    </form>

    <!-- Register Link -->
    <div style="margin-top: 1.5rem; text-align: center;">
        <span>Belum punya akun?</span>
        <a href="{{ route('register') }}" style="color: #2563eb; font-weight: bold; text-decoration: none;">
            Daftar Sekarang
        </a>
    </div>
</div>
@endsection
