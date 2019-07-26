<?php
namespace Users {
	
	class UserController {

		private $context;
		public $id;

		public function __construct($context, $id) {
			$this->context = $context;
			$this->id = $id;
		}

		public function __invoke($context = null) {

			return array(
				'HTTPStatusCode' => '200',
				'view'           => 'users/index',
				'title'          => 'MagnusCRM - User: ' . $this->id
			);

		}

	}
	
}