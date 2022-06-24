<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $message)
    {
        Message::create([
            'user_id' => Auth::id(),
            'subject' => $message->subject,
            'body' => $message->body,
            'sent_to' => $message->sent_to
        ]);
        return back()->with('success', 'Message envoyé avec succès');
    }
}
