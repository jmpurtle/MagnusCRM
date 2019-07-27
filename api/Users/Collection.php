<?php
namespace Users {
	
	class Collection extends \Models\MysqlInterface {

		protected $collection = 'users';
		public $results;

		public function get_many() {
			$query = 'SELECT * from ' . $this->collection;
			$this->results = $this->executeQuery($query);
		}

	}

}