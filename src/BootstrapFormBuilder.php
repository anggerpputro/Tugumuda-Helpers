<?php

namespace Tugumuda\Helpers;

use Collective\Html\HtmlBuilder;
use Collective\Html\FormBuilder;
use Illuminate\Contracts\Routing\UrlGenerator;

/**
 * Class helpers khusus untuk cetak Form with Bootstrap
 * class ini mengembangkan LaravelCollective\FormBuilder
 */
class BootstrapFormBuilder
{

	protected $formBuilder;

	/**
     * Create a new form builder instance.
     *
     * @param  \Illuminate\Contracts\Routing\UrlGenerator $url
     * @param  \Collective\Html\HtmlBuilder     $html
     * @param  string                           $csrfToken
	 * @param  string                           $sessionStore
     *
     * @return void
     */
    public function __construct(HtmlBuilder $html, UrlGenerator $url, $csrfToken, $sessionStore)
    {
		$this->formBuilder = new FormBuilder($html, $url, $csrfToken);

		return $this->formBuilder->setSessionStore($sessionStore);
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

        return $this->formBuilder->label($name, $value, $this->addID($name.'_label', $options));
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
		return $this->formBuilder->text($name, $value, $this->addDefaultAttributes($this->addID($name, $attributes), $validation));
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
     * Create a password input field.
     *
     * @param  string $name
     * @param  array  $options
     *
     * @return string
     */
    public function password($name, $options = [], $validation = [])
    {
		return $this->formBuilder->password($name, $this->addDefaultAttributes($this->addID($name, $options), $validation));
    }

	/**
     * Create a password form-group input field.
     *
	 * @param string $name
	 * @param string $label
	 * @param string $l_width (label width) default: col-sm-3
	 * @param string $i_width (input width) default: col-sm-7
	 * @param array $l_attributes (additional label attributes) default: []
	 * @param array $i_attributes (additional input attributes) default: []
	 *
     * @return string
     */
	public function passwordGroup($name, $label, $validation = [], $l_width = 'col-sm-3', $i_width = 'col-sm-7', $l_attributes = [], $i_attributes = [])
	{
		return $this->makeGroup(
			$name,
			$label,
			$this->password($name, $i_attributes, $validation),
			$l_width,
			$i_width
		);
	}

	/**
     * Create an e-mail input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return string
     */
    public function email($name, $value = null, $options = [], $validation = [])
    {
		return $this->formBuilder->email($name, $value, $this->addDefaultAttributes($this->addID($name, $options), $validation));
    }

	/**
     * Create a email form-group input field.
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
	public function emailGroup($name, $label, $value = null, $validation = [], $l_width = 'col-sm-3', $i_width = 'col-sm-7', $l_attributes = [], $i_attributes = [])
	{
		return $this->makeGroup(
			$name,
			$label,
			$this->email($name, $value, $i_attributes, $validation),
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
		return $this->formBuilder->textarea($name, $value, $this->addDefaultAttributes($this->addID($name, $options), $validation));
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

	public function date_picker($id = 'asa',$value="")
	{
		return '<script>'
				.'$(document).ready(function(){'
					.'$(".tgl").datetimepicker({format: "YYYY-MM-DD"});'
			.'})</script>'
		.'<input type="text" class="form-control tgl" value="'.$value.'" id="'.$id.'" name="'.$id.'"  placeholder="Masukkan Tanggal">';
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
			$this->date_picker($name, $value),
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
		$select  = $this->formBuilder->select($name, $list, $selected, $this->addDefaultAttributes($this->addID($name, $options), $validation));
		$select .= '<script> $("#'.$name.'").select2(); </script>';
		return $select;
	}

	protected function extractName($name_)
	{
		$name = $name_;
		$label = $name;
		if(is_array($name_))
		{
			$name = $name_[0];
			$label = $name_[1];
		}
		return $name;
	}

	protected function capsulateCheckable($input, $name_, $class, $inline = false)
	{
		$name = $name_;
		$label = $name;
		if(is_array($name_))
		{
			$name = $name_[0];
			$label = $name_[1];
		}

		$checkable = '';
		if($inline)
		{
			$checkable .= '<label class="'.$class.'-inline">';
			$checkable .= 		$input;
			$checkable .= 		$label;
			$checkable .= '</label>';
		}
		else
		{
			$checkable .= '<div class="'.$class.'">';
			$checkable .= 	'<label>';
			$checkable .= 		$input;
			$checkable .= 		$label;
			$checkable .= 	'</label>';
			$checkable .= '</div>';
		}
		return $checkable;
	}

	/**
     * Create a checkbox input field.
     *
     * @param  mixed $name
     * @param  mixed  $value
     * @param  bool   $checked
     * @param  array  $options
     *
     * @return string
     */
    public function checkbox($name_, $value = 1, $checked = null, $options = [], $inline = false)
    {
		return $this->capsulateCheckable(
			$this->formBuilder->checkbox($this->extractName($name_), $value, $checked, $options),
			$name_,
			'checkbox',
			$inline
		);
    }

    /**
     * Create a radio button input field.
     *
     * @param  mixed $name
     * @param  mixed  $value
     * @param  bool   $checked
     * @param  array  $options
     *
     * @return string
     */
    public function radio($name_, $value = null, $checked = null, $options = [], $inline = false)
    {
		return $this->capsulateCheckable(
			$this->formBuilder->radio($this->extractName($name_), $value, $checked, $options),
			$name_,
			'radio',
			$inline
		);
    }

	/**
	 * Magic method untuk meneruskan static call ke \Form
	 */
	public function __call($name, $arguments)
	{
		// check apakah method yang di call ada di class ini
		if(method_exists(__CLASS__, $name))
		{
			// jika ada call method tsb
			return call_user_func_array($name, $arguments);
		}
		else
		{
			// jika tidak ada call method yang ada di \Form
			return call_user_func_array(array($this->formBuilder, $name), $arguments);
		}
	}
}
