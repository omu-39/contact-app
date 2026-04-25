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

        return view('contact.contact', compact('categories'));
    }

    /**
     * 確認画面の表示
     */
    public function confirm(ContactRequest $request)
    {
        $validated = $request->validated();

        $contact = new Contact($validated);

        return view('contact.confirm', compact('contact'));
    }

    /**
     * DBに保存
     */
    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

        Contact::create($validated);

        return redirect()->route('contact.thanks');
    }
}
