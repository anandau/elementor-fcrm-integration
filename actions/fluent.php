<?php
namespace WPV_EFI\Actions;

use Elementor\Controls_Manager;
use ElementorPro\Modules\Forms\Classes\Action_Base;

class Fluent extends Action_Base{

	public function get_name() {
		return 'wpv_fluent';
	}

	public function get_label() {
		return esc_html__('Fluent CRM Webhook', 'wpv-efi');
	}

	public function run( $record, $ajax_handler ) {
		$settings = $record->get( 'form_settings' );

		// Get submitetd Form data
		$raw_fields = $record->get( 'fields' );


		// Normalize the Form Data
		$fields = [];
		foreach ( $raw_fields as $id => $field ) {
			$fields[ $id ] = $field['value'];
		}

		$handle = curl_init($settings['wpv_fluent_webhook']);

		curl_setopt($handle, CURLOPT_POST, 1);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($handle, CURLOPT_VERBOSE, 1);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $fields);
		//curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		$result = curl_exec($handle);

		if(curl_errno($handle)){
			//echo 'Request Error:' . curl_error($handle);
			if (!function_exists('write_log')) {

				function write_log($log) {
					if (true === WP_DEBUG) {
						if (is_array($log) || is_object($log)) {
							error_log(print_r($log, true));
						} else {
							error_log($log);
						}
					}
				}

			}

			write_log($handle);
		}
	}

	public function register_settings_section( $widget ) {
		$widget->start_controls_section(
			'section_general',
			[
				'label' => __('Fluent CRM Webhook', 'wpv-efi'),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);
		$widget->add_control(
			'wpv_fluent_webhook',
			[
				'label'     => __('Webhook', 'wpv-efi'),
				'type'      => Controls_Manager::TEXT,
				'default'	=>	'',

			]
		);

		$widget->end_controls_section();
	}

	public function on_export( $element ) {}
}