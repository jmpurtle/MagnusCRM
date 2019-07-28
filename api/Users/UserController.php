<?php
namespace Users {
	
	class UserController {

		private $context;
		protected $id;

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

	}
	
}