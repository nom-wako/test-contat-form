<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $contacts = $this->applySearchFilters($request)->Paginate(7);

        // お問い合わせ種別の選択肢
        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    // CSVエクスポート機能
    public function exportCsv(Request $request)
    {
        $contacts = $this->applySearchFilters($request)->get();

        // CSV出力
        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $columns = ['ID', '姓', '名', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', 'お問い合わせ内容', '作成日'];

        $callback = function () use ($contacts, $columns) {
            $file = fopen('php://output', 'w');
            // ヘッダー
            fputcsv($file, $columns);

            // データ
            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->first_name,
                    $contact->last_name,
                    match ($contact->gender) {
                        1 => '男性',
                        2 => '女性',
                        3 => 'その他',
                        default => '',
                    },
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    $contact->category?->name ?? '',
                    $contact->detail,
                    $contact->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // 検索条件の共通化
    public function applySearchFilters(Request $request)
    {
        $query = Contact::query();

        // テキスト検索
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            if (preg_match('/^"(.*)"$/', $keyword, $matches)) {
                // 完全一致
                $query->where(function ($q) use ($matches) {
                    $q->where('first_name', $matches[1])->orWhere('last_name', $matches[1])->orWhere('email', $matches[1]);
                });
            } else {
                // 部分一致
                $query->where(function ($q) use ($keyword) {
                    $q->where('first_name', 'like', "%{$keyword}%")->orWhere('last_name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%");
                });
            }
        }

        // 性別検索
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // お問い合わせ種別
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // 日付
        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->input('created_at'));
        }

        return $query;
    }

    // 削除機能
    public function remove(Request $request)
    {
        Contact::find($request->id)->delete();
        return redirect('/admin');
    }
}
