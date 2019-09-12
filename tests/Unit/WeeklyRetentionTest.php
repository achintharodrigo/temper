<?php

namespace Tests\Unit;

use App\Charts\Formatters\WeeklyChartFormatter;
use App\Charts\WeeklyRetentionChart;
use App\FileDataSource;
use Carbon\Carbon;
use Tests\TestCase;

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

	/** @test */
	public function check_if_weekly_retention_data_loading_from_file_works()
	{
		$chart = new WeeklyRetentionChart(new FileDataSource(), new WeeklyChartFormatter());
		$chart->loadChartData();
		$this->assertIsArray( $chart->getRowData());
	}

	/** @test */
	public function check_if_file_data_loading_correctly()
	{
		$fileData = (new FileDataSource())->getDataFromSource();
		$this->assertIsArray( $fileData);
		foreach($fileData as $item) {
			$this->assertArrayHasKey( 'user_id', $item);
		}
	}

	/** @test */
	public function check_if_chart_rendering_fails_without_data_loading() {
		$chart = new WeeklyRetentionChart(new FileDataSource(), new WeeklyChartFormatter());
		$chartConfig =  $chart->renderChart();
		$this->assertTrue( $chartConfig['err']);
		$this->assertEquals("Data Array is Empty", $chartConfig['msg']);
	}

	/** @test */
	public function check_if_chart_rendering_works_with_data_loading() {
		$chart = new WeeklyRetentionChart(new FileDataSource(), new WeeklyChartFormatter());
		$chart->loadChartData();
		$chartConfig =  $chart->renderChart();
		$this->assertFalse( $chartConfig['err']);
		$this->assertEmpty( $chartConfig['msg']);
	}

	// test formatter
	/** @test */
	public function check_if_the_retention_formatter_is_working() {
		$chart = new WeeklyRetentionChart(new FileDataSource(), new WeeklyChartFormatter());
		$chart->loadChartData();
		$chartConfig =  $chart->renderChart();
		$chartData = json_decode( $chartConfig['data']);
		$this->assertEquals( 'Weekly Retentions', $chartData->title->text);
		$this->assertEquals( 'Percentage of users', $chartData->yAxis->title->text);
		$this->assertEquals( 'Weekly distribution', $chartData->xAxis->title->text);

		$this->get('/weekly_retention')
			->assertJsonStructure([
				"err",
				"msg",
				"data"
			]);
		$this->assertNotEmpty($chartData->series[0]->name);
		$this->assertNotEmpty($chartData->series[0]->data);
		$this->assertIsArray($chartData->series[0]->data);
		foreach($chartData->series as $line) {
			foreach ($line->data as $key => $val) {
				$this->assertTrue( $val[0] <= 100 && $val[0] >= 0);
				$this->assertTrue( $val[1] <= 100 && $val[1] >= 0);
			}
			$startDateOfTheWeek = (new Carbon($line->name))->startOfWeek()->format('Y-m-d');
			$this->assertEquals( $startDateOfTheWeek, $line->name);
		}
	}
}
