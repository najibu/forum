<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;


class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test  */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
       // Given we have an authenitcated user 
       $user = factory('App\User')->create();
       $this->be($user);

       // And an existing thread
       $thread = factory('App\Thread')->create();

       // When the user adds a reply to the thread
       $reply = factory('App\Reply')->make();
       $this->post('/threads/'. $thread->id .'/replies', $reply->toArray());

       // Then their reply should be included on the page.
       $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
