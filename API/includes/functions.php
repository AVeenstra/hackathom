<?php

function validmail($mail)
{
	$return = filter_var($mail, FILTER_VALIDATE_EMAIL);
	return $return;
}

function clean($input)
{
	$input = mysql_real_escape_string($input);
	$input = htmlentities($input);
	$input = strip_tags($input);
	return $input;
}

function errormsg($msg)
{
	$display = '<div class="alert alert-danger">'.$msg.'</div>';
	return $display;
}

function successmsg($msg)
{
	$display = '<div class="alert alert-success">'.$msg.'</div>';
	return $display;
}

function infomessage($msg)
{
	$display = '<div class="alert alert-info">'.$msg.'</div>';
	return $display;
}

function warningmessage($msg)
{
	$display = '<div class="alert alert-warning">'.$msg.'</div>';
	return $display;
}


function f($fetch)
{
	$results = mysql_fetch_array($fetch);
	return $results;
}

function q($query)
{
	$data = mysql_query($query);
	return $data;
}

function n($resource)
{
	$count = mysql_num_rows($resource);
	return $count;
}

?>