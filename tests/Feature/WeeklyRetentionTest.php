<?php

namespace Tests\Feature;

use App\FileDataSource;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeeklyRetentionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

	/** @test */
	public function get_data_from_file_data_source()
	{
		$response = $this->get('/weekly_retention');
		$response->assertStatus( 200)
			->assertJsonStructure([
				"err",
				"msg",
				"data" => []
			]);
	}
}
