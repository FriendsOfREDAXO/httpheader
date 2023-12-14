<?php
/*
	Redaxo-Addon HTTP-Header
	Installation
	v1.1.3
	by Falko Müller @ 2021-2023
	package: redaxo5
*/

//Variablen deklarieren
$mypage = $this->getProperty('package');
$error = "";


//Vorgaben vornehmen
if (!$this->hasConfig()):
	$this->setConfig('config', [
		'h_connection'				=> 'checked',
		'h_connection_be'			=> '',
		'h_vary'					=> 'checked',
		'h_vary_be'					=> '',
		'h_server'					=> 'checked',
		'h_server_be'				=> '',
		'h_poweredby'				=> 'checked',
		'h_poweredby_be'			=> '',
		'h_contenttype'				=> '',
		'h_contenttype_be'			=> '',
		'h_frame'					=> '',
		'h_frame_be'				=> '',
		'h_frame_option'			=> 'SAMEORIGIN',
		'h_xss'						=> 'checked',
		'h_xss_be'					=> '',
		'h_xss_block'				=> 'checked',
		'h_referer'					=> 'checked',
		'h_referer_be'				=> '',
		'h_referer_option'			=> 'same-origin',
		'h_transport'				=> '',
		'h_transport_be'			=> '',
		'h_transport_maxage'		=> '31536000',
		'h_transport_subdomains'	=> '',
		'h_csp'						=> '',
		'h_csp_be'					=> '',
		'h_csp_noeditor'			=> '',
		'h_csp_definition'			=> '',
		
		'h_csp_default_https'		=> 'checked',
		'h_csp_default_data'		=> '',
		'h_csp_default_blob'		=> '',
		'h_csp_default_self'		=> '',
		'h_csp_default_inline'		=> '',
		'h_csp_default_eval'		=> '',
		'h_csp_default_hashes'		=> '',
		'h_csp_default_none'		=> '',
		'h_csp_default_url'			=> '',
		
		'h_csp_img_https'			=> '',
		'h_csp_img_data'			=> 'checked',
		'h_csp_img_blob'			=> '',
		'h_csp_img_self'			=> '',
		'h_csp_img_inline'			=> '',
		'h_csp_img_eval'			=> '',
		'h_csp_img_hashes'			=> '',
		'h_csp_img_none'			=> '',
		'h_csp_img_url'			=> '',
		
		'h_csp_media_https'			=> '',
		'h_csp_media_data'			=> '',
		'h_csp_media_blob'			=> '',
		'h_csp_media_self'			=> '',
		'h_csp_media_inline'		=> '',
		'h_csp_media_eval'			=> '',
		'h_csp_media_hashes'		=> '',
		'h_csp_media_none'			=> '',
		'h_csp_media_url'			=> '',
		
		'h_csp_font_https'			=> '',
		'h_csp_font_data'			=> 'checked',
		'h_csp_font_blob'			=> '',
		'h_csp_font_self'			=> '',
		'h_csp_font_inline'			=> '',
		'h_csp_font_eval'			=> '',
		'h_csp_font_hashes'			=> '',
		'h_csp_font_none'			=> '',
		'h_csp_font_url'			=> '',
		
		'h_csp_script_https'		=> '',
		'h_csp_script_data'			=> '',
		'h_csp_script_blob'			=> '',
		'h_csp_script_self'			=> '',
		'h_csp_script_inline'		=> 'checked',
		'h_csp_script_eval'			=> '',
		'h_csp_script_hashes'		=> '',
		'h_csp_script_none'			=> '',
		'h_csp_script_url'			=> '',
		
		'h_csp_style_https'			=> '',
		'h_csp_style_data'			=> '',
		'h_csp_style_blob'			=> '',
		'h_csp_style_self'			=> '',
		'h_csp_style_inline'		=> 'checked',
		'h_csp_style_eval'			=> '',
		'h_csp_style_hashes'		=> '',
		'h_csp_style_none'			=> '',
		'h_csp_style_url'			=> '',
		
		'h_csp_object_https'		=> '',
		'h_csp_object_data'			=> '',
		'h_csp_object_blob'			=> '',
		'h_csp_object_self'			=> '',
		'h_csp_object_inline'		=> '',
		'h_csp_object_eval'			=> '',
		'h_csp_object_hashes'		=> '',
		'h_csp_object_none'			=> '',
		'h_csp_object_url'			=> '',
		
		'h_csp_form_https'			=> '',
		'h_csp_form_data'			=> '',
		'h_csp_form_blob'			=> '',
		'h_csp_form_self'			=> 'checked',
		'h_csp_form_inline'			=> '',
		'h_csp_form_eval'			=> '',
		'h_csp_form_hashes'			=> '',
		'h_csp_form_none'			=> '',
		'h_csp_form_url'			=> '',
		
		'h_csp_frame_https'			=> '',
		'h_csp_frame_data'			=> '',
		'h_csp_frame_blob'			=> '',
		'h_csp_frame_self'			=> '',
		'h_csp_frame_inline'		=> '',
		'h_csp_frame_eval'			=> '',
		'h_csp_frame_hashes'		=> '',
		'h_csp_frame_none'			=> '',
		'h_csp_frame_url'			=> '',
		
		'h_csp_frameanc_https'		=> '',
		'h_csp_frameanc_data'		=> '',
		'h_csp_frameanc_blob'		=> '',
		'h_csp_frameanc_self'		=> '',
		'h_csp_frameanc_none'		=> 'checked',
		'h_csp_frameanc_url'		=> '',
		
		'h_csp_connect_https'		=> '',
		'h_csp_connect_data'		=> '',
		'h_csp_connect_blob'		=> '',
		'h_csp_connect_self'		=> '',
		'h_csp_connect_inline'		=> '',
		'h_csp_connect_eval'		=> '',
		'h_csp_connect_hashes'		=> '',
		'h_csp_connect_none'		=> '',
		'h_csp_connect_url'			=> '',
		
		'h_csp_manifest_https'		=> '',
		'h_csp_manifest_data'		=> '',
		'h_csp_manifest_blob'		=> '',
		'h_csp_manifest_self'		=> '',
		'h_csp_manifest_inline'		=> '',
		'h_csp_manifest_eval'		=> '',
		'h_csp_manifest_hashes'		=> '',
		'h_csp_manifest_none'		=> '',
		'h_csp_manifest_url'		=> '',


		'h_fpp'						=> '',
		'h_fpp_be'					=> '',
		'h_fpp_noeditor'			=> '',
		'h_fpp_definition_f'		=> '',
		'h_fpp_definition_p'		=> '',
		
		'h_fpp_cam_self'			=> '',
		'h_fpp_cam_none'			=> 'checked',
		
		'h_fpp_geo_self'			=> '',
		'h_fpp_geo_none'			=> 'checked',
		
		'h_fpp_gyro_self'			=> '',
		'h_fpp_gyro_none'			=> 'checked',
		
		'h_fpp_mag_self'			=> '',
		'h_fpp_mag_none'			=> 'checked',
		
		'h_fpp_mic_self'			=> '',
		'h_fpp_mic_none'			=> 'checked',
		
		'h_fpp_usb_self'			=> '',
		'h_fpp_usb_none'			=> 'checked',
		
		'h_fpp_docdom_self'			=> '',
		'h_fpp_docdom_none'			=> '',
		
		'h_fpp_full_self'			=> '',
		'h_fpp_full_none'			=> '',
		
		'h_fpp_pay_self'			=> '',
		'h_fpp_pay_none'			=> '',		
	]);
endif;


//Datenbank-Spalten anlegen, sofern noch nicht verfügbar


//Module anlegen


//Aktionen anlegen


//Templates anlegen
?>