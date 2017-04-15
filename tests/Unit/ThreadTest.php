<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
      parent::setUp();

      $this->thread = factory('App\Thread')->create();
    }

    /** @test  */
    function a_thread_has_replies()
    {
      $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test  */
    function a_thread_has_a_creator()
    {
      $this->assertInstanceOf('App\User', $this->thread->creator);
    } 
}
