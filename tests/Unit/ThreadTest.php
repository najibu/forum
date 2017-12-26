<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test  */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');

        $this->assertEquals(
          "/threads/{$thread->channel->slug}/{$thread->id}",
          $thread->path()
       );
    }

    /** @test  */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test  */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test  */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
        'body' => 'Foobar',
        'user_id' => 1
      ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test  */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /** @test  */
    public function a_thread_can_be_subscribed_to()
    {
        // Given we have a thread
        $thread = create('App\Thread');


        // When the user subscribes to the thread
        $thread->subscribe($userId = 1);

        // then we should be able to fetch all threads that the user has subscribed to.
        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id', $userId)->count()
        );
    }

    /** @test  */
    public function a_thread_can_be_unsubscribed_from()
    {
        // Given we have a thread
        $thread = create('App\Thread');

        // And a user who is  subscribed to the thread
        $thread->subscribe($userId = 1);

        //When a thread is unsubscribed from
        $thread->unsubscribe($userId);

        // The thread should have 0 subscriptions
        $this->assertCount(0, $thread->subscriptions);
    }
}
