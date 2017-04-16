<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function store(Thread $thread)
    {
      $thread->addReply([
        'body' => request('body'),
        'user_id' => auth()->id()
      ]);

      return back();
    }
}
