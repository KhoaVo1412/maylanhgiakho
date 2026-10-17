<?php

namespace App\Http\Controllers;

use App\Http\Services\ContactService;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contactservice;
    public function __construct(ContactService $contactservice)
    {
        $this->contactservice = $contactservice;
    }

    public function index()
    {
        return view('contact');
    }

    public function addContact(Request $request)
    {
        //cach1
        // $contact = new Contact;
        // $contact->name = $request->input('ten');
        // $contact->address = $request->input('diachi');
        // $contact->phone = $request->input('dienthoai');
        // $contact->email = $request->input('email');
        // $contact->title = $request->input('tieude');
        // $contact->content = $request->input('noidung');
        // $contact->save(); 
        
        //cach2
        $this->contactservice->addContactsv($request);
        return view('contact');
    }
}