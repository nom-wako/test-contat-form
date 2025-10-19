@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/components/contact-form.css') }}">
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="section">
  <div class="section__inner">
    <h2 class="heading heading--primary">Confirm</h2>
    <form action="{{ route('store') }}" method="post" class="contact-form contact-form--confirm">
      @csrf
      <dl class="confirm-table">
        <dt class="confirm-table__title">お名前</dt>
        <dd class="confirm-table__content">{{ $contact['last_name'] }}　{{ $contact['first_name'] }}<input type="hidden" name="first_name" value="{{ $contact['first_name'] }}"><input type="hidden" name="last_name" value="{{ $contact['last_name'] }}"></dd>
        <dt class="confirm-table__title">性別</dt>
        <dd class="confirm-table__content">{{ $contact['gender_label'] }}<input type="hidden" name="gender" value="{{ $contact['gender'] }}"></dd>
        <dt class="confirm-table__title">メールアドレス</dt>
        <dd class="confirm-table__content">{{ $contact['email'] }}<input type="hidden" name="email" value="{{ $contact['email'] }}"></dd>
        <dt class="confirm-table__title">電話番号</dt>
        <dd class="confirm-table__content">{{ $contact['tel01'] }}-{{ $contact['tel02'] }}-{{ $contact['tel03'] }}<input type="hidden" name="tel01" value="{{ $contact['tel01'] }}"><input type="hidden" name="tel02" value="{{ $contact['tel02'] }}"><input type="hidden" name="tel03" value="{{ $contact['tel03'] }}"></dd>
        <dt class="confirm-table__title">住所</dt>
        <dd class="confirm-table__content">{{ $contact['address'] }}<input type="hidden" name="address" value="{{ $contact['address'] }}"></dd>
        <dt class="confirm-table__title">建物名</dt>
        <dd class="confirm-table__content">{{ $contact['building'] }}<input type="hidden" name="building" value="{{ $contact['building'] }}"></dd>
        <dt class="confirm-table__title">お問い合わせの種類</dt>
        <dd class="confirm-table__content">{{ $contact->category->content }}<input type="hidden" name="category_id" value="{{ $contact['category_id'] }}"></dd>
        <dt class="confirm-table__title">お問い合わせ内容</dt>
        <dd class="confirm-table__content">{{ $contact['detail'] }}<input type="hidden" name="detail" value="{{ $contact['detail'] }}"></dd>
      </dl>
      <div class="contact-form__button contact-form__button--confirm">
        <button class="contact-form__button-submit" type="submit">送信</button>
        <button class="contact-form__button-back" name="back" type="submit">修正</button>
      </div>
    </form>
  </div>
</div>
@endsection
