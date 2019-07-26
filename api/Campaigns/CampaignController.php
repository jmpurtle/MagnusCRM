<?php
namespace Campaigns {
	
	class CampaignController {

		private $context;
		public $id;

		public function __construct($context, $id) {
			$this->context = $context;
			$this->id = $id;
		}

		public function __invoke($context = null) {

			return array(
				'HTTPStatusCode' => '200',
				'view'           => 'campaigns/index',
				'title'          => 'MagnusCRM - Campaign: ' . $this->id
			);

		}

	}
	
}