<?php
namespace Users {
	
	class Model extends \Models\MysqlInterface {

		protected $collection = 'users';
		public $record;

		public function get_one($id) {
			$query = 'SELECT * from ' . $this->collection . ' WHERE id = ?';
			$this->record = $this->executeQuery($query, array($id));
		}

	}

}