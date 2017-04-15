<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test  */
    function a_thread_has_replies()
    {
      $thread = factory('App\Thread')->create();

      $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }
}
