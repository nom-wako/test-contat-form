@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/components/contact-form.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="section">
  <div class="section__inner">
    <h2 class="heading heading--primary">Contact</h2>
    <form action="/confirm" method="post" class="contact-form">
      @csrf
      <div class="contact-form__group">
        <label for="last_name" class="contact-form__group-title">お名前&nbsp;<span class="contact-form__required">※</span></label>
        <div class="contact-form__group-content contact-form__group-content--name">
          <div class="contact-form__group-child">
            <input type="text" name="last_name" id="last_name" placeholder="例: 山田" value="{{ old('last_name') }}">
            <div class="contact-form__error">
              @error('last_name')
              {{ $message }}
              @enderror
            </div>
          </div>
          <div class="contact-form__group-child">
            <input type="text" name="first_name" id="first_name" placeholder="例: 太郎" value="{{ old('first_name') }}">
            <div class="contact-form__error">
              @error('first_name')
              {{ $message }}
              @enderror
            </div>
          </div>
        </div>
      </div>
      <div class="contact-form__group">
        <div class="contact-form__group-title">性別&nbsp;<span class="contact-form__required">※</span></div>
        <div class="contact-form__group-content contact-form__group-content--gender">
          <div class="contact-form__radio">
            <div class="contact-form__radio-item">
              <input type="radio" name="gender" id="genderChoice01" value="1" {{ old('gender', $contact->gender ?? '') == 1 ? 'checked' : '' }}>
              <label for="genderChoice01">男性</label>
            </div>
            <div class="contact-form__radio-item">
              <input type="radio" name="gender" id="genderChoice02" value="2" {{ old('gender', $contact->gender ?? '') == 2 ? 'checked' : '' }}>
              <label for="genderChoice02">女性</label>
            </div>
            <div class="contact-form__radio-item">
              <input type="radio" name="gender" id="genderChoice03" value="3" {{ old('gender', $contact->gender ?? '') == 3 ? 'checked' : '' }}>
              <label for="genderChoice03">その他</label>
            </div>
          </div>
          <div class="contact-form__error">
            @error('gender')
            {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="contact-form__group">
        <label for="email" class="contact-form__group-title">メールアドレス&nbsp;<span class="contact-form__required">※</span></label>
        <div class="contact-form__group-content">
          <input type="email" name="email" id="email" placeholder="例: test@example.com" value="{{ old('email') }}">
          <div class="contact-form__error">
            @error('email')
            {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="contact-form__group">
        <label for="tel01" class="contact-form__group-title">電話番号&nbsp;<span class="contact-form__required">※</span></label>
        <div class="contact-form__group-content contact-form__group-content--tel">
          <input type="text" name="tel01" id="tel01" placeholder="080" value="{{ old('tel01') }}">
          <span>-</span>
          <input type="text" name="tel02" id="tel02" placeholder="1234" value="{{ old('tel02') }}">
          <span>-</span>
          <input type="text" name="tel03" id="tel03" placeholder="5678" value="{{ old('tel03') }}">
          <div class="contact-form__error">
            @if ($errors->has('tel01') || $errors->has('tel02') || $errors->has('tel03'))
            {{ $message }}
            @endif
          </div>
        </div>
      </div>
      <div class="contact-form__group">
        <label for="address" class="contact-form__group-title">住所&nbsp;<span class="contact-form__required">※</span></label>
        <div class="contact-form__group-content">
          <input type="text" name="address" id="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
          <div class="contact-form__error">
            @error('address')
            {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="contact-form__group">
        <label for="building" class="contact-form__group-title">建物名</label>
        <div class="contact-form__group-content">
          <input type="text" name="building" id="building" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}">
          <div class="contact-form__error">
            @error('building')
            {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="contact-form__group">
        <span class="contact-form__group-title">お問い合わせの種類&nbsp;<span class="contact-form__required">※</span></span>
        <div class="contact-form__group-content">
          <select name="category_id">
            <option value="">選択してください</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
            @endforeach
          </select>
          <div class="contact-form__error">
            @error('category_id')
            {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="contact-form__group">
        <label for="detail" class="contact-form__group-title">お問い合わせ内容&nbsp;<span class="contact-form__required">※</span></label>
        <div class="contact-form__group-content">
          <textarea name="detail" id="detail" placeholder="お問い合わせ内容をご記載ください" value="{{ old('detail') }}"></textarea>
          <div class="contact-form__error">
            @error('detail')
            {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="contact-form__button">
        <button class="contact-form__button-submit" type="submit">確認画面</button>
      </div>
    </form>
  </div>
</div>
@endsection
