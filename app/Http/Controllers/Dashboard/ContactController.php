<?php

namespace App\Http\Controllers\Dashboard;


use App\Models\Contact;
use Illuminate\Routing\Controller;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_contacts|delete_contacts', ['only' => ['index', 'destroy']]);
        $this->middleware('permission:delete_contacts', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = Contact::latest()->paginate(20);

        return view('dashboard.contacts.index', compact('items'));
    }

    public function show(Contact $contact)
    {
        return view('dashboard.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('dashboard.contacts.index')->with('success', 'تم حذف الرسالة بنجاح');
    }
}
