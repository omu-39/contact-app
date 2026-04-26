<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * お問い合わせフォームを表示
     */
    public function create()
    {
        $categories = Category::orderBy('id')->get();

        return view('contact.create', compact('categories'));
    }

    /**
     * 確認画面の表示
     */
    public function confirm(ContactRequest $request)
    {
        $validated = $request->validated();

        session(['inputs' => $validated]);

        $contact = new Contact($validated);

        return view('contact.confirm', compact('contact'));
    }

    /**
     * サンクスページ表示 / DBに保存
     */
    public function store(Request $request)
    {
        $inputs = session('inputs');

        if ($request->has('back')) {
            return redirect()->route('contact.create')->withInput($inputs);
        }

        Contact::create($inputs);

        return redirect()->route('contact.thanks');
    }
}
