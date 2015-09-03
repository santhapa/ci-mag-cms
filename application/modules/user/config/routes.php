<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/user'] = 'user/admin/user/index';
$route['admin/user/add'] = 'user/admin/user/add';
$route['admin/user/edit/(.+)'] = 'user/admin/user/edit/$1';
$route['admin/user/activate/(.+)'] = 'user/admin/user/activate/$1';
$route['admin/user/block/(.+)'] = 'user/admin/user/block/$1';
$route['admin/user/unblock/(.+)'] = 'user/admin/user/unblock/$1';
$route['admin/user/trash/(.+)'] = 'user/admin/user/trash/$1';
$route['admin/user/delete/(.+)'] = 'user/admin/user/delete/$1';
$route['admin/user/resetPassword/(.+)'] = 'user/admin/user/resetPassword/$1';
$route['admin/user/changePassword'] = 'user/admin/user/changePassword';
$route['admin/user/profile'] = 'user/admin/user/profile';

$route['admin/user/group'] = 'user/admin/group/index';
$route['admin/user/group/add'] = 'user/admin/group/add';
$route['admin/user/group/edit/(.+)'] = 'user/admin/group/edit/$1';
$route['admin/user/group/permissions/(.+)'] = 'user/admin/group/permissions/$1';
$route['admin/user/group/delete/(.+)'] = 'user/admin/group/delete/$1';
