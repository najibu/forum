<?php

namespace Tests\Feature;

use App\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /** @test  */
    public function it_checks_for_invalid_keywords()
    {
        // invalid keywords
        // key held down
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException('Exception');

        $spam->detect('yahoo customer support');
    }
}
