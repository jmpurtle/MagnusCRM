<?php
namespace Magnus\Core {
	
	class Context {

		/* Overly simplistic metaclass for the time being. I may add in
		 * extra functionality later as the need arises.
		 */

		public $data;

		public function __construct($kwargs = array()) {
			$this->data = $kwargs;
		}

		public function __get($name) {

			if (!isset($this->data[$name])) {
				return null;
			}

			return $this->data[$name];

		}

		public function __set($name, $value) {
			$this->data[$name] = $value;
		}

		public function __unset($name) {
			unset($this->data[$name]);
		}

		public function __isset($name) {
			return isset($this->data[$name]);
		}

	}

}