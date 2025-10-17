@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/components/auth-form.css') }}">
@endsection

@section('content')
<div class="section section--auth-bg">
  <div class="section__inner">
    <h2 class="heading heading--primary">Login</h2>
    <form action="/login" method="post" class="auth-form auth-form--login">
      @csrf
      <div class="auth-form__group">
        <label for="email">メールアドレス</label>
        <input type="text" name="email" id="email" placeholder="例: test@example.com" value="{{ old('email') }}">
        <div class="auth-form__error">
          @error('email')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="auth-form__group">
        <label for="password">パスワード</label>
        <input type="password" name="password" placeholder="例: coachtech1106" id="password">
        <div class="auth-form__error">
          @error('password')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="auth-form__button">
        <button class="auth-form__button-submit" type="submit">ログイン</button>
      </div>
    </form>
  </div>
</div>
@endsection
