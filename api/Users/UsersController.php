<?php
namespace Users {
	
	class UsersController {

		private $context;

		public function __construct($context = null) {
			$this->context = $context;
		}

		public function __invoke($context = null) {

			return array(
				'HTTPStatusCode' => '200',
				'view'           => 'users/index',
				'title'          => 'MagnusCRM - Users'
			);

		}

	}
	
}