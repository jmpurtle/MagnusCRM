<?php
namespace Utils\Testing {
	
	class FooController {

		private $context;
		public $thud = 'Another static value';

		public function __construct($context = null) {
			$this->context = $context;
		}

		public function __invoke($context = null) {

			return array();

		}

		public function __get($id) {
			return new BazController($this->context, $id);
		}

	}
	
}
