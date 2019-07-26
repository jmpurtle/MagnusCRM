<?php
namespace Magnus\Extensions {
	
	class ArgumentExtension {
		// Not for direct use
	}

	class ValidateArgumentsExtension {
		/* Use this to enable validation of endpoint arguments.
		 * 
		 * You can determine when validation is executed (never, always
		 * or developmment) and what action is taken when a conflict occurs.
		 */

		public $last = true;
		public $provides = array('args.validation', 'kwargs.validation');

		public function __construct($kwargs = array('enabled' => 'development', 'correct' => false)) {
			/* Configure when validation is performed and the action performed.
			 *
			 * If `enabled` is true, validation will always be performed, if
			 * false, never. If set to `development`, the callback will not
			 * be assigned and no code will be executed during runtime.
			 *
			 * When `correct` is falsy (the default), a `NotFound` will be 
			 * returned if a conflict occurs. If truthy, the conflicting
			 * arguments are removed
			 */

		}
	}

	class ContextArgsExtension extends ArgumentExtension {
		// Adds the context as the first positional arg, conditionally

		public $first    = true;
		public $provides = array('args.context');
		public $always;

		public function __construct($always = false) {
			/* Configure the conditions under which the context is added to
			 * endpoint positional arguments.
			 *
			 * When `always` is truthy, the context is always included,
			 * otherwise it's only included for callables that are
			 * not bound methods
			 */
			$this->always = $always;
		}

	}

	class RemainderArgsExtension extends ArgumentExtension {
		// Adds any unprocessed path segments as positional args.

		public $first    = true;
		public $needs    = array('request');
		public $uses     = array('args.context');
		public $provides = array('args', 'args.remainder');

	}

	class QueryStringArgsExtension extends ArgumentExtension {
		// Add query string args ("GET") as keyword arguments.

		public $first    = true;
		public $needs    = array('request');
		public $provides = array('kwargs', 'kwargs.get');

	}

	class FormEncodedKwargsExtension extends ArgumentExtension {
		// Add form-encoded or MIME multipart ("POST") args as keyword args.

		public $first    = true;
		public $needs    = array('request');
		public $uses     = array('kwargs.get'); // QSA must be processed first
		public $provides = array('kwargs', 'kwargs.post');

	}

	class JSONKwargsExtension extends ArgumentExtension {
		// Adds JSON-encoded args from request body as keyword args.

		public $first    = true;
		public $needs    = array('request');
		public $uses     = array('kwargs.get'); // We override values defined
		public $provides = array('kwargs', 'kwargs.json');
		
	}

}