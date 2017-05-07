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
	$options = '<option value="">Hãy chọn</option>';
	foreach ($data as $d) {
		$options .= '<option value="' . $d[$value] . '">' .$d[$desribe]. '</option>';
	}

	return '<select class="'.$cssClass.'" id="'.$idSelect.'" name="'.$nameSelect.'" ' . ( array_key_exists('isDisabled', $data) && $data['isDisabled'] === true ? 'disabled' : '') . '>'
			.$options.'</select>';
}

function addTooltip($content)
{
	return 'class="tooltips" data-toggle="tooltip" title="" data-original-title="'.$content.'"';
}

function isRequired()
{
	return '<label style="color:red;">*</label>';
}

function displayPreview($id)
{
	$src = route('news.show', ['id' => $id]);
	return '<a href=""><i class="fa fa-eye"></i>&nbsp;</a><div class="box"><iframe style="
    " src="' .$src. '" width = "800px" height = "400px"></iframe></div>';
}