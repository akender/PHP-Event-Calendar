<?php

class Config
{
	var $jan = 'Jaanuar';
	var $feb = 'Veebruar';
	var $mar = 'M�rts';
	var $apr = 'Aprill';
	var $may = 'Mai';
	var $jun = 'Juuni';
	var $jul = 'Juuli';
	var $aug = 'August';
	var $sep = 'September';
	var $oct = 'Oktoober';
	var $nov = 'November';
	var $dec = 'Detsember';
	
	var $mon = 'Esmasp�ev';
	var $tue = 'Teisip�ev';
	var $wed = 'Kolmap�ev';
	var $thu = 'Neljap�ev';
	var $fri = 'Reede';
	var $sat = 'Laup�ev';
	var $sun = 'P�hap�ev';
	
	var $startonsunday = false;
	var $showweeknumber = true;
	var $fontfamily = 'calibri';
	var $weekname = 'N�dal';
	var $allday = 'Terve p�ev';
	
	var $rgbbackgroundcolor = '255,255,255';
	var $rgbheadercolor = '211,211,211';
	var $rgbdayheadercolor = '242,242,242';
	var $rgbtodayheadercolor = '255,192,0';
	var $rgbtodaycolor = '255,246,217';
	var $rgbdefaulteventcolor = '219,238,243';
	
	var $eventminwidthpx = 80;
	var $eventmaxwidthpx = 200;
	
	function getDays($chars = 0)
	{
		$days = array();
		
		if ($this->startonsunday)
		{
			array_push($days, $this->sun);
		}
		array_push($days, $this->mon);
		array_push($days, $this->tue);
		array_push($days, $this->wed);
		array_push($days, $this->thu);
		array_push($days, $this->fri);
		array_push($days, $this->sat);
		if ($this->startonsunday === false)
		{
			array_push($days, $this->sun);
		}
		
		if ($chars > 0)
		{
			for ($i = 0; $i < count($days); $i++)
			{
				$days[$i] = substr($days[$i], 0, $chars);
			}
		}
		
		return $days;
	}
	
	function getMonths($chars = 0)
	{
		$months = array();
		
		array_push($months, $this->jan);
		array_push($months, $this->feb);
		array_push($months, $this->mar);
		array_push($months, $this->apr);
		array_push($months, $this->may);
		array_push($months, $this->jun);
		array_push($months, $this->jul);
		array_push($months, $this->aug);
		array_push($months, $this->sep);
		array_push($months, $this->oct);
		array_push($months, $this->nov);
		array_push($months, $this->dec);
		
		if ($chars > 0)
		{
			for ($i = 0; $i < count($months); $i++)
			{
				$months[$i] = substr($months[$i], 0, $chars);
			}
		}
		
		return $months;
	}
}

?>
