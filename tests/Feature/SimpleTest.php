<?php

namespace Tests\Feature;

use Tests\TestCase;

class SimpleTest extends TestCase
{
    public function test_simple_post(): void
    {
        $response = $this->post('/simple-post');
        $response->assertStatus(405); // Changed from 404 to 405
    }
}
