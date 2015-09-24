<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/page'] = 'page/admin/page/index';
$route['admin/page/add'] = 'page/admin/page/add';
$route['admin/page/edit/(.+)'] = 'page/admin/page/edit/$1';
$route['admin/page/publish/(.+)'] = 'page/admin/page/publish/$1';
$route['admin/page/restore/(.+)'] = 'page/admin/page/restore/$1';
$route['admin/page/trash/(.+)'] = 'page/admin/page/trash/$1';
$route['admin/page/delete/(.+)'] = 'page/admin/page/delete/$1';