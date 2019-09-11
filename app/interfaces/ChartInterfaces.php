<?php

namespace App;

interface ChartInterface {
	public function loadChartData();

	public function renderChart();
}
