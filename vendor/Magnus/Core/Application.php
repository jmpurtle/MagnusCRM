<?php
namespace Magnus\Core {
	
	class Application {

		public $config;
		public $context;

		public function __construct($root, $config = array()) {
			/* Creates the initial application context and populates values.
			 * No actions other than configuration should occur at this time
			 *
			 * Current configuration is limited to two arguments:
			 *
			 * `root` -- The object used as the starting point of routing each 
			 * request
			 * `config` -- These are all the contextual properties and values 
			 * you wish to provide in addition
			 * to standard ones. For example, if your application uses 
			 * databases, you may pass database credentials into it.
			 * Application version numbers are another example.
			 */

			$this->config = $this->configure($config);

			$this->context = new Context();

			$this->context->extension = 'foo';
		}

		protected function configure($config = array()) {
			/* Prepares the incoming configuration and ensures certain expected values are present.
			 *
			 * For example, ensuring the base extension is included.
			 */
			if (!isset($config['extensions'])) {
				$config['extensions'] = array();
			}

			$baseExtensionIncluded = false;
			foreach ($config['extensions'] as $ext) {
				if (is_a($ext, 'Magnus\\Extensions\\BaseExtension')) {
					$baseExtensionIncluded = true;
					break;
				}
			}
			if (!$baseExtensionIncluded) {
				/* Always make sure the BaseExtension is present since
				 * request/response objects are handy.
				 */
				array_unshift($config['extensions'], new \Magnus\Extensions\BaseExtension());
			}

			$argumentExtensionIncluded = false;
			foreach ($config['extensions'] as $ext) {
				if (is_a($ext, 'Magnus\\Extensions\\ArgumentExtension')) {
					$argumentExtensionIncluded = true;
					break;
				}
			}
			if (!$argumentExtensionIncluded) {
				// Prepare a default set of argument mutators.
				array_push($config['extensions'],
					new \Magnus\Extensions\ValidateArgumentsExtension(),
					new \Magnus\Extensions\ContextArgsExtension(),
					new \Magnus\Extensions\RemainderArgsExtension(),
					new \Magnus\Extensions\QueryStringArgsExtension(),
					new \Magnus\Extensions\FormEncodedKwargsExtension(),
					new \Magnus\Extensions\JSONKwargsExtension()
				);
			}

			return $config;
		}
		
	}

}