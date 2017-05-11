<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WeatherAPITest extends TestCase
{
    /** @test */
    function can_get_weather()
    {
        $lat = '41.95418449999999';
        $long = '-87.64582589999998';

        $response = $this->json('GET', '/api/weather', compact('lat', 'long'));

        $response->assertStatus(200)
            ->assertJson([
                'city' => 'Birchwood',
            ]);
    }

    /** @test */
    function can_get_forecast()
    {
        $lat = '41.95418449999999';
        $long = '-87.64582589999998';

        $response = $this->json('GET', '/api/forecast', compact('lat', 'long'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'date',
                    'low',
                    'high',
                    'condition',
                    'condition_icon',
                ],
            ]);
    }
}
