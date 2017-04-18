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
        $this->withExceptionHandling()
             ->post('/threads/some-channel/1/replies', [])
             ->assertRedirect('/login');
    }

    /** @test  */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
       // Given we have an authenitcated user 
       $this->signIn();

       // And an existing thread
       $thread = create('App\Thread');

       // When the user adds a reply to the thread
       $reply = create('App\Reply');

       $this->post($thread->path().'/replies', $reply->toArray());

       // Then their reply should be included on the page.
       $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
