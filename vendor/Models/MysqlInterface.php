<?php
namespace Models {
	use PDO;
	class MysqlInterface {

		public $conn;
		protected $hostID;
		protected $counter;
		protected $processID;
		protected $idData;

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

			$this->hostID = substr(md5(gethostname()), 0, 6);
			$this->counter = mt_rand();
			$this->processID = getmypid() % 0xFFFF;
			$this->idData = $this->getIdentity();
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

		public function getIdentity() {
			if (isset($this->idData)) {
				return $this->idData;
			}
			$userAgent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'None';
			$ipAddress = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : 'None';
			$this->idData = [
				'ua' => $userAgent,
				'ip' => $ipAddress
			];
			return $this->idData;
		}

		public function generateObjID() {
			return dechex(time()) . $this->hostID . dechex($this->processID) . dechex($this->counter++);
		}

	}

}