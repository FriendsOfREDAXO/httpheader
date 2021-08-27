<?php
/*
	Redaxo-Addon HTTP-Header
	Boot (weitere Konfigurationen)
	v1.0
	by Falko Müller @ 2021
	package: redaxo5
*/

//Variablen deklarieren
$mypage = $this->getProperty('package');
//$this->setProperty('name', 'Wert');

	//Berechtigungen deklarieren
	if (rex::isBackend() && is_object(rex::getUser())):
		rex_perm::register($mypage.'[]');
		//rex_perm::register($mypage.'[admin]');
	endif;


//Userrechte prüfen
$isAdmin = ( is_object(rex::getUser()) AND (rex::getUser()->hasPerm($mypage.'[admin]') OR rex::getUser()->isAdmin()) ) ? true : false;


//Addon Einstellungen
$config = rex_addon::get($mypage)->getConfig('config');			//Addon-Konfig einladen


//Funktionen einladen/definieren
//Global für Backend+Frontend
global $a1656_mypage;
$a1656_mypage = $mypage;


//Backendfunktionen
if (rex::isBackend() && rex::getUser()):
	require_once(rex_path::addon($mypage)."/functions/functions.inc.php");

	rex_view::addCssFile($this->getAssetsUrl('style.css'));
endif;



//alle Header ausgeben
$fe = rex::isFrontend();
$be = rex::isBackend();

//Connection keep-alive
if (@$config['h_connection'] == 'checked'):
	if ($fe || ($be && @$config['h_connection_be'] == 'checked')) 				{ rex_response::setHeader('Connection', 'keep-alive'); }
endif;


//Vary Accept-Encoding
if (@$config['h_vary'] == 'checked'):
	if ($fe || ($be && @$config['h_vary_be'] == 'checked'))						{ rex_response::setHeader('Vary', 'Accept-Encoding'); }
endif;


//Remove Server
if (@$config['h_server'] == 'checked'):
	if ($fe || ($be && @$config['h_server_be'] == 'checked'))					{ header_remove("Server"); rex_response::setHeader('Server', 'always unset'); }
endif;


//Remove X-Powered-By
if (@$config['h_poweredby'] == 'checked'):
	if ($fe || ($be && @$config['h_poweredby_be'] == 'checked'))				{ header_remove("X-Powered-By"); rex_response::setHeader('X-Powered-By', 'always unset'); }
endif;


//X-Content-Type-Options
if (@$config['h_contenttype'] == 'checked'):
	if ($fe || ($be && @$config['h_contenttype_be'] == 'checked'))				{ rex_response::setHeader('X-Content-Type-Options', 'nosniff'); }
endif;


//X-Frame-Options
if (@$config['h_frame'] == 'checked'):
	if ($fe || ($be && @$config['h_frame_be'] == 'checked'))					{ rex_response::setHeader('X-Frame-Options', ''.@$config['h_frame_option'].''); }
endif;


//X-XSS-Protection
if (@$config['h_xss'] == 'checked'):
	$opt = (@$config['h_xss_block'] == 'checked') ? '; mode=block' : '';
	
	if ($fe || ($be && @$config['h_xss_be'] == 'checked'))						{ rex_response::setHeader('X-XSS-Protection', '1'.$opt); }
endif;


//Referrer-Policy
if (@$config['h_referer'] == 'checked'):
	if ($fe || ($be && @$config['h_referer_be'] == 'checked'))					{ rex_response::setHeader('Referrer-Policy', ''.@$config['h_referer_option'].''); }
endif;


//Strict-Transport-Security
if (@$config['h_transport'] == 'checked'):
	$max = intval(@$config['h_transport_maxage']);
	$opt = ($max > 0) ? $max : '31536000';
	$opt .= (@$config['h_transport_subdomains'] == 'checked') ? '; includeSubDomains' : '';
	
	if ($fe || ($be && @$config['h_transport_be'] == 'checked'))				{ rex_response::setHeader('Strict-Transport-Security', 'max-age='.$opt); }
endif;


