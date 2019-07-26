<?php
namespace Magnus\Core {

	class MagnusExtensions {

		/* Magnus extension management.
		 *
		 * This extension registry handles loading and access to
		 * extensions as well as the collection of standard Magnus
		 * Extension API callbacks. Reference the signals constant
		 * for a list of the individual callbacks that can be
		 * utilized and their meanings and the extensions
		 * example for more detailed descriptions.
		 *
		 * At a basic level, an extension is a class. That's it;
		 * attributes and methods are used to inform the manager of
		 * extension metadata and register callbacks for certain events.
		 * The most basic extension is one that does nothing:
		 *
		 * class Extension {}
		 *
		 * To register your extension, add a reference to it to your
		 * project's `entry_points` in your project's configurat
		 */
		const SIGNALS = array(
			'start', // Executed during Application construction
			'prepare', // Executed during initial request processing
			'routing', // Executed once per router event,
			'before', // Executed after all extension `prepare` methods have been called, prior to routing
			'mutate', // Inspect and potentially mutate arguments to the handler prior to execution
			'-after', // Executed after dispatching and response populated
			'-transform', // Transform the result returned by the handler and apply it to the response
			'-done', // Executed after the response has been consumed by the client
			'-middleware'
		);

		public function __construct($context) {

		}
	}

}