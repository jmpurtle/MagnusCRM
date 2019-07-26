<?php
$packageRoot = dirname(__DIR__);
require_once $packageRoot . '/autoload.php';
?>
Feature: Request routing
	As a Website Builder
	I want to route web requests to my application
	So I can receive a handler and endpoint to dispatch upon

Scenario: Empty path handling
	<?php $router = new \Magnus\Core\Router(); ?>

	Given an empty path:
	<?php $path = array(); ?>

	When the next path chunk is requested:
	<?php foreach ($router->routeIterator($path) as list($previous, $current)) {} ?>

	Then the call should fail to set $previous and $current:
	<?= var_export((!isset($previous) && !isset($current)), true); ?>

Scenario: One chunk path handling
	<?php $router = new \Magnus\Core\Router(); ?>

	Given a path with one chunk:
	<?php $path = array('foo'); ?>

	When the path chunk is processed:
	<?php foreach ($router->routeIterator($path) as list($previous, $current)) {} ?>

	Then the call should set $previous and $current to null and foo:
	<?= var_export(($previous === null && $current == 'foo'), true); ?>

Scenario: Multiple chunk path handling
	<?php $router = new \Magnus\Core\Router(); ?>

	Given a path with more than one chunk:
	<?php $path = array('foo', 'bar'); ?>

	When the path chunk is processed:
	<?php foreach ($router->routeIterator($path) as list($previous, $current)) {} ?>

	Then the call should set $previous and $current to foo and bar:
	<?= var_export(($previous === 'foo' && $current == 'bar'), true); ?>

Scenario: Object Descent routing with empty paths
	<?php $router = new \Magnus\Core\Router(); ?>

	Given an empty path:
	<?php $path = array(); ?>

	And a Root Controller Object:
	<?php $rootObject = new \Utils\Testing\RootController(); ?>

	When routed:
	<?php
	foreach ($router($rootObject, $path) as list($previous, $obj, $isEndpoint)) {
		if ($isEndpoint) { break; }
	}
	?>

	Then the call should result in a handler of the original root object, indicating __invoke() should be called:
	<?=
	var_export((
		$previous == null &&
		get_class($obj) == "Utils\Testing\RootController" &&
		$isEndpoint === false
	), true); 
	?>

Scenario: Object Descent routing with controller reference instead of object
	<?php $router = new \Magnus\Core\Router(); ?>

	Given an empty path:
	<?php $path = array(); ?>

	And a Root Controller Object reference:
	<?php $rootObject = '\\Utils\\Testing\\RootController'; ?>

	When routed:
	<?php
	foreach ($router($rootObject, $path) as list($previous, $obj, $isEndpoint)) {
		if ($isEndpoint) { break; }
	}
	?>

	Then the call should result in a handler of the original root object, indicating __invoke() should be called:
	<?=
	var_export((
		$previous == null &&
		get_class($obj) == "Utils\Testing\RootController" &&
		$isEndpoint === false
	), true); 
	?>

Scenario: Object Descent routing with a property referring to a controller
	<?php $router = new \Magnus\Core\Router(); ?>

	Given a path with one chunk:
	<?php $path = array('foo'); ?>

	And a Root Controller Object:
	<?php $rootObject = new \Utils\Testing\RootController(); ?>

	And this Root Controller object contains a property named foo:
	<?= var_export(property_exists($rootObject, 'foo'), true); ?>

	And foo refers to another controller by name:
	<?= var_export($rootObject->foo === '\\Utils\\Testing\\FooController', true); ?>

	And this referenced controller exists:
	<?= var_export(class_exists($rootObject->foo), true); ?>

	When routed:
	<?php
	foreach ($router($rootObject, $path) as list($previous, $obj, $isEndpoint)) {
		if ($isEndpoint) { break; }
	}
	?>

	Then the call should result in a handler of FooController, indicating __invoke() should be called:
	<?=
	var_export((
		$previous == null &&
		get_class($obj) == "Utils\Testing\FooController" &&
		$isEndpoint === false
	), true); 
	?>

Scenario: Object Descent routing with chunk referring to method
	<?php $router = new \Magnus\Core\Router(); ?>

	Given a path with one chunk:
	<?php $path = array('bar'); ?>

	And a Root Controller Object:
	<?php $rootObject = new \Utils\Testing\RootController(); ?>

	And this Root Controller object contains a method named bar:
	<?= var_export(method_exists($rootObject, 'bar'), true); ?>

	When routed:
	<?php
	foreach ($router($rootObject, $path) as list($previous, $obj, $isEndpoint)) {
		if ($isEndpoint) { break; }
	}
	?>

	Then the call should result in a handler of RootController, indicating bar should be called:
	<?=
	var_export((
		$previous == 'bar' &&
		get_class($obj) == "Utils\Testing\RootController" &&
		$isEndpoint === true
	), true);
	?>

Scenario: Object Descent routing with variable chunk
	<?php $router = new \Magnus\Core\Router(); ?>

	Given a path with a variable chunk:
	<?php $path = array('1234'); ?>

	And a Foo Controller Object:
	<?php $rootObject = new \Utils\Testing\FooController(); ?>

	And this Foo Controller object contains a method named __get:
	<?= var_export(method_exists($rootObject, '__get'), true); ?>

	When routed:
	<?php
	foreach ($router($rootObject, $path) as list($previous, $obj, $isEndpoint)) {
		if ($isEndpoint) { break; }
	}
	?>

	Then the call should result in a handler of BarController, indicating __invoke() should be called:
	<?=
	var_export((
		$previous == null &&
		get_class($obj) == "Utils\Testing\BazController" &&
		$isEndpoint === false
	), true);
	?>

	And BazController should have a string ID of 1234:
	<?=
	var_export((
		$obj->id == '1234'
	), true);
	?>

Scenario: Object Descent routing with chunk referring to non-object property
	<?php $router = new \Magnus\Core\Router(); ?>

	Given a path with a chunk:
	<?php $path = array('qux'); ?>

	And a Root Controller Object:
	<?php $rootObject = new \Utils\Testing\RootController(); ?>

	And this Root Controller object contains a property that is a standard value:
	<?= var_export(($rootObject->qux == 'A static value'), true); ?>

	When routed:
	<?php
	foreach ($router($rootObject, $path) as list($previous, $obj, $isEndpoint)) {
		if ($isEndpoint) { break; }
	}
	?>

	Then the call should result in a static value for $obj to be used literally:
	<?=
	var_export((
		$previous === null &&
		$obj == 'A static value' &&
		$isEndpoint === true
	), true);
	?>

Scenario: Object Descent routing with descent and chunk referring to non-object property
	<?php $router = new \Magnus\Core\Router(); ?>

	Given a path with a chunk:
	<?php $path = array('foo', 'thud'); ?>

	And a Root Controller Object:
	<?php $rootObject = new \Utils\Testing\RootController(); ?>

	When routed:
	<?php
	foreach ($router($rootObject, $path) as list($previous, $obj, $isEndpoint)) {
		if ($isEndpoint) { break; }
	}
	?>

	Then the call should result in a static value for $obj to be used literally:
	<?=
	var_export((
		$previous === 'foo' &&
		$obj == 'Another static value' &&
		$isEndpoint === true
	), true);
	?>

<?= "\n\n"; ?>