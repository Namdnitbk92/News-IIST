<?php

function displayFieldError($errors, $field)
{
	if (isset($errors) && $errors->has($field))
	{
		return '<span class="help-block">
	        		<strong> ' . $errors->first($field) . '</strong>
	   			</span>';
	}
}

function addErrorClass($errors, $field) 
{
	return isset($errors) && $errors->has($field) ? ' has-error' : '';
}

function renderSelect($data, $value, $desribe, $nameSelect, $idSelect, $cssClass)
{
	$options = '';
	foreach ($data as $d) {
		$options .= '<option value="' . $d[$value] . '">' .$d[$desribe]. '</option>';
	}

	return '<select class="'.$cssClass.'" id="'.$idSelect.'" name="'.$nameSelect.'" ' . ( array_key_exists('isDisabled', $data) && $data['isDisabled'] === true ? 'disabled' : '') . '>'
			.$options.'</select>';
}