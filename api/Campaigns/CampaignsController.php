<?php
namespace Campaigns {
	
	class CampaignsController {

		private $context;

		public function __construct($context = null) {
			$this->context = $context;
		}

		public function __invoke($context = null) {

			return array(
				'HTTPStatusCode' => '200',
				'view'           => 'campaigns/index',
				'title'          => 'MagnusCRM - Campaigns'
			);

		}

		public function __get($id) {

			return new CampaignController($this->context, $id);
			
		}

	}
	
}