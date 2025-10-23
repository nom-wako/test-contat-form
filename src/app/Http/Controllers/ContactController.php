<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    // お問い合わせフォーム表示
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    // 確認画面表示
    public function confirm(ContactRequest $request)
    {
        $contact = new Contact($request->all());

        // モデルに存在しないtel01-03を追加
        $contact->tel01 = $request->tel01;
        $contact->tel02 = $request->tel02;
        $contact->tel03 = $request->tel03;

        return view('confirm', [
            'contact' => $contact,
            'categories' => Category::all(),
        ]);
    }

    // 完了画面（送信処理）
    public function store(ContactRequest $request)
    {
        // 戻るボタンが押された場合
        if ($request->has('back')) {
            return redirect()->route('index')->withInput($request->except('back'));
        }

        // 電話番号の結合
        $tel = ($request->tel01 ?? '') . ($request->tel02 ?? '') . ($request->tel03 ?? '');

        Contact::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'tel' => $tel,
            'address' => $request->address,
            'building' => $request->building,
            'category_id' => $request->category_id,
            'detail' => $request->detail,
        ]);

        // セッション完了フラグ
        session()->flash('contact_completed', true);

        return redirect()->route('thanks');
    }

    // 完了画面表示
    public function thanks()
    {
        // ページ直アクセスはフォームに戻す
        if (!session('contact_completed')) {
            return redirect('/');
        }

        return view('thanks');
    }
}
