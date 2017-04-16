<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;


class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test  */
    function guest_may_not_create_threads()
    {
      $this->expectException('Illuminate\Auth\AuthenticationException');

      $thread = create('App\Thread');

      $this->post('/threads', $thread->toArray());
    } 

    /** @test  */
    function an_authenticated_user_can_create_new_forum_threads()
    {
      // Given we have a signed in user
      $this->actingAs(create('App\User'));

      // When we hit the endpoint to create a new thread
      $thread = make('App\Thread');

      $this->post('/threads', $thread->toArray());
      // Then, when we visit the thread page.
      $this->get($thread->path())
      // We should see the new thread
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    } 
}
