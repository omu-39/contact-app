<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Category;

class ContactController extends Controller
{
    /**
     * お問い合わせフォームの表示
     */
    public function create()
    {
        return view('contact/contact');
    }

    /**
     *  入力内容確認画面の表示
     */
    public function confirm(Request $request)
    {
        $contact = Contact::make($request->all());
        $categories = Category::all();
        return view('contact/confirm', compact('contact', 'categories'));
    }

    public function store(Request $request)
    {
        Contact::create($request->all());
        return view('contact/thanks');
    }

}
