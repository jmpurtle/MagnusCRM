<?php
namespace Models {
	use PDO;
	class MysqlInterface {

		public $conn;

		public function __construct(Array $config) {

			$connectionScheme = array(
				'host' => '',
				'port' => 3306,
				'name' => '',
				'user' => '',
				'pass' => ''
			);

			$connInfo = array_merge($connectionScheme, $config);
			$connString = "mysql:dbname={$connInfo['name']};host={$connInfo['host']};port={$connInfo['port']};";
			$pdoOpts = array(
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_SILENT,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false
			);

			$this->conn = new PDO($connString, $connInfo['user'], $connInfo['pass'], $pdoOpts);
		}

		public function executeQuery($query, Array $params = []) {

			if (!empty($params)) {
				$stmt = $this->conn->prepare($query);
				$stmt->execute($params);
				return $this->processResults($stmt);
			}

			$stmt = $this->conn->query($query);
			return $this->processResults($stmt);
		}

		protected function processResults($stmt) {
			while ($row = $stmt->fetch()) {
				yield $row;
			}
		}

	}

}