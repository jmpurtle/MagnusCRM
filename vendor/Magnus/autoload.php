<?php
namespace Magnus {
	spl_autoload_register(function ($className) {

		$classMap = array(
			// Extensions
			'Magnus\\Extensions\\BaseExtension'              => '/Extensions/base',
			'Magnus\\Extensions\\ArgumentExtension'          => '/Extensions/args',
			'Magnus\\Extensions\\ValidateArgumentsExtension' => '/Extensions/args',
			'Magnus\\Extensions\\ContextArgsExtension'       => '/Extensions/args',
			'Magnus\\Extensions\\RemainderArgsExtension'     => '/Extensions/args',
			'Magnus\\Extensions\\QueryStringArgsExtension'   => '/Extensions/args',
			'Magnus\\Extensions\\FormEncodedKwargsExtension' => '/Extensions/args',
			'Magnus\\Extensions\\JSONKwargsExtension'        => '/Extensions/args'
		);

		if (isset($classMap[$className])) {
			require_once __DIR__ . $classMap[$className] . '.php';
		}

		// Alternatives
		$className  = str_replace("\\", '/', $className);

		if (file_exists(__DIR__ . '/' . $className . '.php')) {
			require_once __DIR__ . '/' . $className . '.php';
		} else if (file_exists(dirname(__DIR__) . '/' . $className . '.php')) {
			require_once dirname(__DIR__) . '/' . $className . '.php';
		}
		
	});
}