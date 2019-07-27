<?php
namespace Users {
	
	class UsersController {

		private $context;
		private $model = '\\Users\\Collection';

		public function __construct($context = null) {
			$this->context = $context;
		}

		public function __invoke($context = null) {

			$model = new Collection($this->context->settings['dbDrivers']['mysql']);
			$model->get_many();

			$results = array();
			foreach ($model->results as $row) {
				$results[] = $row;
			}

			return array(
				'HTTPStatusCode' => '200',
				'view'           => 'users/index',
				'title'          => 'MagnusCRM - Users',
				'users'          => $results
			);

		}

		public function __get($id) {

			return new UserController($this->context, $id);
			
		}

	}
	
}