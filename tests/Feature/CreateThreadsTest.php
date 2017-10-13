<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test  */
    public function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
             ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test  */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        // Given we have a signed in user
        $this->signIn();

        // When we hit the endpoint to create a new thread
        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        // Then, when we visit the thread page.

        $this->get($response->headers->get('Location'))
      // We should see the new thread
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test  */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
           ->assertSessionHasErrors('title');
    }

    /** @test  */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
           ->assertSessionHasErrors('body');
    }

    /** @test  */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
           ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
           ->assertSessionHasErrors('channel_id');
    }

    /** @test  */
    public function guests_cannot_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $response = $this->delete($thread->path());

        $response->assertRedirect('/login');
    }

    /** @test  */
    public function threads_may_only_be_deleted_by_those_who_have_permission()
    {
        // TODO
    }

    /** @test  */
    public function a_thread_can_be_deleted()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function publishThread($overrides=[])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
