<?php
	// connect to db
	mysql_connect("localhost","root","patachin83");
	mysql_select_db("test");
	
	// require our class
	require_once("grid.php");
	
	// load our grid with a table
	$grid = new Grid("usuario", array(
		"save"=>true,
		"delete"=>true
		//"select" => 'selectFunction'
	));
?>