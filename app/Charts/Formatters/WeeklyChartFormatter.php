<?php

namespace App\Charts\Formatters;

use App\FormatterInterface;

class WeeklyChartFormatter implements FormatterInterface {

	private $title;
	private $xTitle;
	private $yTitle;
	private $series;

	public function setSeries($series){ $this->series = $series; }
	public function setTitle($title){ $this->title = $title; }
	public function setXTitle($xTitle){ $this->xTitle = $xTitle; }
	public function setYTitle($yTitle){ $this->yTitle = $yTitle; }

	public function formatData() {
		$mainArr['chart'] = ['type' => 'spline', 'inverted' => false];
		$mainArr['tooltips'] = ['enabled' => true];
		$mainArr['title'] = ['text' => $this->title];
		$mainArr['yAxis'] = ['title' => ['text' => $this->yTitle]];
		$mainArr['xAxis'] = ['title' => ['text' => $this->xTitle]];

		$mainArr['series'] = $this->series;

		return [
			'err' =>false,
			'data'=>json_encode($mainArr)
		];
	}
}