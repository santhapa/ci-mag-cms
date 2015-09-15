<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/post'] = 'post/admin/post/index';
$route['admin/post/add'] = 'post/admin/post/add';
$route['admin/post/edit/(.+)'] = 'post/admin/post/edit/$1';
$route['admin/post/restore/(.+)'] = 'post/admin/post/restore/$1';
$route['admin/post/trash/(.+)'] = 'post/admin/post/trash/$1';
$route['admin/post/delete/(.+)'] = 'post/admin/post/delete/$1';

$route['admin/post/category'] = 'post/admin/category/index';
$route['admin/post/category/add'] = 'post/admin/category/add';
$route['admin/post/catgory/edit/(.+)'] = 'post/admin/category/edit/$1';
$route['admin/post/catgory/restore/(.+)'] = 'post/admin/category/restore/$1';
$route['admin/post/catgory/trash/(.+)'] = 'post/admin/category/trash/$1';
$route['admin/post/catgory/delete/(.+)'] = 'post/admin/category/delete/$1';
