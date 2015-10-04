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

		$menuItem = function ($m, $name, $uri, $perms=null, $icon=null){
			return $m->addChild($name)->setUri($uri)->setPermissions($perms)->setIcon($icon);
		};

		$factory = new MenuFactory();
        $menu = $factory->createItem('Backend Menu');
        $menu->setChildrenAttributes(array('class'=> 'sidebar-menu'));

        // users and groups menu
        $menuHeader($menu, 'Users & Groups');
        $userMenu = $menuItem($menu, 'Users', 'javascript:void(0)', 'viewUser', 'user');
        $menuItem($userMenu, 'Add User', site_url('admin/user/add'), 'addUser');
        $menuItem($userMenu, 'View All', site_url('admin/user'), 'viewUser');

        $groupMenu = $menuItem($menu, 'Groups', 'javascript:void(0)', 'viewUserGroup', 'users');
        $menuItem($groupMenu, 'Add Group', site_url('admin/user/group/add'), 'manageUserGroup');
        $menuItem($groupMenu, 'View All', site_url('admin/user/group'), 'viewUserGroup');

        // Posts and Pages
        $menuHeader($menu, 'Blog');
        $postMenu = $menuItem($menu, 'Posts', 'javascript:void(0)', 'viewPost', 'clone');

        $categoryMenu = $menuItem($postMenu, 'Category', 'javascript:void(0)', 'viewCategory', 'tasks');
        $menuItem($categoryMenu, 'Add Category', site_url('admin/post/category/add'), 'addCategory');
        $menuItem($categoryMenu, 'View All', site_url('admin/post/category'), 'viewCategory');

        $postTypeMenu = $menuItem($postMenu, 'Post Type', 'javascript:void(0)', 'viewPostType', 'file');
        $menuItem($postTypeMenu, 'Add Post Type', site_url('admin/post/type/add'), 'addPostType');
        $menuItem($postTypeMenu, 'View All', site_url('admin/post/type'), 'viewPostType');

        $menuItem($postMenu, 'Add Post', site_url('admin/post/add'), 'addPost');
        $menuItem($postMenu, 'View All', site_url('admin/post'), 'viewPost');

        $pageMenu = $menuItem($menu, 'Pages', 'javascript:void(0)', 'viewPage', 'file-text');
        $menuItem($pageMenu, 'Add Page', site_url('admin/page/add'), 'addPage');
        $menuItem($pageMenu, 'View All', site_url('admin/page'), 'viewPage');

        $renderer = new MenuRenderer(new \Knp\Menu\Matcher\Matcher());
        return $renderer->render($menu, array('currentClass'=> 'active', 'firstClass'=>'', 'lastClass'=>'', 'branch_class'=>'treeview'));
	}

	public function __createBackendMenu()
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
        $menuHeader($menu, 'Blog');
        $postMenu = $menu->addChild('Posts')
			->setUri('javascript:void(0)')
			->setIcon('file-text')
			->setPermissions('viewPost');
		$categoryMenu = $postMenu->addChild('Category')
			->setUri('javascript:void(0)')
			->setIcon('tasks')
			->setPermissions('viewCategory');
		$categoryMenu->addChild('Add Category')
			->setUri(site_url('admin/post/category/add'))
			->setPermissions('addCategory');
		$categoryMenu->addChild('View All')
			->setUri(site_url('admin/post/category'))
			->setPermissions('viewCategory');
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
