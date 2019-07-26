<?php
namespace Magnus\Core {
	
	class Dispatch {

		public $dispatchResponse = array();

		public function __construct() {

		}

		public function __invoke($pathElement, $endpoint) {

			if (!is_callable($endpoint)) {
				/* Endpoints don't have to be functions.
				 * They can instead point to what a function would return for view lookup.
				 *
				 * Use the result directly as if it were the result of calling a function or method
				 */

				return $endpoint;

			}

			if (in_array($pathElement, get_class_methods($endpoint))) {
				return $endpoint->$pathElement();
			}

			return $endpoint();

		}

		
	}

}
