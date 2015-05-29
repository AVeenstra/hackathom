<?php
include('includes/start.php');
$server = array(
	'search' => function($params) {
		$query = $params['query'];
		$html_string = file_get_contents("http://www.ah.nl/zoeken?rq=".$query);
		$xml = simplexml_load_string($html_string);
		return $xml;
	}
);

Tivoka\Server::provide($server)->dispatch();

/**/
?>