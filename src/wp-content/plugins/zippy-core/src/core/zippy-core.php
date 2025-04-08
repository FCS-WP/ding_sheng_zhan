<?php

namespace Zippy_Core\Src\Core;

use Zippy_Core\Src\Core\Zippy_Admin;
use Zippy_Core\Src\Core\Zippy_Optimise;
use Zippy_Core\Src\Core\Zippy_Settings;


defined('ABSPATH') or die();

class Zippy_Core
{
  protected static $_instance = null;

  /**
   * @return Zippy_Core
   */

  public static function get_instance()
  {
    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct()
  {
    new Zippy_Settings;
    new Zippy_Admin;
    new Zippy_Optimise;


    add_action('phpmailer_init', array($this, 'setup_phpmailer_init'));

    add_filter('login_headerurl', array($this, 'custom_loginlogo_url'));

    add_action('login_enqueue_scripts', array($this, 'my_login_stylesheet'));

    add_filter('plugin_action_links', array($this, 'disable_plugin_deactivation'), 10, 4); //Prevent deactive
  }

  public function setup_phpmailer_init($phpmailer)
  {
    $phpmailer->Host = 'smtp.gmail.com'; // for example, smtp.mailtrap.io
    $phpmailer->Port = 587; // set the appropriate port: 465, 2525, etc.
    $phpmailer->Username = 'dev@zippy.sg'; // your SMTP username
    $phpmailer->Password = 'itmloqkardiuifmk'; // your SMTP password
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = 'tls'; // preferable but optional
    $phpmailer->IsSMTP();
  }

  public function disable_plugin_deactivation($actions, $plugin_file, $plugin_data, $context)
  {
    if ($plugin_file == 'zippy-core/zippy-sg-core.php') {
      unset($actions['deactivate']);
    }
    return $actions;
  }

  public function custom_loginlogo_url($url)
  {
    return '/';
  }

  public  function my_login_stylesheet()
  {
    $style = '<style type="text/css">body.login div#login h1 a{background-image:url("' . ZIPPY_CORE_URL . 'assets/images/logo-zippy.png");width:100%;background-size:100%}#login form#loginform .input,#login form#registerform .input,#login form#lostpasswordform .input{border-width:0px;border-radius:0px;border-bottom:1px solid #d2d2d2;-webkit-box-shadow:unset;box-shadow:unset}#login form .submit .button{background-color:#40A944;width:100%;height:40px;border-width:0px;margin-top:10px}.login .button.wp-hide-pw{color:#40A944}

  </style>';

    echo $style;
  }
}
