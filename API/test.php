<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('includes/start.php');
if (isset($_POST['q']))
{
	?>
	<pre>
	<?php
	$connection = Tivoka\Client::connect("https://shinigami.student.utwente.nl/hackathom/index.php");
	try
	{
		$request = $connection->sendRequest('recipe', array('query' => $_POST['q'], 'amount' => 3));
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
	<?php
}
?>
<form method="post" action="test.php">
	<input type="text" name="q">
	<input type="submit" value="Search">
</form>