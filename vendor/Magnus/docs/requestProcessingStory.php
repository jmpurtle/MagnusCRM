<?php
$packageRoot = dirname(__DIR__);
require_once $packageRoot . '/autoload.php';
?>
Feature: Request processing
	As a Website Builder
	I want to process web requests to my application
	So I have all the information I need to determine the appropriate response

Scenario: URL chunking
	
	Given an URL
	<?php $_SERVER['REQUEST_URI'] = '/'; ?>

		When chunked:
		<?php
		$request = new \Magnus\Core\Requests();
		$path = $request->getPath($_SERVER['REQUEST_URI']);
		?>

		Then the call should result in an empty path array:
		<?= var_export($path == array(), true); ?>

	Given an URL with query string
	<?php $_SERVER['REQUEST_URI'] = '/?foo=bar'; ?>

		When chunked:
		<?php
		$request = new \Magnus\Core\Requests();
		$path = $request->getPath($_SERVER['REQUEST_URI']);
		$qsa = $request->getQSA($_SERVER['REQUEST_URI']);
		?>

		Then the call should result in a path array without query string:
		<?= var_export($path == array(), true); ?>

		And query strings are parsed out into a QSA field:
		<?= var_export($qsa == array("foo" => "bar")); ?>

	Given an URL with multiple parts
	<?php $_SERVER['REQUEST_URI'] = '/baz/qux?foo=bar'; ?>

		When chunked:
		<?php
		$request = new \Magnus\Core\Requests();
		$path = $request->getPath($_SERVER['REQUEST_URI']);
		$qsa = $request->getQSA($_SERVER['REQUEST_URI']);
		?>

		Then the call should result in a path array without query string:
		<?= var_export($path == array('baz', 'qux'), true); ?>

		And query strings are parsed out into a QSA field:
		<?= var_export($qsa == array("foo" => "bar")); ?>

Scenario: POST Requests
	
	Given a POST request
	<?php
	//It's not really possible to emulate a proper POST request via unit testing so this'll sub for that
	$_POST['foo'] = 'bar';
	?>

		When processed:
		<?php
		$request = new \Magnus\Core\Requests();
		$responseBody = $request->getRequestBody();
		?>

		Then the call should result in a POST body array:
		<?= var_export($responseBody == array('foo' => 'bar')); ?>


