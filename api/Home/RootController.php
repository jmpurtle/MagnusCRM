<?php
namespace Home {
	
	class RootController {

		private $context;

		public $users     = '\\Users\\UsersController';
		public $contacts  = '\\Contacts\\ContactsController';
		public $campaigns = '\\Campaigns\\CampaignsController';

		public function __construct($context = null) {
			$this->context = $context;
		}

		public function __invoke($context = null) {

			return array(
				'HTTPStatusCode' => '200',
				'view'           => 'home/index',
				'title'          => 'MagnusCRM'
			);

		}

	}
	
}