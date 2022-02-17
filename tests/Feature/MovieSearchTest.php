<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieSearchTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_should_error_with_no_query()
    {
        $response = $this->getJson('/api/movies/search');
        $response->assertStatus(422);
    }

    /**
     * @test
     * @return void
     */
    public function it_should_provide_one_movie_listing()
    {
        $response = $this->getJson('/api/movies/search?query=fast');
        $response->assertStatus(200);
    }
}
