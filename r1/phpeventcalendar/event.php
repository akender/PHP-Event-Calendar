<?php

class Event
{
	var $params;
	
	var $content;
	var $colorRGB;
	var $year_start;
	var $month_start;
	var $day_start;
	var $hour_start;
	var $min_start;
	var $year_finish;
	var $month_finish;
	var $day_finish;
	var $hour_finish;
	var $min_finish;
	
	function Event($content, $year_st, $month_st, $day_st, $hour_st = 0, $min_st = 0, $year_fs = false, $month_fs = false, $day_fs = false, $hour_fs = 0, $min_fs = 0)
	{
		$this->content = $content;
		$this->colorRGB = false;
		$this->year_start = $year_st;
		$this->month_start = $month_st;
		$this->day_start = $day_st;
		$this->hour_start = $hour_st;
		$this->min_start = $min_st;
		$this->year_finish = $year_fs;
		$this->month_finish = $month_fs;
		$this->day_finish = $day_fs;
		$this->hour_finish = $hour_fs;
		$this->min_finish = $min_fs;
	}
	
	function setColorRGB($RGBstring)
	{
		$this->colorRGB = $RGBstring;
	}
	
	function getColorRGB()
	{
		if ($this->colorRGB)
		{
			return $this->colorRGB;
		}
		else return false;
	}
	
	function getContent()
	{
		return $this->content;
	}
	
	function getDateTimeStart()
	{
		return mktime($this->hour_start, $this->min_start, 0, $this->month_start, $this->day_start, $this->year_start);
	}
}

?>
