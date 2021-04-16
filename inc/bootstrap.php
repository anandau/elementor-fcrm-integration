<?php

namespace WPV_EFI;

use WPV_EFI\Actions\Fluent;
use ElementorPro\Plugin;

class Bootstrap
{
	private static $_instance = null;

	public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct()
	{
		add_action('init', [$this, 'fluent_action']);
	}

	function fluent_action(){
		$formModule = Plugin::instance()->modules_manager->get_modules( 'forms' );
		require_once WPV_EFI_PATH.'/actions/fluent.php';
		$action = new Fluent();
		//Register the action with form widget
		$formModule->add_form_action( $action->get_name(), $action );
	}
}
Bootstrap::instance();