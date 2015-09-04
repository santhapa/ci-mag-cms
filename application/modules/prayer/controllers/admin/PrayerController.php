<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PrayerController extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');

		$this->breadcrumbs->push('Prayer Request', site_url('admin/prayer'));
	}

	public function setModulePath()
	{
		return "prayer/backend/";
	}

	public function index()
	{	
		if(!\App::isGranted('viewPrayer')) redirect('admin/dashboard');

		$prayerManager = $this->container->get('prayer.prayer_manager');

		$perpage = 20;
		$offset = $this->input->get('per_page') ? $this->input->get('per_page') :'';

 		$prayers = $prayerManager->paginatePrayers($offset,$perpage);
 		$total = count($prayers);
 
 		if($total > $perpage)
 		{
 			$this->load->library('pagination');			
 			$config['base_url'] = base_url().'admin/prayer/index?';
 			$config['total_rows'] = $total;
 			$config['per_page'] = $perpage;
			$config['uri_segment'] = 3;
			$config['prev_link'] = 'Previous';
 			$config['next_link'] = 'Next';
 			$config['page_query_string'] = TRUE;
			
 			$this->pagination->initialize($config);
 			$this->templateData['pagination'] = $this->pagination->create_links();
 		}
		
		$this->templateData['offset'] = $offset;
		$this->templateData['prayers'] = $prayers;
		$this->templateData['pageTitle'] = 'Prayer Requests';
		$this->templateData['content'] = 'prayer/index';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function add()
	{
		if(!\App::isGranted('addPrayer')) redirect('admin/dashboard');

		if($this->input->post())
		{
			$prayerManager = $this->container->get('prayer.prayer_manager');
			$ruleManager = $this->container->get('prayer.rule_manager');
			$prayer = $prayerManager->createPrayer();

			$this->form_validation->set_rules($ruleManager->getRules(array('date', 'prayerRequest', 'verse', 'verseMessage', 'imageURL')));

			if($this->form_validation->run($this))
			{
				$prayer->setDate(new \DateTime($this->input->post('date')));
				$prayer->setPrayerRequest($this->input->post('prayerRequest'));
				$prayer->setVerse($this->input->post('verse'));
				$prayer->setVerseMessage($this->input->post('verseMessage'));
				$prayer->setImageURL(prep_url($this->input->post('imageURL')));
				
				$prayerManager->updatePrayer($prayer);

				$this->session->setFlashMessage('feedback', "New prayer request has been added.", 'success');
				redirect(site_url('admin/prayer'));
			}
		}

		$this->breadcrumbs->push('New', current_url());
		$this->templateData['pageTitle'] = 'Add Prayer Request';
		$this->templateData['content'] = 'prayer/new';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function edit($id)
	{
		if(!\App::isGranted('editPrayer')) redirect('admin/dashboard');

		try {
			if(!$id) throw new Exception("Error processing request.", 1);
			
			$prayerManager = $this->container->get('prayer.prayer_manager');
			$prayer = $prayerManager->getPrayerById($id);

			if(!$prayer) throw new Exception("Prayer request with the id ({$id}) not found.", 1);			

			if($this->input->post())
			{
				$ruleManager = $this->container->get('prayer.rule_manager');
				$this->form_validation->set_rules($ruleManager->getRules(array('prayerRequest', 'verse', 'verseMessage', 'imageURL')));

				if($prayer->getDate()->format('Y-m-d') != $this->input->post('date'))
				{
					$this->form_validation->set_rules($ruleManager->getRules(array('date')));
				}

				if($this->form_validation->run($this))
				{
					$prayer->setDate(new \DateTime($this->input->post('date')));
					$prayer->setPrayerRequest($this->input->post('prayerRequest'));
					$prayer->setVerse($this->input->post('verse'));
					$prayer->setVerseMessage($this->input->post('verseMessage'));
					$prayer->setImageURL(prep_url($this->input->post('imageURL')));
					
					$prayerManager->updatePrayer($prayer);

					$this->session->setFlashMessage('feedback', "Prayer request has been updated successfully.", 'success');
					redirect(site_url('admin/prayer'));
				}
			}

			$this->breadcrumbs->push('Edit', current_url());
			$this->templateData['prayer'] = $prayer;
			$this->templateData['pageTitle'] = 'Edit Prayer Request';
			$this->templateData['content'] = 'prayer/edit';
			$this->load->view('backend/main_layout', $this->templateData);
			
		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to edit prayer request: {$e->getMessage()}", 'error');
			redirect('admin/prayer');
		}
	}

	public function delete($id)
	{
		if(!\App::isGranted('deletePrayer')) redirect('admin/dashboard');

		try {
			if(!$id) throw new Exception("Error processing request.", 1);
			
			$prayerManager = $this->container->get('prayer.prayer_manager');
			$prayer = $prayerManager->getPrayerById($id);

			if(!$prayer) throw new Exception("Prayer request with the id ({$id}) not found.", 1);			

			$dPrayer = $prayer->getDate();

			$prayerManager->removePrayer($prayer);

			$this->session->setFlashMessage('feedback', "Prayer request of {$dPrayer->format('F d, Y')} has been deleted successfully.", 'success');
			redirect('admin/prayer');
			
		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to delete prayer request: {$e->getMessage()}", 'error');
			redirect('admin/prayer');
		}
	}

	public function import()
	{
		if(!\App::isGranted('addPrayer')) redirect('admin/dashboard');

		try {
			if($this->input->post())
			{
				if(isset($_FILES['excel_file']))
				{
					$config['upload_path'] = './assets/uploads/tmp/';
					$config['allowed_types'] = 'xlsx';
					$config['max_size']	= '1024';

					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload('excel_file'))
						throw new Exception($this->upload->display_errors(), 1);

					$excel = $this->upload->data();
					$this->readExcel($excel['full_path']);
					
					$this->session->setFlashMessage('feedback', "Prayer request has been imported successfully.", 'success');	
					redirect('admin/prayer');
				}
			}			
		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to import excel: {$e->getMessage()}", 'error');	
			redirect(current_url());
		}
		
		$this->breadcrumbs->push('Import', current_url());
		$this->templateData['pageTitle'] = 'Import Excel';
		$this->templateData['content'] = 'prayer/import_excel';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function readExcel($filename)
	{
		if(!\App::isGranted('addPrayer')) redirect('admin/dashboard');

		//  Read your Excel workbook
		try {
			$fileType = \PHPExcel_IOFactory::identify($filename);
			$objReader = \PHPExcel_IOFactory::createReader($fileType);
			$objPHPExcel = $objReader->load($filename);
		} catch(\Exception $e) {
			die('Error loading file "'.pathinfo($filename,PATHINFO_BASENAME).'": '.$e->getMessage());
		}

		//  Get worksheet dimensions
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();

		$prayerManager = $this->container->get('prayer.prayer_manager');

		//  Loop through each row of the worksheet in turn
		for ($row = 1; $row <= $highestRow; $row++)
		{ 
			//  Read a row of data into an array
			// $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
			if($row == 1)
			{
				$title = $rowData[0];
				$comp = array('Date', 'Prayer Message', 'Verse', 'Verse Message', 'Image');

				if(array_diff($title, $comp)){
					throw new Exception("Invalid excel sample. Check first row", 1);
				}
			}else{
				$data = $rowData[0];
				if(!$data[0] || !$data[1] || !$data[2] || !$data[3] || !$data[4])
					throw new Exception("Row data cannot be blank. All fields are required.", 1);

				$prayerDate = \PHPExcel_Shared_Date::ExcelToPHPObject($data[0]);
				// $prayerDate = $data[0];
				$prayerMsg = $data[1];
				$verse = trim($data[2]);
				$verseMsg = trim($data[3]);
				$imageUrl = prep_url(trim($data[4]));

				if($prayerManager->getPrayerByDate($prayerDate->format('Y-m-d')))
					throw new Exception("Prayer request for date '{$prayerDate->format('Y-m-d')}' already exists.", 1);
				
				$newPrayer = $prayerManager->createPrayer();

				$newPrayer->setPrayerRequest($prayerMsg);
				$newPrayer->setDate($prayerDate);
				$newPrayer->setVerse($verse);
				$newPrayer->setVerseMessage($verseMsg);
				$newPrayer->setImageURL($imageUrl);

				$prayerManager->updatePrayer($newPrayer, false);
			}
		}
		$this->doctrine->em->flush();
		return;
	}

	public function downloadSample()
	{
		$this->load->helper('download');
		$data = file_get_contents($this->config->item('current_theme_path').'/prayer/nimprayer-sample.xlsx'); 
		force_download('NIM_PRAYER_SAMPLE.xlsx', $data);
	}

}