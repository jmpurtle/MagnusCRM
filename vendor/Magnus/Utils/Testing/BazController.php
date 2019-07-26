<?php
namespace Utils\Testing {
	
	class BazController {

		public $id;
		private $context;

		public function __construct($context, $id) {
			$this->context = $context;
			$this->id = $id;
		}

		public function __invoke($context = null) {

			return array($this->id);

		}

	}
	
}
