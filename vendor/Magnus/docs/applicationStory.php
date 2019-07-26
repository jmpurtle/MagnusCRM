<?php
$packageRoot = dirname(__DIR__);
require_once $packageRoot . '/autoload.php';

function printEval($expr) {
	return var_export($expr, true);
}
?>
Feature: Application
		 As a Website Builder
		 I want to build an application
		 So I can serve requests


Scenario: Loading blank application configuration

	Given an initialized application:
	<?php $app = new \Magnus\Core\Application(null); ?>

	Then the application should have just the extensions registry:
	<?= printEval(isset($app->config['extensions'])); ?>


Scenario: Loading an application configuration

	Given an initialized application with configuration passed in:
	<?php $app = new \Magnus\Core\Application(null, array('foo' => 'bar')); ?>

	Then the application should have extensions plus config passed in:
	<?= printEval($app->config['foo'] == 'bar' && isset($app->config['extensions'])); ?>


Scenario: Loading an application configuration with extensions

	Given an initialized application with configuration passed in:
	<?php $app = new \Magnus\Core\Application(null, array('extensions' => array('bar'))); ?>

	Then the application should have extensions plus config passed in:
	<?= printEval($app->config['extensions'][1] == 'bar'); ?>


Scenario: Including basic extensions

	Given an initialized application:
	<?php $app = new \Magnus\Core\Application(null); ?>

	Then the application should have a BaseExtension in it:
	<?= printEval(is_a($app->config['extensions'][0], 'Magnus\\Extensions\\BaseExtension')); ?>

	And the application should also have a ValidateArgumentsExtension in it:
	<?= printEval(is_a($app->config['extensions'][1], 'Magnus\\Extensions\\ValidateArgumentsExtension')); ?>

	And the application should also have a ContextArgsExtension in it:
	<?= printEval(is_a($app->config['extensions'][2], 'Magnus\\Extensions\\ContextArgsExtension')); ?>

	And the application should also have a RemainderArgsExtension in it:
	<?= printEval(is_a($app->config['extensions'][3], 'Magnus\\Extensions\\RemainderArgsExtension')); ?>

	And the application should also have a QueryStringArgsExtension in it:
	<?= printEval(is_a($app->config['extensions'][4], 'Magnus\\Extensions\\QueryStringArgsExtension')); ?>

	And the application should also have a FormEncodedKwargsExtension in it:
	<?= printEval(is_a($app->config['extensions'][5], 'Magnus\\Extensions\\FormEncodedKwargsExtension')); ?>

	And the application should also have a JSONKwargsExtension in it:
	<?= printEval(is_a($app->config['extensions'][6], 'Magnus\\Extensions\\JSONKwargsExtension')); ?>

Scenario: Including Context

	Given an initialized application:
	<?php $app = new \Magnus\Core\Application(null); ?>

	Then the application should have a Context object in it:
	<?= printEval(is_a($app->context, 'Magnus\\Core\\Context')); ?>

	<?= printEval($app->context->extension == 'foo'); ?>

<?= "\r\n"; ?>