//Content-Security-Policy
if (@$config['h_csp'] == 'checked'):
	$opt = "";
	
	$def = @$config['h_csp_definition'];
	if (@$config['h_csp_noeditor'] == 'checked' && !empty($def)):
		//eigene Definition wird genutzt
		$opt .= trim(preg_replace('/^Content-Security-Policy:/i', '', $def));
	else:
		//Editor-Auswahl wird genutzt
		//default
		$tmp = "";
			$tmp .= (@$config['h_csp_default_https'] == 'checked') 		? " https:" : '';
			$tmp .= (@$config['h_csp_default_data'] == 'checked') 		? " data:" : '';
			$tmp .= (@$config['h_csp_default_blob'] == 'checked') 		? " blob:" : '';
			$tmp .= (@$config['h_csp_default_self'] == 'checked') 		? " 'self'" : '';
			$tmp .= (@$config['h_csp_default_inline'] == 'checked')		? " 'unsafe-inline'" : '';
			$tmp .= (@$config['h_csp_default_eval'] == 'checked') 		? " 'unsafe-eval'" : '';
			$tmp .= (@$config['h_csp_default_hashes'] == 'checked') 	? " 'unsafe-hashes'" : '';
			$tmp .= (@$config['h_csp_default_none'] == 'checked') 		? " 'none'" : '';
		$opt .= (!empty($tmp)) ? ' default-src'.$tmp.';' : '';
		
		//img
		$tmp = "";
			$tmp .= (@$config['h_csp_img_https'] == 'checked') 			? " https:" : '';
			$tmp .= (@$config['h_csp_img_data'] == 'checked') 			? " data:" : '';
			$tmp .= (@$config['h_csp_img_blob'] == 'checked') 			? " blob:" : '';
			$tmp .= (@$config['h_csp_img_self'] == 'checked') 			? " 'self'" : '';
			$tmp .= (@$config['h_csp_img_inline'] == 'checked')			? " 'unsafe-inline'" : '';
			$tmp .= (@$config['h_csp_img_eval'] == 'checked') 			? " 'unsafe-eval'" : '';
			$tmp .= (@$config['h_csp_img_hashes'] == 'checked') 		? " 'unsafe-hashes'" : '';
			$tmp .= (@$config['h_csp_img_none'] == 'checked') 			? " 'none'" : '';
		$opt .= (!empty($tmp)) ? ' img-src'.$tmp.';' : '';
		
		//media
		$tmp = "";
			$tmp .= (@$config['h_csp_media_https'] == 'checked') 		? " https:" : '';
			$tmp .= (@$config['h_csp_media_data'] == 'checked') 		? " data:" : '';
			$tmp .= (@$config['h_csp_media_blob'] == 'checked') 		? " blob:" : '';
			$tmp .= (@$config['h_csp_media_self'] == 'checked') 		? " 'self'" : '';
			$tmp .= (@$config['h_csp_media_inline'] == 'checked')		? " 'unsafe-inline'" : '';
			$tmp .= (@$config['h_csp_media_eval'] == 'checked') 		? " 'unsafe-eval'" : '';
			$tmp .= (@$config['h_csp_media_hashes'] == 'checked') 		? " 'unsafe-hashes'" : '';
			$tmp .= (@$config['h_csp_media_none'] == 'checked') 		? " 'none'" : '';
		$opt .= (!empty($tmp)) ? ' media-src'.$tmp.';' : '';
		
		//font
		$tmp = "";
			$tmp .= (@$config['h_csp_font_https'] == 'checked') 		? " https:" : '';
			$tmp .= (@$config['h_csp_font_data'] == 'checked') 			? " data:" : '';
			$tmp .= (@$config['h_csp_font_blob'] == 'checked') 			? " blob:" : '';
			$tmp .= (@$config['h_csp_font_self'] == 'checked') 			? " 'self'" : '';
			$tmp .= (@$config['h_csp_font_inline'] == 'checked')		? " 'unsafe-inline'" : '';
			$tmp .= (@$config['h_csp_font_eval'] == 'checked') 			? " 'unsafe-eval'" : '';
			$tmp .= (@$config['h_csp_font_hashes'] == 'checked') 		? " 'unsafe-hashes'" : '';
			$tmp .= (@$config['h_csp_font_none'] == 'checked') 			? " 'none'" : '';
		$opt .= (!empty($tmp)) ? ' font-src'.$tmp.';' : '';
		
		//script
		$tmp = "";
			$tmp .= (@$config['h_csp_script_https'] == 'checked') 		? " https:" : '';
			$tmp .= (@$config['h_csp_script_data'] == 'checked') 		? " data:" : '';
			$tmp .= (@$config['h_csp_script_blob'] == 'checked') 		? " blob:" : '';
			$tmp .= (@$config['h_csp_script_self'] == 'checked') 		? " 'self'" : '';
			$tmp .= (@$config['h_csp_script_inline'] == 'checked')		? " 'unsafe-inline'" : '';
			$tmp .= (@$config['h_csp_script_eval'] == 'checked') 		? " 'unsafe-eval'" : '';
			$tmp .= (@$config['h_csp_script_hashes'] == 'checked') 		? " 'unsafe-hashes'" : '';
			$tmp .= (@$config['h_csp_script_none'] == 'checked') 		? " 'none'" : '';
		$opt .= (!empty($tmp)) ? ' script-src'.$tmp.';' : '';
		
		//style
		$tmp = "";
			$tmp .= (@$config['h_csp_style_https'] == 'checked') 		? " https:" : '';
			$tmp .= (@$config['h_csp_style_data'] == 'checked') 		? " data:" : '';
			$tmp .= (@$config['h_csp_style_blob'] == 'checked') 		? " blob:" : '';
			$tmp .= (@$config['h_csp_style_self'] == 'checked') 		? " 'self'" : '';
			$tmp .= (@$config['h_csp_style_inline'] == 'checked')		? " 'unsafe-inline'" : '';
			$tmp .= (@$config['h_csp_style_eval'] == 'checked') 		? " 'unsafe-eval'" : '';
			$tmp .= (@$config['h_csp_style_hashes'] == 'checked') 		? " 'unsafe-hashes'" : '';
			$tmp .= (@$config['h_csp_style_none'] == 'checked') 		? " 'none'" : '';
		$opt .= (!empty($tmp)) ? ' style-src'.$tmp.';' : '';
		
		//object
		$tmp = "";
			$tmp .= (@$config['h_csp_object_https'] == 'checked') 		? " https:" : '';
			$tmp .= (@$config['h_csp_object_data'] == 'checked') 		? " data:" : '';
			$tmp .= (@$config['h_csp_object_blob'] == 'checked') 		? " blob:" : '';
			$tmp .= (@$config['h_csp_object_self'] == 'checked') 		? " 'self'" : '';
			$tmp .= (@$config['h_csp_object_inline'] == 'checked')		? " 'unsafe-inline'" : '';
			$tmp .= (@$config['h_csp_object_eval'] == 'checked') 		? " 'unsafe-eval'" : '';
			$tmp .= (@$config['h_csp_object_hashes'] == 'checked') 		? " 'unsafe-hashes'" : '';
			$tmp .= (@$config['h_csp_object_none'] == 'checked') 		? " 'none'" : '';
		$opt .= (!empty($tmp)) ? ' object-src'.$tmp.';' : '';
		
		//form-action
		$tmp = "";
			$tmp .= (@$config['h_csp_form_https'] == 'checked') 		? " https:" : '';
			$tmp .= (@$config['h_csp_form_data'] == 'checked') 			? " data:" : '';
			$tmp .= (@$config['h_csp_form_blob'] == 'checked') 			? " blob:" : '';
			$tmp .= (@$config['h_csp_form_self'] == 'checked') 			? " 'self'" : '';
			$tmp .= (@$config['h_csp_form_inline'] == 'checked')		? " 'unsafe-inline'" : '';
			$tmp .= (@$config['h_csp_form_eval'] == 'checked') 			? " 'unsafe-eval'" : '';
			$tmp .= (@$config['h_csp_form_hashes'] == 'checked') 		? " 'unsafe-hashes'" : '';
			$tmp .= (@$config['h_csp_form_none'] == 'checked') 			? " 'none'" : '';
		$opt .= (!empty($tmp)) ? ' form-action'.$tmp.';' : '';
		
		//frame
		$tmp = "";
			$tmp .= (@$config['h_csp_frame_https'] == 'checked') 		? " https:" : '';
			$tmp .= (@$config['h_csp_frame_data'] == 'checked') 		? " data:" : '';
			$tmp .= (@$config['h_csp_frame_blob'] == 'checked') 		? " blob:" : '';
			$tmp .= (@$config['h_csp_frame_self'] == 'checked') 		? " 'self'" : '';
			$tmp .= (@$config['h_csp_frame_inline'] == 'checked')		? " 'unsafe-inline'" : '';
			$tmp .= (@$config['h_csp_frame_eval'] == 'checked') 		? " 'unsafe-eval'" : '';
			$tmp .= (@$config['h_csp_frame_hashes'] == 'checked') 		? " 'unsafe-hashes'" : '';
			$tmp .= (@$config['h_csp_frame_none'] == 'checked') 		? " 'none'" : '';
		$opt .= (!empty($tmp)) ? ' frame-src'.$tmp.';' : '';
		
		//frame-ancestors
		$tmp = "";
			$tmp .= (@$config['h_csp_frameanc_https'] == 'checked') 	? " https:" : '';
			$tmp .= (@$config['h_csp_frameanc_data'] == 'checked') 		? " data:" : '';
			$tmp .= (@$config['h_csp_frameanc_blob'] == 'checked') 		? " blob:" : '';
			$tmp .= (@$config['h_csp_frameanc_self'] == 'checked') 		? " 'self'" : '';
			$tmp .= (@$config['h_csp_frameanc_none'] == 'checked') 		? " 'none'" : '';
		$opt .= (!empty($tmp)) ? ' frame-ancestors'.$tmp.';' : '';

	endif;
	
	if ($fe || ($be && @$config['h_csp_be'] == 'checked')):
		rex_response::setHeader('X-Content-Security-Policy', $opt);
		rex_response::setHeader('X-WebKit-CSP', $opt);
		rex_response::setHeader('Content-Security-Policy', $opt);
	endif;
