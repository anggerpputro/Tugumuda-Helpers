<?php

namespace Tugumuda\Helpers;

class Converter
{

	public function money2int($string, $allow_negative = false)
	{
		if(is_null($string) OR $string == '' OR $string == '-')
		{
			return 0;
		}

		// check is it string and not numeric?
		if( ! is_numeric($string))
		{
			// double check to make sure that the string contains rp (its mean money string)
			if (stripos($string, 'Rp') !== FALSE)
			{
				if($allow_negative)
				{
					return preg_replace('/[^\d-]+/', '', $string);
				}
				else
				{
					return preg_replace('/[\D]+/', '', $string);
				}
			}
		}

		return $string;
	}

	public function int2money($integer, $with_currency = true)
	{
		return (new Formatter())->money_format($integer, $with_currency);
	}

	public function gr2kg($gram, $precision = 2)
	{
		return round($gram/1000, $precision);
	}

	public function kg2gr($kg, $precision = 2)
	{
		return round($kg*1000, $precision);
	}

	public function gr2ons($gr, $precision = 2)
	{
		return round($gr/100, $precision);
	}

	public function ons2gr($ons, $precision = 2)
	{
		return round($ons*100, $precision);
	}

	public function pack2gr($pack, $berat, $precision = 2)
	{
		return round($pack*$berat, $precision);
	}

	public function gr2pack($gram, $berat, $precision = 2)
	{
		if($berat > 0)
		{
			return round($gram/$berat, $precision);
		}
		else
		{
			return 0;
		}
	}

	public function array2object($array)
	{
		$object = new \stdClass;
		foreach($array as $key => $value)
		{
			$object->{$key} = $value;
		}
		return $object;
	}

	public function iterator2array($iterator, $use_keys = true)
	{
		/*$array = [];
		foreach($iterator as $key => $value)
		{

		}*/
		return iterator_to_array($iterator, $use_keys);
	}

}
