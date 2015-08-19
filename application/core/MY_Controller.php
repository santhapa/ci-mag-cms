<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Controller.php";
//load the mailer class to send mails
require APPPATH."third_party/Mailer/Mailer.php";

//load the restserver controller
// require(APPPATH.'/third_party/restserver/core/Restserver_controller.php');

class MY_Controller extends MX_Controller {}