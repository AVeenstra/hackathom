<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('includes/start.php');
?>
<pre>
<?php
$connection = Tivoka\Client::connect("http://www.rienheuver.nl/ah-api/index.php");
var_dump($connection);
try
{
	$request = $connection->sendRequest('search', array('query' => 'melk'));
	print_r($request->result);
	echo '<br />';
	print_r($request->getRequest(Tivoka\Tivoka::SPEC_2_0));
}
catch (Exception $ex)
{
	print_r($ex);
}
?>
</pre>