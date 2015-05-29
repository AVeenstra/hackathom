<?php
include('includes/start.php');
$server = array(
	'test' => function($params) {
	}

	);

Tivoka\Server::provide($server)->dispatch();
?>