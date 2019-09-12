<?php

namespace App\Charts\Formatters;

use App\FormatterInterface;

class WeeklyChartFormatter implements FormatterInterface {

	private $title;
	private $xTitle;
	private $yTitle;

	public function setTitle($title){ $this->title = $title; }
	public function setXTitle($xTitle){ $this->xTitle = $xTitle; }
	public function setYTitle($yTitle){ $this->yTitle = $yTitle; }

	public function formatData(array $data) {
		$mainArr['chart'] = ['type' => 'spline', 'inverted' => false];
		$mainArr['tooltips'] = ['enabled' => true];
		$mainArr['title'] = ['text' => $this->title];
		$mainArr['yAxis'] = ['title' => ['text' => $this->yTitle]];
		$mainArr['xAxis'] = ['title' => ['text' => $this->xTitle]];
		$mainArr['msg'] = "";


		if(!empty($data)) {
			$mainArr['series'] = $data;
			return [
				'err' =>false,
				'msg' => '',
				'data'=>json_encode($mainArr)
			];
		} else {
			$mainArr['series'] = $data;
			return [
				'err' =>true,
				'msg' => "Data Array is Empty",
				'data'=>json_encode($mainArr)
			];
		}
	}

	public function formatChartTitles() {
		$this->setTitle("Weekly Retentions");
		$this->setYTitle("Percentage of users");
		$this->setXTitle("Weekly distribution");
	}

	public function applySpecialFormattingToData(array $data) {
		return $this->formatWeeklyRetentions($data);
	}

	private function formatWeeklyRetentions(array $rawData) {
		$formattedArray = [];

		foreach($rawData as $week => $countArr){
			$tempArr['name'] = $week;
			foreach ($countArr as $percentage => $count) {
				$tempArr['data'][] = [$percentage,$count];
			}
			$formattedArray[] = $tempArr;
			unset($tempArr);
		}

		return $formattedArray;
	}
}