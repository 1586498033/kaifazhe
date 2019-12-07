<?php
if(!defined('IN_PHPMYWIND')) exit('Request Error!');
$domonth = new Month_convert();
class Month_convert {
    private $month_e = 
		array(
			1 => "Jan",
			2 => "Feb",
			3 => "Mar",
			4 => "Apr",
			5 => "May",
			6 => "Jun",
			7 => "Jul",
			8 => "Aug",
			9 => "Sep",
			10 => "Oct",
			11 => "Nov",
			12 => "Dec"
		);
    public function month_e($mon)
    {
		return $this->month_e[$mon];
    }
}
