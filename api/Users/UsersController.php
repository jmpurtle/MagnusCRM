<?php
namespace Users {
	
	class UsersController {

		private $context;
		private $model = '\\Users\\Collection';

		public function __construct($context = null) {
			$this->context = $context;
		}

		public function __invoke($context = null) {

			if ($this->context->request->getMethod() == 'POST') {
				return $this->createUser();
			}

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

		protected function createUser() {
			$user = new UserController($this->context, null);
			$user->createRecord($this->context->request->getRequestBody());
			$user->save();

			return $this->__get($user->id);
		}

		public function __get($id) {

			return new UserController($this->context, $id);
			
		}

	}
	
}