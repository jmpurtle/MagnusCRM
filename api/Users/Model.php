<?php
namespace Users {
	
	class Model extends \Models\MysqlInterface {

		protected $collection = 'users';
		public $record;

		public function get_one($id) {
			$query = 'SELECT * from ' . $this->collection . ' WHERE id = ?';
			$this->record = $this->executeQuery($query, array($id));
		}

		public function save() {
			/* Generally speaking, it's better to insert ... on duplicate key 
			 * update rather than replace into because replace into is 
			 * basically a DELETE + INSERT which causes issues for CASCADE
			 * and other foreign key constraints.
			 */

			$record = array($this->record['id'], $this->record['user'], $this->record['pass'], $this->record['email']);
			$updates = array($this->record['email']);

			$params = array_merge($record, $updates);
			$query = 'INSERT INTO ' . $this->collection . '(id, user, pass, email) values(?,?,?,?) ON DUPLICATE KEY UPDATE email = ?';

			$this->executeQuery($query, $params);
		}

	}

}