<?php

/**
 * Admin Setting
 *
 * @package Shin
 */

namespace Zippy_Core\Src\Core;

defined('ABSPATH') or die();

class Zippy_Admin
{

	public function __construct()
	{
		//load all class in here
		$this->set_hooks();
	}

	protected function set_hooks()
	{
		//Change Footer Text in Admin

		add_filter('admin_footer_text', [$this, 'shin_change_footer_text']);

		add_action('admin_init', [$this, 'hide_admin_page_of_plugin'], 99);

		add_filter('acf/settings/show_admin', [$this, 'hide_acf_options_menu']);

		// hide site setting
		add_action('admin_init', [$this, 'hide_acf_options_menu'], 99);


		/*  Disable All Update Notifications with Code  */

		add_filter('pre_site_transient_update_core', [$this, 'remove_core_updates']);

		add_filter('pre_site_transient_update_plugins', [$this, 'remove_core_updates']);

		add_filter('pre_site_transient_update_themes', [$this, 'remove_core_updates']);
	}

	public function shin_change_footer_text()
	{
		echo "Core developed by <span ><a href='https://zippy.sg' target='_blank'>Zippy SG</a></span> ";
	}

	public function hide_admin_page_of_plugin()
	{
		remove_menu_page('unlimitedelements');
	}


	function hide_acf_options_menu()
	{

		if (!current_user_can('edit_theme_options')) {
			remove_menu_page('acf-options-site-settings');
		}
		return;
	}

	public function remove_core_updates()
	{
		global $wp_version;

		return (object) array('last_checked' => time(), 'version_checked' => $wp_version,);
	}
}
