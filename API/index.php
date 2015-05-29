<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('includes/start.php');
$server = array(
	'search' => function($params) {
		try
		{
			$query = urlencode(implode('+',$params['query']));

			$html = file_get_html('http://www.ah.nl/zoeken?rq='.$query);
			$product = $html->find('div[data-appie="productpreview"]',0);
			$unit = trim($product->find('p[class="unit"]',0)->plaintext);
			$price = trim(str_replace(array('<span>','</span>'),array('',''),$product->find('p[class="price"]',0)->plaintext));
			$name = trim(str_replace('&shy;','',$product->find('div[class="detail"] h2',0)->plaintext));
			return array('name'=>$name,'unit'=>$unit,'price'=>$price);
		}
		catch (Exception $e)
		{
			print_r($e);
		}
	}
);

Tivoka\Server::provide($server)->dispatch();

/**/
?>