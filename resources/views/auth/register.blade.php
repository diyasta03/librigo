{{-- resources/views/auth/register.blade.php --}}

@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div style="max-width: 400px; margin: 2rem auto;">
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

    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Header -->
        <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Daftar Akun Baru</h2>

        <!-- Name Field -->
        <div style="margin-bottom: 1rem;">
            <label for="name" style="display: block; margin-bottom: 0.5rem;">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 6px;">
        </div>

        <!-- Email Field -->
        <div style="margin-bottom: 1rem;">
            <label for="email" style="display: block; margin-bottom: 0.5rem;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 6px;">
        </div>

        <!-- Password Field -->
        <div style="margin-bottom: 1rem;">
            <label for="password" style="display: block; margin-bottom: 0.5rem;">Password</label>
            <input id="password" type="password" name="password" required
                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 6px;">
        </div>

        <!-- Confirm Password Field -->
        <div style="margin-bottom: 1rem;">
            <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem;">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 6px;">
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                style="width: 100%; background-color: #2563eb; color: white; padding: 0.75rem; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
                Daftar
            </button>
        </div>
    </form>

    <!-- Login Link -->
    <div style="margin-top: 1.5rem; text-align: center;">
        <span>Sudah punya akun?</span>
        <a href="{{ route('login') }}" style="color: #2563eb; font-weight: bold; text-decoration: none;">
            Masuk Sekarang
        </a>
    </div>
</div>
@endsection
