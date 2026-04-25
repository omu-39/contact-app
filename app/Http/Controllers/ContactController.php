<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * お問い合わせフォームを表示
     */
    public function create()
    {
        return view('contact.contact');
    }

    /**
     * 確認画面の表示
     */
    public function confirm(Request $request)
    {
        $validated = 
    }
}