endif;


//Featuer-/Permissions-Policy
if (@$config['h_fpp'] == 'checked'):
	$opt_f = $opt_p = "";
	
	$def_f = @$config['h_fpp_definition_f'];
	$def_p = @$config['h_fpp_definition_p'];
	if (@$config['h_fpp_noeditor'] == 'checked' && (!empty($def_f) || !empty($def_p))):
		//eigene Definition wird genutzt
		$opt_f .= trim(preg_replace('/^Feature-Policy:/i', '', $def_f));
		$opt_p .= trim(preg_replace('/^Permissions-Policy:/i', '', $def_p));
	else:
		//Editor-Auswahl wird genutzt
		//camera
		$tmp = "";
			$tmp .= (@$config['h_fpp_cam_self'] == 'checked') 			? " 'self'" : '';
			$tmp .= (@$config['h_fpp_cam_none'] == 'checked') 			? " 'none'" : '';
		$opt_f .= (!empty($tmp)) ? ' camera'.$tmp.';' : '';
		$opt_p .= (!empty($tmp)) ? ' camera=('.trim(str_replace(array(" 'none'", "'"), '', $tmp)).'),' : '';
		
		//geo
		$tmp = "";
			$tmp .= (@$config['h_fpp_geo_self'] == 'checked') 			? " 'self'" : '';
			$tmp .= (@$config['h_fpp_geo_none'] == 'checked') 			? " 'none'" : '';
		$opt_f .= (!empty($tmp)) ? ' geolocation'.$tmp.';' : '';
		$opt_p .= (!empty($tmp)) ? ' geolocation=('.trim(str_replace(array(" 'none'", "'"), '', $tmp)).'),' : '';
		
		//gyro
		$tmp = "";
			$tmp .= (@$config['h_fpp_gyro_self'] == 'checked') 			? " 'self'" : '';
			$tmp .= (@$config['h_fpp_gyro_none'] == 'checked') 			? " 'none'" : '';
		$opt_f .= (!empty($tmp)) ? ' gyroscope'.$tmp.';' : '';
		$opt_p .= (!empty($tmp)) ? ' gyroscope=('.trim(str_replace(array(" 'none'", "'"), '', $tmp)).'),' : '';
		
		//mag
		$tmp = "";
			$tmp .= (@$config['h_fpp_mag_self'] == 'checked') 			? " 'self'" : '';
			$tmp .= (@$config['h_fpp_mag_none'] == 'checked') 			? " 'none'" : '';
		$opt_f .= (!empty($tmp)) ? ' magnetometer'.$tmp.';' : '';
		$opt_p .= (!empty($tmp)) ? ' magnetometer=('.trim(str_replace(array(" 'none'", "'"), '', $tmp)).'),' : '';
		
		//mic
		$tmp = "";
			$tmp .= (@$config['h_fpp_mic_self'] == 'checked') 			? " 'self'" : '';
			$tmp .= (@$config['h_fpp_mic_none'] == 'checked') 			? " 'none'" : '';
		$opt_f .= (!empty($tmp)) ? ' microphone'.$tmp.';' : '';
		$opt_p .= (!empty($tmp)) ? ' microphone=('.trim(str_replace(array(" 'none'", "'"), '', $tmp)).'),' : '';
		
		//usb
		$tmp = "";
			$tmp .= (@$config['h_fpp_usb_self'] == 'checked') 			? " 'self'" : '';
			$tmp .= (@$config['h_fpp_usb_none'] == 'checked') 			? " 'none'" : '';
		$opt_f .= (!empty($tmp)) ? ' usb'.$tmp.';' : '';
		$opt_p .= (!empty($tmp)) ? ' usb=('.trim(str_replace(array(" 'none'", "'"), '', $tmp)).'),' : '';
		
		//docdom
		$tmp = "";
			$tmp .= (@$config['h_fpp_docdom_self'] == 'checked') 		? " 'self'" : '';
			$tmp .= (@$config['h_fpp_docdom_none'] == 'checked') 		? " 'none'" : '';
		$opt_f .= (!empty($tmp)) ? ' document-domain'.$tmp.';' : '';
		$opt_p .= (!empty($tmp)) ? ' document-domain=('.trim(str_replace(array(" 'none'", "'"), '', $tmp)).'),' : '';
		
		//full
		$tmp = "";
			$tmp .= (@$config['h_fpp_full_self'] == 'checked') 			? " 'self'" : '';
			$tmp .= (@$config['h_fpp_full_none'] == 'checked') 			? " 'none'" : '';
		$opt_f .= (!empty($tmp)) ? ' fullscreen'.$tmp.';' : '';
		$opt_p .= (!empty($tmp)) ? ' fullscreen=('.trim(str_replace(array(" 'none'", "'"), '', $tmp)).'),' : '';
		
		//pay
		$tmp = "";
			$tmp .= (@$config['h_fpp_pay_self'] == 'checked') 			? " 'self'" : '';
			$tmp .= (@$config['h_fpp_pay_none'] == 'checked') 			? " 'none'" : '';
		$opt_f .= (!empty($tmp)) ? ' payment'.$tmp.';' : '';
		$opt_p .= (!empty($tmp)) ? ' payment=('.trim(str_replace(array(" 'none'", "'"), '', $tmp)).'),' : '';


		//letztes Komma entfernen
		$opt_p = preg_replace("/,$/i", '', $opt_p);
	endif;
	
	if ($fe || ($be && @$config['h_fpp_be'] == 'checked')):
		rex_response::setHeader('Feature-Policy', $opt_f);
		rex_response::setHeader('Permissions-Policy', $opt_p);
	endif;
endif;

?>