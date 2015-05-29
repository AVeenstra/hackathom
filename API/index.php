<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('includes/start.php');
$server = array(
	'search' => function($params) {
		$query = urlencode($params['query']);
		$html = file_get_html('http://www.ah.nl/zoeken?rq='.$query);
		$product = $html->find('div[data-appie="productpreview"]',0);
		$unit = trim($product->find('p[class="unit"]',0)->plaintext);
		$price = trim(str_replace(array('<span>','</span>'),array('',''),$product->find('p[class="price"]',0)->plaintext));
		$name = trim(str_replace('&shy;','',$product->find('div[class="detail"] h2',0)->plaintext));
		return array('name'=>$name,'unit'=>$unit,'price'=>$price, 'query'=>$query);
	},
	'recipe' => function($params) {
		$query = urlencode($params['query']);
		$amount = $params['amount'];
		$search = file_get_html('http://www.ah.nl/allerhande/recepten-zoeken?Ntt='.$query);
		$recipe = file_get_html("http://www.ah.nl".$search->find('section[data-record-type="recipe"] figure a',0)->href);
		$recipe_title = $recipe->find('h1[itemprop="name"]',0)->plaintext;
		$people = $recipe->find('section[class="info hidden-phones"] ul[class="short"] li',1)->find('span',0)->plaintext)[0];
		$ingredients_array = array();
		foreach ($recipe->find('ul[class="list shopping"] li[itemprop="ingredients"]') as $ingredient)
		{
			$contents = explode(" ",$ingredient->find('span[class="js-label label"]',0)->plaintext);
			$contents[0] = $contents[0]/$people*$amount;
			$unit = $contents[1];
			$ingredients_array[] = implode(" ",$contents);
		}

		return array('recipe_title' => $recipe_title,'ingredients' => $ingredients_array);
	}
);

Tivoka\Server::provide($server)->dispatch();

/**/
?>