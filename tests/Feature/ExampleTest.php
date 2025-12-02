<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_returns_a_successful_response()
    {
        // Akses route yang pasti public & ga redirect
        $response = $this->get('/sanctum/csrf-cookie');
        $response->assertSuccessful();
    }
}