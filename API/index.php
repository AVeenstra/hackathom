<?php
include('includes/start.php');
$server = array(
	'search' => function($params) {
		$query = $params['query'];

		$html = file_get_html('http://www.google.com/');
		$product = $html->find('div[data-appie="productpreview"]',0);
		$unit = $product->find('p[class="unit"]',0)->plaintext;
		$price = str_replace(array('<span>','</span>',array('',''),$product->find('p[class="price"]',0->plaintext);
		$name = str_replace('&shy;','',$product->find('div[class="detail"] h2')->plaintext);
		return array('name'->$name,'unit'->$unit,'price'->$price);
	}
);

Tivoka\Server::provide($server)->dispatch();

/**/
?>