<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact()
    {
        return view('shop.contact');
    }

    public function sendMessage(Request $request)
    {
        // return response()->json($request);

        
        // Validate the form data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        // Process the form data (you can customize this part based on your needs)
        // For example, you can send an email
        Mail::to('mubarakolagoke@gmail.com')->send(new \App\Mail\ContactFormSubmitted($request->all()));

        // You can also save the form data to a database if needed

        // Optionally, redirect the user back with a success message
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
