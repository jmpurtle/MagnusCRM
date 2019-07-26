<?php
namespace Contacts {
	
	class ContactController {

		private $context;
		public $id;

		public function __construct($context, $id) {
			$this->context = $context;
			$this->id = $id;
		}

		public function __invoke($context = null) {

			return array(
				'HTTPStatusCode' => '200',
				'view'           => 'contacts/index',
				'title'          => 'MagnusCRM - Contact: ' . $this->id
			);

		}

	}
	
}