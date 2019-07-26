<?php
namespace Magnus\Core {
	
	class Router {

		public function __construct() {

		}

		public function routeIterator(&$path) {

			/* Iterate through the path, popping elements from the left as they are seen. */

			$last = null;

			while ($path) {
				yield [$last, $path[0]];
				$last = array_shift($path);

				/* By shifting elements after they're yielded, we avoid having to put back a value in the event of a
				 * readjustment in the routing path performed by the __construct() method in route objects. Our testing
				 * has shown that direct array maninpulation is more performant than implementing SPLDoublyLinkedList
				 * for deque behavior. Likewise, just tracking the array index is a bit slower and adds complexity
				 * when dealing with reorients or reroutes.
				 */
			}

		}

		public function __invoke($obj, Array $path) {

			$previous   = null;
			$current    = null;
			$isEndpoint = false;

			$routeIterator = $this->routeIterator($path);

			foreach ($routeIterator as list($previous, $current)) {

				// This section would only be hit if there's more than one element in the path
				if (!is_object($obj)) {
					if (class_exists($obj)) {
						$obj = new $obj();
					} else {
						yield [$previous, $obj, true];
						return;
					}
				}

				/* Methods using this router are assumed to be endpoints
				 * 
				 * By uaing get_class_methods, we provide a timing safe collection of available methods.
				 * In addition to this, only public methods are exposed which prevents attempts against
				 * private or protected methods designed for internal functionality.
				 */
				if (in_array($current, get_class_methods($obj))) {
					// Since we found an endpoint, we'll break out of the loop early and yield values
					$isEndpoint = true;
					break;
				}

				/* No methods, huh? Let's check the public properties for controller references or static values.
				 * Like before, we make use of get_object_vars to obtain a safe set of values to check against.
				 */
				if (array_key_exists($current, get_object_vars($obj))) {
					yield [$previous, $obj, $isEndpoint];
					$obj = $obj->$current;
					continue;
				}

				/* Didn't find a reference or a static asset, might be a variable path element.
                 * Variable path elements are often denoted by {variable} in API documents. Such as {id} for
                 * selecting a specific ID version of a resource. It's expected by the dispatch protocol for
                 * controllers to implement __get for these variable path elements. __get will often times
                 * return a resource controller initialized with that specific ID. For example, in a
                 * PhotosController, the __get method would return a PhotoController($context, {id})
                 * For API clients that may not support altering the HTTP method beyond GET and POST, controllers
                 * may listen in __get for specific HTTP methods like 'put', 'patch', 'delete' and handle it
                 * accordingly.
                 */

				if (method_exists($obj, '__get')) {

					$obj = $obj->__get($current);
					yield [$previous, $obj, $isEndpoint];
					continue;
				}

				yield [$previous, $obj, $isEndpoint];
			}

			if ($routeIterator->valid()) {

				/* We bailed out of the loop early for whatever reason, so obj is our handler
				 * and current would be what we're using on obj.
				 */

				/* If it's an endpoint, we want to make the object and its method available
				 * to the application layer to dispatch upon
				 */
				if ($isEndpoint) { $previous = $current; }

				yield [$previous, $obj, $isEndpoint];
				return;
			}

			// A little duplication but the performance hit of extracting isn't worth it
			// We've run out of path elements to consume (if any)
			if (!is_object($obj)) {
				if (class_exists($obj)) {
					$obj = new $obj();
				} else {
					yield [$previous, $obj, true];
					return;
				}
			}

			yield [$previous, $obj, $isEndpoint];
			return;

		}
		
	}

}