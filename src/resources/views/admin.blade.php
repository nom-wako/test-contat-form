@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="section">
  <div class="section__inner">
    <h2 class="heading heading--primary">Admin</h2>
    <form action="/admin" method="get" class="admin-search">
      @csrf
      <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="名前やメールアドレスを入力してください">
      <select name="gender">
        <option value="" selected>性別</option>
        <option value="">全て</option>
        <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
        <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
        <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
      </select>
      <select name="category_id">
        <option value="">お問い合わせの種類</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
        @endforeach
      </select>
      <input type="date" name="created_at" value="{{ request('created_at') }}">
      <button class="admin-search__button" type="submit">検索</button>
      <a href="/admin" class="admin-search__button admin-search__button--reset">リセット</a>
    </form>
    <div class="admin-list">
      <div class="admin-list__header">
        <div class="admin-export">
          <a href="" class="admin-export__button">エクスポート</a>
        </div>
        @if ($contacts->hasPages())
        <div class="admin-paginate">
          <ul class="admin-paginate__list">
            @if ($contacts->onFirstPage())
            <li class="admin-paginate__arrow admin-paginate__arrow--prev admin-paginate__arrow--disabled"><span class="admin-paginate__arrow-link">&lt;</span></li>
            @else
            <li class="admin-paginate__arrow admin-paginate__arrow--prev"><a href="{{ $contacts->previousPageUrl() }}" class="admin-paginate__arrow-link">&lt;</a></li>
            @endif
            @foreach ($contacts->getUrlRange(1, $contacts->lastPage()) as $page => $url)
            @if ($page == $contacts->currentPage())
            <li class="admin-paginate__page admin-paginate__page--current"><span class="admin-paginate__page-link">{{ $page }}</span></li>
            @else
            <li class="admin-paginate__page"><a href="{{ $url }}" class="admin-paginate__page-link">{{ $page }}</a></li>
            @endif
            @endforeach
            @if ($contacts->hasMorePages())
            <li class="admin-paginate__arrow admin-paginate__arrow--next"><a href="{{ $contacts->nextPageUrl() }}" class="admin-paginate__arrow-link">&gt;</a></li>
            @else
            <li class="admin-paginate__arrow admin-paginate__arrow--next admin-paginate__arrow--disabled"><span class="admin-paginate__arrow-link">&gt;</span></li>
            @endif
          </ul>
        </div>
        @endif
      </div>
      <div class="admin-list__content">
        <div class="admin-table">
          <div class="admin-table__row admin-table__row--header">
            <p class="admin-table__row-item">お名前</p>
            <p class="admin-table__row-item">性別</p>
            <p class="admin-table__row-item">メールアドレス</p>
            <p class="admin-table__row-item">お問い合わせの種別</p>
            <p class="admin-table__row-item">&nbsp;</p>
          </div>
          @foreach ($contacts as $contact)
          <div class="admin-table__row">
            <p class="admin-table__row-item">{{ $contact->last_name }}　{{ $contact->first_name }}</p>
            <p class="admin-table__row-item">{{ $contact->gender_label }}</p>
            <p class="admin-table__row-item">{{ $contact->email }}</p>
            <p class="admin-table__row-item">{{ $contact->category->content }}</p>
            <p class="admin-table__row-item"><button class="admin-table__detail-button">詳細</button></p>
            <template>
              <div class="admin-more">
                <dl class="admin-more__list">
                  <dt class="admin-more__list-title">お名前</dt>
                  <dd class="admin-more__list-data">{{ $contact->last_name }}　{{ $contact->first_name }}</dd>
                  <dt class="admin-more__list-title">性別</dt>
                  <dd class="admin-more__list-data">{{ $contact->gender_label }}</dd>
                  <dt class="admin-more__list-title">メールアドレス</dt>
                  <dd class="admin-more__list-data">{{ $contact->email }}</dd>
                  <dt class="admin-more__list-title">住所</dt>
                  <dd class="admin-more__list-data">{{ $contact->address }}</dd>
                  <dt class="admin-more__list-title">建物名</dt>
                  <dd class="admin-more__list-data">{{ $contact->building }}</dd>
                  <dt class="admin-more__list-title">お問い合わせの種類</dt>
                  <dd class="admin-more__list-data">{{ $contact->category->content }}</dd>
                  <dt class="admin-more__list-title">お問い合わせ内容</dt>
                  <dd class="admin-more__list-data admin-more__list-data--detail">{!! nl2br(e($contact->detail)) !!}</dd>
                </dl>
                <form action="/delete?id={{ $contact->id }}" method="post">
                  @csrf
                  <button class="admin-more__delete-button" type="submit">削除</button>
                </form>
              </div>
            </template>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <div id="detailModal" class="admin-modal" style="display:none;">
    <div class="admin-modal__content">
      <span id="modalClose" class="admin-modal__close">×</span>
      <div id="modalBody" class="admin-modal__body"></div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('detailModal'),
      modalBody = document.getElementById('modalBody'),
      modalClose = document.getElementById('modalClose');

    // 詳細ボタン
    document.querySelectorAll('.admin-table__detail-button').forEach(detailBtn => {
      detailBtn.addEventListener('click', (e) => {
        const btnRow = detailBtn.closest('.admin-table__row');
        if (!btnRow) return;

        const template = btnRow.querySelector('template');
        if (!template) {
          console.warn('template.not found in row for detail button');
          return;
        }

        const content = template.content.cloneNode(true);
        modalBody.innerHTML = '';
        modalBody.appendChild(content);

        modal.style.display = 'grid';
      });

      // モーダルを閉じる
      modalClose.addEventListener('click', () => {
        modal.style.display = 'none';
      })

      // 背景クリックで閉じる
      modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.style.display = 'none';
      });
    });
  });
</script>
@endsection
