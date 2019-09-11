<?php

namespace App;

interface FormatterInterface {
	public function formatData(array $data);

	public function formatChartTitles();

	public function applySpecialFormattingToData(array $data);

}
