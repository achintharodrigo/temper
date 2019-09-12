<?php

namespace App\Charts;

use App\ChartInterface;
use App\DataSourceInterface;
use App\FormatterInterface;
use Carbon\Carbon;

class WeeklyRetentionChart implements ChartInterface {

	private $data_source;
	private $formatter;
	private $row_data;
	protected $chart_data = [];

	public function __construct( DataSourceInterface $data_source, FormatterInterface $formatter ) {
		$this->data_source = $data_source;
		$this->formatter = $formatter;
	}

	public function getRowData() { return $this->row_data; }

	public function loadChartData() {
		$this->row_data = $this->data_source->getDataFromSource();
		$this->chart_data = $this->getWeeklyRetentionData();
	}

	public function renderChart() {
		$this->formatter->formatChartTitles();
		return $this->formatter->formatData($this->chart_data);
	}

	private function getWeeklyRetentionData() {
		$weeklyCounts = $this->calculateWeeklyCounts($this->row_data);
		$weeklyRetentions = $this->calculateWeeklyRetentions($weeklyCounts);
		$formattedData = $this->formatter->applySpecialFormattingToData($weeklyRetentions);
		return $formattedData;
	}

	private function calculateWeeklyCounts(array $rawData) {
		$data = [];

		foreach($rawData as $row) {
			$date = (new Carbon($row['created_at']))->startOfWeek()->format('Y-m-d');
			$data[$date][$row['onboarding_perentage']] =
				isset($data[$date][$row['onboarding_perentage']]) ? ++$data[$date][$row['onboarding_perentage']] : 1;
		}

		return $data;
	}


	private function calculateWeeklyRetentions(array $rawData) {
		foreach ($rawData as $week => $countArr) {
			$tempArr = [];
			$checkedTotal = 0;
			$weekTotal = array_sum($countArr);
			ksort($countArr);

			$tempArr[0] = 100;
			foreach ($countArr as $percentage => $count) {
				$tempArr[$percentage] = round(100-($checkedTotal/$weekTotal*100),2);
				$checkedTotal += $count;
			}
			$rawData[$week] = $tempArr;
		}

		return $rawData;

	}
}