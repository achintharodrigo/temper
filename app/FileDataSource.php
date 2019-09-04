<?php

namespace App;

class FileDataSource implements DataSourceInterface {
	public function getDataFromSource() {
		$csv = explode("\n", file_get_contents(asset('data/export.csv')));
		$headerArr = $data = [];
		foreach ($csv as $key => $line)
		{
			if(!$line) continue;
			$tempArr = [];

			$csv[$key] = str_getcsv($line);
			$csv_key = $csv[$key];

			if(empty($headerArr)) {
				$headerArr = explode(";",$csv_key[0]);
				continue;
			}
			$values = explode(";",$csv_key[0]);
			$i=0;
			foreach ($headerArr as $index) {
				$tempArr[$index] = $values[$i++];
			}
			$data[$values[0]] = $tempArr;
			unset($tempArr);
		}
		return $data;
	}
}