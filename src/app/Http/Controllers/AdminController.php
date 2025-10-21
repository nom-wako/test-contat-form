<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::query();

        // テキスト検索
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            if (preg_match('/^"(.*)"$/', $keyword, $matches)) {
                // 完全一致
                $contacts->where(function ($q) use ($matches) {
                    $q->where('first_name', $matches[1])->orWhere('last_name', $matches[1])->orWhere('email', $matches[1]);
                });
            } else {
                // 部分一致
                $contacts->where(function ($q) use ($keyword) {
                    $q->where('first_name', 'like', "%{$keyword}%")->orWhere('last_name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%");
                });
            }
        }

        // 性別検索
        if ($request->filled('gender')) {
            $contacts->where('gender', $request->input('gender'));
        }

        // お問い合わせ種別
        if ($request->filled('category_id')) {
            $contacts->where('category_id', $request->input('category_id'));
        }

        // 日付
        if ($request->filled('created_at')) {
            $contacts->whereDate('created_at', $request->input('created_at'));
        }

        // ページネーション
        $contacts = $contacts->Paginate(7);

        // お問い合わせ種別の選択肢
        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    // 削除機能
    public function remove(Request $request)
    {
        Contact::find($request->id)->delete();
        return redirect('/admin');
    }
}
