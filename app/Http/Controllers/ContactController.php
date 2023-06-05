<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\Contact;
use App\Mail\ContactForm;

use \Firebase\JWT\JWT;

define('JWT_KEY','###'); // my zendesk web widget jwt key


class ContactController extends Controller
{
    public function create()
    {
        $payload = [
            'name' => 'shimano' ,
            'email' => 'test@test',
            'iat' => time(),
            'external_id' => '1'
        ];
        $jwt_token = JWT::encode($payload, JWT_KEY, 'HS256');
        // print_r($jwt_token);

        return view('contact.create', compact('jwt_token'));
    }

    public function store(Request $request)
    {
        $inputs = request()->validate([
            'title' => 'required|max:255',
            'email'=> 'required|email|max:255',
            'body' => 'required|max:1000',
        ]);

        Contact::create($inputs);

        Mail::to(config('mail.admin'))->send(new ContactForm($inputs));
        Mail::to($inputs['email'])->send(new ContactForm($inputs));

        return back()->with('message', 'メールを送信したのでご確認ください');
    }
}
