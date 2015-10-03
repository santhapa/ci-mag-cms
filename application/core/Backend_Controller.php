<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

abstract class Backend_Controller extends MY_Controller {

	protected $modulePath;

	protected $templateData = array();

	public function __construct()
	{
		parent:: __construct();
		
		// // load permission from file to db
		// \App::init();

		if(!$this->session->userId){
			// configure referral link
			$requestUrl = str_replace( 
				array(
					$this->config->item('url_suffix'), 
					site_url(), 
					'auth/login'
				), 
				'', 
				current_url()
			);

			$this->session->set_tempdata('requestUrl', $requestUrl, 300);
			redirect('auth/login');
		}

		//load breadcrumb library for the backend panel
		$this->load->library('breadcrumbs');

		// initiate breadcrumb for backend
		$this->breadcrumbs->push('Dashboard', site_url('admin/dashboard'));

		//common template data
		$this->templateData['backendMenu'] = $this->createBackendMenu();
		$this->templateData['modulePath'] = $this->getModulePath();
		$this->templateData['pageTitle'] = "";
		$this->templateData['pageTitleSuffix'] = "Dashboard";
	}

	//force module controller extending this class to return the module path
	abstract public function setModulePath();

	public function getModulePath()
	{
		$this->modulePath = $this->setModulePath();
		return $this->modulePath;
	}

	public function createBackendMenu()
	{
		// returns the header for menu categorization
		$menuHeader = function ($m, $n){
			return $m->addChild(strtoupper($n))->setAttributes(array('class'=>'header'));
		};

		$factory = new MenuFactory();
        $menu = $factory->createItem('Backend Menu');
        $menu->setChildrenAttributes(array('class'=> 'sidebar-menu'));

        // users and groups menu
        $menuHeader($menu, 'Users & Groups');
        $userMenu = $menu->addChild('Users')
			->setUri('javascript:void(0)')
			->setIcon('user')
			->setPermissions('viewUser');
		$userMenu->addChild('Add User')
			->setUri(site_url('admin/user/add'))
			->setPermissions('addUser');
		$userMenu->addChild('View All')
			->setUri(site_url('admin/user'))
			->setPermissions('viewUser');

        $groupMenu = $menu->addChild('Groups')
			->setUri('javascript:void(0)')
			->setIcon('users')
			->setPermissions('viewUserGroup');
		$groupMenu->addChild('Add Group')
			->setUri(site_url('admin/user/group/add'))
			->setPermissions('manageUserGroup');
		$groupMenu->addChild('View All')
			->setUri(site_url('admin/user/group'))
			->setPermissions('viewUserGroup');

        // Posts and Pages
        $menuHeader($menu, 'Posts & Pages');
        $postMenu = $menu->addChild('Posts')
			->setUri('javascript:void(0)')
			->setIcon('file-text')
			->setPermissions('viewPost');
		$postMenu->addChild('Add Post')
			->setUri(site_url('admin/post/add'))
			->setPermissions('addPost');
		$postMenu->addChild('View All')
			->setUri(site_url('admin/post'))
			->setPermissions('viewPost');

        $pageMenu = $menu->addChild('Pages')
            ->setUri('javascript:void(0)')
			->setIcon('file')
            ->setPermissions('viewPage');
        $pageMenu->addChild('Add Page')
            ->setUri(site_url('admin/page/add'))
            ->setPermissions('addPage');
        $pageMenu->addChild('View All')
            ->setUri(site_url('admin/page'))
            ->setPermissions('viewPage');

        $renderer = new MenuRenderer(new \Knp\Menu\Matcher\Matcher());
        return $renderer->render($menu, array('currentClass'=> 'active', 'firstClass'=>'', 'lastClass'=>'', 'branch_class'=>'treeview'));
	}
}
