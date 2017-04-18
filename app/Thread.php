<?php

namespace App;

use App\Reply;
use App\Channel;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{ 

    protected $guarded = [];
    
    /**
     * Fetch a path to the current thread.
     * 
     * @return string
     */
    public function path()
    {
      return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
      return $this->hasMany(Reply::class);
    }

    public function creator()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
      return $this->belongsTo(Channel::class);
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
