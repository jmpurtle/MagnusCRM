<?php
namespace Magnus\Core {
	
	class Requests {
		/* Requests is a request processing class for interpreting urls into path elements and additional
		 * arguments such as query strings and request bodies
		 */

		public function __construct() {
			
		}

		public function getPath($url = null) {
			if ($url === null) {
				$url = $_SERVER['REQUEST_URI'];
			}
			// We don't want to capture the QSA for this part
			$path = explode('?', $url)[0];

			// Splitting the url into chunks for consumption in routing
			$path = explode('/', $path);

			// Empty elements aren't tasty, no siree, get rid of them
			return array_values(array_filter($path));
		}

		public function getQSA($url = null) {
			if (php_sapi_name() == "cli") {
				//This'll be run instead for CLI mode as $_GET is automatically populated but blank
				$qsa = explode('?', $url);
				if (!isset($qsa[1])) {
					return array();
				} else {
					$qsa = $qsa[1];
				}
				$qsaSet = array();
				$chunks = explode('&', $qsa);

				foreach ($chunks as $qsaPair) {
					list($key, $value) = explode('=', $qsaPair);
					$qsaSet[$key] = $value;
				}
				return $qsaSet;
			}
			
			return $_GET;

		}

		public function getRequestBody() {
			return isset($_POST) ? $_POST : array();
		}

		public function extractHeaders() {
			if (!function_exists('getallheaders')) {
				if (!is_array($_SERVER)) {
		            return array();
		        }
		        $headers = array();
		        foreach ($_SERVER as $name => $value) {
		            if (substr($name, 0, 5) == 'HTTP_') {
		                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
		            }
		        }
		        return $headers;
			} 
			return getallheaders();
		}

	}
}