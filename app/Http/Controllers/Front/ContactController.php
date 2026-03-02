<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($data);

        return back()->with('success', 'تم إرسال رسالتك بنجاح، سنقوم بالرد عليك في أقرب وقت.');
    }
}

