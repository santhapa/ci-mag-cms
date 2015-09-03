<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PrayerController extends Frontend_Controller {

	public function todaysPrayer()
	{
		$prayerManager = $this->container->get('prayer.prayer_manager');
		$prayer = $prayerManager->getPrayerByDate(date('Y-m-d'));

		$this->templateData['prayer'] = $prayer;
		$this->templateData['content'] = 'prayer/index';

		$this->load->view('frontend/main_layout', $this->templateData);
	}
}