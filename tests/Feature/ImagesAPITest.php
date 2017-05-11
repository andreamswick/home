<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ImagesAPITest extends TestCase
{
    /** @test */
    function can_get_images()
    {
        // Arrange
        $response = $this->json('GET', '/api/images');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'image'
                ]
            ]);
    }
}
