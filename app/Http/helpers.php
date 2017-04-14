<?php

function displayFieldError($errors,$field)
{
	if (isset($errors) && $errors->has($field))
	{
		return "<span class='help-block'>
	        		<strong>{{ $errors->first($field) }}</strong>
	   			</span>";
	}
}

function addErrorClass($field)
{
	return isset($errors) && $errors->has($field) ? ' has-error' : '';
}