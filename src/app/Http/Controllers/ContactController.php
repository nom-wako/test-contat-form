<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    // お問い合わせフォーム表示
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    // 確認画面表示
    public function confirm(Request $request)
    {
        $contact = new Contact($request->all());

        // 電話番号の結合
        $contact['tel'] = ($request->tel01 ?? '') . ($request->tel02 ?? '') . ($request->tel03 ?? '');
        unset($contact['tel01'], $contact['tel02'], $contact['tel03']);

        return view('confirm', [
            'contact' => $contact,
            'categories' => Category::all(),
        ]);
    }

    // 完了画面（送信処理）
    public function store(Request $request)
    {
        // 戻るボタンが押された場合
        if ($request->has('back')) {
            return redirect('/')->withInput($request->except('back'));
        }

        Contact::create($request->only(['name', 'gender', 'email', 'tel', 'address', 'building', 'category_id', 'detail']));
        return view('thanks');
    }
}
