<?php
namespace Users {
	
	class UserController {

		private $context;
		public $id;
		protected $model;

		public function __construct($context, $id) {
			$this->context = $context;
			$this->id = $id;
		}

		public function __invoke($context = null) {

			$model = new Model($this->context->settings['dbDrivers']['mysql']);
			$model->get_one($this->id);

			$record = $model->record->current();

			return array(
				'HTTPStatusCode' => '200',
				'view'           => 'users/index',
				'title'          => 'MagnusCRM - User: ' . $this->id,
				'record'         => $record
			);

		}

		public function createRecord($post) {
			$model = new Model($this->context->settings['dbDrivers']['mysql']);
			// Fields
			$record = array(
				'id'    => null,
				'user'  => null,
				'pass'  => null,
				'email' => null
			);

			$record = array_merge($record, $post);

			if (!$record['id']) {
				$record['id'] = $model->generateObjID();
			}

			$record['pass'] = password_hash($record['pass'], PASSWORD_BCRYPT);

			$this->id = $record['id'];
			$model->record = $record;
			$this->model = $model;
		}

		public function save() {
			$this->model->save();
		}

	}
	
}