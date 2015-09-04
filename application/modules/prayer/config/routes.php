<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/prayer'] = 'prayer/admin/prayer/index';
$route['admin/prayer/add'] = 'prayer/admin/prayer/add';
$route['admin/prayer/edit/(.*)'] = 'prayer/admin/prayer/edit/$1';
$route['admin/prayer/delete/(.*)'] = 'prayer/admin/prayer/delete/$1';
$route['admin/prayer/(.+)'] = 'prayer/admin/prayer/$1';

$route['admin/prayer/import'] = 'prayer/admin/prayer/import';
$route['admin/prayer/readExcel/(.+)'] = 'prayer/admin/prayer/readExcel/$1';
$route['admin/prayer/downloadSample'] = 'prayer/admin/prayer/downloadSample';

