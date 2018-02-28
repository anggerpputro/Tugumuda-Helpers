<?php

namespace Tugumuda\Helpers;

class Formatter
{

	public function money_format($number, $with_currency = true)
	{
		//return money_format('%#11.0n', $number);
		//$fmt = new NumberFormatter( 'id_ID', NumberFormatter::CURRENCY );
		//return $fmt->formatCurrency($number, "IDR");
		//$fmt = numfmt_create( 'id_ID', NumberFormatter::CURRENCY );
		//return numfmt_format_currency($fmt, $number, "IDR");
		//dd($number);
		if( ! is_numeric($number)) {
			$number = 0;
		}
		$return = number_format($number, 0, ',', '.');
		if($with_currency) {
			$return = 'Rp '.$return;
		}
		return $return;
	}

	public function money_format_italic($number, $with_currency = true)
	{
		return '<i>('.self::money_format($number, $with_currency).')</i>';
	}

	public function money_format_dec($number, $with_currency = true, $italic = true)
	{
		if($italic) {
			return '<i>(-'.self::money_format($number, $with_currency).')</i>';
		} else {
			return '(-'.self::money_format($number, $with_currency).')';
		}
	}

}
