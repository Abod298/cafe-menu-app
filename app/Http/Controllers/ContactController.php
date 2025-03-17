<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /*
    The Contact Information Controller is intentionally left empty in this project
    to allow viewers to practice and work with it
    in a way similar to the other models and controllers.
    This provides an opportunity for hands-on experience,
    helping them understand how to implement and integrate controllers,
    models, and related features, gates, and permissions,
    just like in the rest of the project
    */

    /*
    İletişim Bilgileri Kontrolcüsü, bu projede izleyicilerin diğer modeller
    ve kontrolcülerle benzer şekilde pratik yapabilmesi için kasıtlı
    olarak boş bırakılmıştır. Bu, onlara kontrolcüler, modeller ve ilgili özellikler,
    geçitler ve izinleri nasıl uygulayıp entegre edebileceklerini anlamaları
    için bir fırsat sağlar.
    */

    public function index()
    {
        //
    }
    public function create(Contact $contact)
    {
        //
    }
    public function store(Request $request)
    {
        return Contact::create($request->all());
    }
    public function show(Contact $contact)
    {
        return $contact;
    }
    public function edit(Contact $contact)
    {
        //
    }
    public function update(Request $request, Contact $contact)
    {
        $contact->update($request->all());
        return $contact;
    }
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json(null, 204);
    }
}
