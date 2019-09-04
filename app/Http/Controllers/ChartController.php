<?php

namespace App\Http\Controllers;

use App\Charts\Formatters\WeeklyChartFormatter;
use App\FileDataSource;
use App\Charts\WeeklyRetentionChart;
use Illuminate\Http\Request;

class ChartController extends Controller
{
	public function getWeeklyRetentionData() {
		$chart = new WeeklyRetentionChart(new FileDataSource(), new WeeklyChartFormatter());
		$chart->loadChartData();
		$data = $chart->formatChartData();

		return $data;
    }
}
