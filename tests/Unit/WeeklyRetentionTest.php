<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeeklyRetentionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /** @test */
	public function check_if_site_goes_to_index_page(  ) {
		$this->get('')
		     ->assertSeeText("Charts")
		     ->assertStatus(200);
    }

    /** @test */
	public function weekly_data_route_exists()
	{
		$this->get('/weekly_retention')
		     ->assertStatus(200);
	}

	/** @test */
	public function json_returns_retention_values()
	{
		$chartConfig = json_decode($this->get('/weekly_retention')->original['data'],true);
		$this->assertArrayHasKey('series',$chartConfig);
	}

	/** @test */
	public function json_retention_data_starts_with_zero_percent_time()
	{
		$chartConfig = json_decode($this->get('/weekly_retention')->original['data'],true);
		$this->assertEquals('0',$chartConfig['series'][0]['data'][0][0]);
	}

	/** @test */
	public function json_retention_data_starts_with_hundred_percent_retention()
	{
		$chartConfig = json_decode($this->get('/weekly_retention')->original['data'],true);
		$this->assertEquals('100',$chartConfig['series'][0]['data'][0][1]);
	}

}
