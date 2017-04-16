<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;


class ParticipateInThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/1/replies', []);
    }

    /** @test  */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
       // Given we have an authenitcated user 
       $user = create('App\User');
       $this->be($user);

       // And an existing thread
       $thread = create('App\Thread');

       // When the user adds a reply to the thread
       $reply = make('App\Reply');
       $this->post($thread->path().'/replies', $reply->toArray());

       // Then their reply should be included on the page.
       $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
