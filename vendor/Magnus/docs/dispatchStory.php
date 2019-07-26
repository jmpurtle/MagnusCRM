<?php
$packageRoot = dirname(__DIR__);
require_once $packageRoot . '/autoload.php';
?>
Feature: Request Dispatching
		 As a Website Builder
		 I want to dispatch my requests
		 So I can retrieve a response to render

Scenario: Static value dispatching
	<?php $dispatch = new \Magnus\Core\Dispatch(); ?>

	Given a static routed result:
	<?php
	$previous = null;
	$obj = 'hi';
	$isEndpoint = true;
	?>

	When dispatched:
	<?php $result = $dispatch($previous, $obj); ?>

	Then the call should result in "hi":
	<?= var_export(($result == "hi"), true); ?>

Scenario: Invoking a object
	<?php $dispatch = new \Magnus\Core\Dispatch(); ?>

	Given a standard object routed result:
	<?php
	$previous = null;
	$obj = new \Utils\Testing\RootController();
	$isEndpoint = false;
	?>

	And the object has an __invoke() function:
	<?= var_export(method_exists($obj, '__invoke'), true); ?>

	When dispatched:
	<?php $result = $dispatch($previous, $obj); ?>

	Then the call should result in __invoke() being called:
	<?= var_export(($result == array('__invoke')), true); ?>

Scenario: Invoking a object not implementing __invoke
	<?php $dispatch = new \Magnus\Core\Dispatch(); ?>

	Given a standard object routed result:
	<?php
	$previous = null;
	$obj = new \Utils\Testing\VoidController();
	$isEndpoint = false;
	?>

	When dispatched:
	<?php $result = $dispatch($previous, $obj); ?>

	Then the call should result in the handler being returned:
	<?= var_export((get_class($result) == "Utils\Testing\VoidController"), true); ?>

Scenario: Invoking a object method
	<?php $dispatch = new \Magnus\Core\Dispatch(); ?>

	Given a standard object routed result:
	<?php
	$previous = 'bar';
	$obj = new \Utils\Testing\RootController();
	$isEndpoint = false;
	?>

	When dispatched:
	<?php $result = $dispatch($previous, $obj); ?>

	Then the call should result in calling bar:
	<?= var_export(($result == array('bar')), true); ?>

<?= "\n\n"; ?>