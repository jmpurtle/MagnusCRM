<?php
namespace Magnus\Extensions {
	
	class BaseExtension {
		/* Base framework extension.
		 * This extension is not meant to be manually constructed or
		 * manipulated; use is automatic.
		 */

		public $first   = true;
		public $always  = true;
		public $provides = array("base", "request", "response");

	}

}