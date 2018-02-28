<?php

namespace Tugumuda\Helpers;

use Collective\Html\FormBuilder;

/**
 * Class helpers khusus untuk cetak Form with Bootstrap
 * class ini mengembangkan LaravelCollective\FormBuilder
 */
class BootstrapFormBuilder extends FormBuilder
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

	public function int2money($number, $with_currency = true)
	{
		if( ! is_numeric($number)) {
			$number = 0;
		}
		$return = number_format($number, 0, ',', '.');
		if($with_currency) {
			$return = 'Rp '.$return;
		}
		return $return;
	}

	/**
	 * Class untuk add default attributes form bootstrap
	 *
	 * @param array $attributes: additional attributes yang ingin ditambahkan
	 * @return array
	 */
	public function addDefaultAttributes($attributes = [], $validation = [])
	{
		// Add default class
		if( ! isset($attributes['class']))
		{
			$attributes['class'] = 'form-control';
		}
		else
		{
			$attributes['class'] .= ' form-control';
		}

		// Add validation
		if( ! empty($validation))
		{
			$attributes['class'] .= ' validate['.implode(',', $validation).']';
		}

		// Add default style
		if( ! isset($attributes['style']))
		{
			$attributes['style'] = 'width:100%';
		}

		return $attributes;
	}

	public function addID($name, $options)
	{
		if( ! isset($options['id']))
		{
			$options['id'] = $name;
		}

		return $options;
	}

	/**
	 * Buat form group
	 *
	 * @param string $label
	 * @param string $input
	 * @param string $l_width (label width) default: col-sm-3
	 * @param string $i_width (input width) default: col-sm-7
	 * @param array $l_attributes (additional label attributes) default: []
	 * @param array $i_attributes (additional input attributes) default: []
	 *
	 * @return string
	 */
	public function makeGroup($name, $label, $input, $l_width = 'col-sm-3', $i_width = 'col-sm-7')
	{
		$form_group = '<div class="form-group">';
		$form_group 	.= $this->label($name, $label, array('class' => $l_width));
		$form_group 	.= '<div class="'.$i_width.'">';
		$form_group 		.= $input;
		$form_group		.= '</div>';
		$form_group .= '</div>';

		return $form_group;
	}

	/**
     * Create a form label element.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return string
     */
    public function label($name, $value = null, $options = [])
    {
		if(isset($options['class']))
		{
			$options['class'] .= ' control-label';
		}

        return parent::label($name, $value, $this->addID($name.'_label', $options));
    }

	/**
     * Create a text input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return string
     */
	public function text($name, $value = null, $attributes = [], $validation = [])
	{
		return parent::text($name, $value, $this->addDefaultAttributes($this->addID($name, $attributes), $validation));
	}

	/**
     * Create a text form-group input field.
     *
	 * @param string $name
	 * @param string $label
     * @param string $value
	 * @param string $l_width (label width) default: col-sm-3
	 * @param string $i_width (input width) default: col-sm-7
	 * @param array $l_attributes (additional label attributes) default: []
	 * @param array $i_attributes (additional input attributes) default: []
	 *
     * @return string
     */
	public function textGroup($name, $label, $value = null, $validation = [], $l_width = 'col-sm-3', $i_width = 'col-sm-7', $l_attributes = [], $i_attributes = [])
	{
		return $this->makeGroup(
			$name,
			$label,
			$this->text($name, $value, $i_attributes, $validation),
			$l_width,
			$i_width
		);
	}

	/**
     * Create a money input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $attributes
     *
     * @return string
     */
	public function money($name, $value = null, $attributes = [], $validation = [])
	{
		$input = $this->text($name, $value, $attributes, $validation);
		$input .= '<script>';
		//$input .= '$(function() {';
		$input 		.= '$("#'.$name.'").maskMoney({
		 					prefix: "Rp ",
		 					thousands: ".",
		 					decimal: ",",
							precision: 0
		 				});';
		//$input .= '});';
		$input .= '</script>';

		return $input;
	}

	/**
     * Create a money form-group input field.
     *
	 * @param string $name
	 * @param string $label
     * @param string $value
	 * @param string $l_width (label width) default: col-sm-3
	 * @param string $i_width (input width) default: col-sm-7
	 * @param array $l_attributes (additional label attributes) default: []
	 * @param array $i_attributes (additional input attributes) default: []
	 *
     * @return string
     */
	public function moneyGroup($name, $label, $value = null, $validation = [], $l_width = 'col-sm-3', $i_width = 'col-sm-7', $l_attributes = [], $i_attributes = [])
	{
		return $this->makeGroup(
			$name,
			$label,
			$this->money($name, $value, $i_attributes, $validation),
			$l_width,
			$i_width
		);
	}

	/**
     * Create a textarea input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return string
     */
    public function textarea($name, $value = null, $options = [], $validation = [])
    {
		$options['rows'] = '3';
		return parent::textarea($name, $value, $this->addDefaultAttributes($this->addID($name, $options), $validation));
    }

	/**
     * Create a textarea form-group input field.
     *
	 * @param string $name
	 * @param string $label
     * @param string $value
	 * @param string $l_width (label width) default: col-sm-3
	 * @param string $i_width (input width) default: col-sm-7
	 * @param array $l_attributes (additional label attributes) default: []
	 * @param array $i_attributes (additional input attributes) default: []
	 *
     * @return string
     */
	public function textareaGroup($name, $label, $value = null, $validation = [], $l_width = 'col-sm-3', $i_width = 'col-sm-7', $l_attributes = [], $i_attributes = [])
	{
		return $this->makeGroup(
			$name,
			$label,
			$this->textarea($name, $value, $i_attributes, $validation),
			$l_width,
			$i_width
		);
	}

	/**
     * Create a date picker form-group input field.
     *
	 * @param string $name
	 * @param string $label
     * @param string $value
	 * @param string $l_width (label width) default: col-sm-3
	 * @param string $i_width (input width) default: col-sm-7
	 * @param array $l_attributes (additional label attributes) default: []
	 * @param array $i_attributes (additional input attributes) default: []
	 *
     * @return string
     */
	public function dateGroup($name, $label, $value = null, $validation = [], $l_width = 'col-sm-3', $i_width = 'col-sm-7', $l_attributes = [], $i_attributes = [])
	{
		return $this->makeGroup(
			$name,
			$label,
			date_picker($name, $value),
			$l_width,
			$i_width
		);
	}

	/**
     * Create a select box field.
     *
     * @param  string $name
     * @param  array  $list
     * @param  string $selected
     * @param  array  $options
     *
     * @return string
     */
    public function select($name, $list = [], $selected = null, $options = [], $validation = [])
	{
		$select  = parent::select($name, $list, $selected, $this->addDefaultAttributes($this->addID($name, $options), $validation));
		$select .= '<script> $("#'.$name.'").select2(); </script>';
		return $select;
	}

	/**
	 * Magic method untuk meneruskan static call ke \Form
	 */
	/*public static function __callStatic($name, $arguments)
	{
		// check apakah method yang di call ada di class ini
		if(method_exists(__CLASS__, $name))
		{
			// jika ada call method tsb
			return call_user_func_array("static::$name", $arguments);
		}
		else
		{
			// jika tidak ada call method yang ada di \Form
			return call_user_func_array("\Form::$name", $arguments);
		}
	}*/
}
