<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * お問い合わせ一覧の表示
     */
    public function index()
    {
        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }

    /**
     * 検索クエリの構築
     */
    private function buildSearchQuery(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->keyword}%")
                    ->orWhere('last_name', 'like', "%{$request->keyword}%")
                    ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$request->keyword}%"])
                    ->orWhere('email', 'like', "%{$request->keyword}%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        return $query;
    }

    /**
     * お問い合わせ検索
     */
    public function search(Request $request)
    {
        $query = $this->buildSearchQuery($request);

        $contacts = $query->with('category')->paginate(7)->appends($request->all());
        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }

    /**
     * 検索リセット
     */
    public function reset()
    {
        return redirect()->route('admin.index');
    }

    /**
     * お問い合わせの削除
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.index')->with('message', 'お問い合わせを削除しました');
    }

    /**
     * お問い合わせ一覧 csvエクスポート
     */
    public function export(Request $request)
    {
        $query = $this->buildSearchQuery($request);
        $contacts = $query->with('category')->get();

        $csvHeader = ['お名前', '性別', 'メールアドレス', 'お問い合わせの種類'];

        $callback = function () use ($contacts, $csvHeader) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $csvHeader);

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->first_name . ' ' . $contact->last_name,
                    $contact->gender_label,
                    $contact->email,
                    $contact->category->content,
                ]);
            }
            fclose($file);
        };

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=contacts_" . date('Ymd') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        return response()->stream($callback, 200, $headers);
    }
}
