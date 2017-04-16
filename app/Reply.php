<?php

namespace App;

use App\Thread;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];
    
    public function thread()
    {
      return $this->belongsTo(Thread::class);
    }

    public function owner()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
}
