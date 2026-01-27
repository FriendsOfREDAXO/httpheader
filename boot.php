<?php

/*
    Redaxo-Addon HTTP-Header
    Boot (weitere Konfigurationen)
    v1.1.3
    by Falko Müller @ 2021-2023
    package: redaxo5
*/

// Variablen deklarieren
$mypage = $this->getProperty('package');
// $this->setProperty('name', 'Wert');
$addon = rex_addon::get('httpheader');

// Berechtigungen deklarieren
if (rex::isBackend() && is_object(rex::getUser())):
    rex_perm::register($mypage . '[]');
    // rex_perm::register($mypage.'[admin]');
endif;

// Userrechte prüfen
$isAdmin = (is_object(rex::getUser()) && (rex::getUser()->hasPerm($mypage . '[admin]') || rex::getUser()->isAdmin())) ? true : false;

// Addon Einstellungen
$config = rex_addon::get($mypage)->getConfig('config');			// Addon-Konfig einladen

// Funktionen einladen/definieren
// Backendfunktionen
if (rex::isBackend() && rex::getUser()):
    if ('httpheader' === rex_be_controller::getCurrentPagePart(1)) {
        require_once rex_path::addon($mypage) . '/functions/functions.inc.php';

        rex_view::addCssFile($addon->getAssetsUrl('css/style.css'));
        rex_view::addJsFile($addon->getAssetsUrl('js/script.js'), [rex_view::JS_IMMUTABLE => true]);
    }
endif;

// alle Header ausgeben
$fe = rex::isFrontend();
$be = rex::isBackend();

// ignore frontend-pages
if ($fe && is_string(@$config['h_ignore_fe']) && '' !== $config['h_ignore_fe']):
    $article_id = rex_request('article_id', 'int', 0);
    if (0 === $article_id && rex_addon::get('yrewrite')->isInstalled()) {
        $pathfile = rex_path::addonCache('yrewrite', 'pathlist.json');
        if (file_exists($pathfile)) {
            $paths = rex_file::getCache($pathfile);
            $urlteile = parse_url($_SERVER['REQUEST_URI']);
            $urlstring = ltrim($urlteile['path'] ?? '/', '/');
            if ($paths && isset($paths['paths'][$_SERVER['SERVER_NAME']])) {
                foreach ($paths['paths'][$_SERVER['SERVER_NAME']] as $key => $value) {
                    if ($value[1] === $urlstring) {
                        $article_id = $key;
                    }
                }
            }
        }
    }
    if (0 !== $article_id) {
        $ignore_ids = explode(',', $config['h_ignore_fe']);
        foreach ($ignore_ids as $ignore) {
            if ($article_id === (int) $ignore) {
                return;
            }
        }
    }
endif;

// Connection keep-alive
if ('checked' == @$config['h_connection']):
    if ($fe || ($be && 'checked' == @$config['h_connection_be'])) {
        rex_response::setHeader('Connection', 'keep-alive');
    }
endif;

// Vary Accept-Encoding
if ('checked' == @$config['h_vary']):
    if ($fe || ($be && 'checked' == @$config['h_vary_be'])) {
        rex_response::setHeader('Vary', 'Accept-Encoding');
    }
endif;

// Remove Server
if ('checked' == @$config['h_server']):
    if ($fe || ($be && 'checked' == @$config['h_server_be'])) {
        header_remove('Server');
        rex_response::setHeader('Server', 'always unset');
    }
endif;

// Remove X-Powered-By
if ('checked' == @$config['h_poweredby']):
    if ($fe || ($be && 'checked' == @$config['h_poweredby_be'])) {
        header_remove('X-Powered-By');
        rex_response::setHeader('X-Powered-By', 'always unset');
    }
endif;

// X-Content-Type-Options
if ('checked' == @$config['h_contenttype']):
    if ($fe || ($be && 'checked' == @$config['h_contenttype_be'])) {
        rex_response::setHeader('X-Content-Type-Options', 'nosniff');
    }
endif;

// X-Frame-Options
if ('checked' == @$config['h_frame']):
    if ($fe || ($be && 'checked' == @$config['h_frame_be'])) {
        rex_response::setHeader('X-Frame-Options', '' . @$config['h_frame_option'] . '');
    }
endif;

// X-XSS-Protection
if ('checked' == @$config['h_xss']):
    $opt = ('checked' == @$config['h_xss_block']) ? '; mode=block' : '';

    if ($fe || ($be && 'checked' == @$config['h_xss_be'])) {
        rex_response::setHeader('X-XSS-Protection', '1' . $opt);
    }
endif;

// Referrer-Policy
if ('checked' == @$config['h_referer']):
    if ($fe || ($be && 'checked' == @$config['h_referer_be'])) {
        rex_response::setHeader('Referrer-Policy', '' . @$config['h_referer_option'] . '');
    }
endif;

// Strict-Transport-Security
if ('checked' == @$config['h_transport']):
    $max = (int) (@$config['h_transport_maxage']);
    $opt = ($max > 0) ? $max : '31536000';
    $opt .= ('checked' == @$config['h_transport_subdomains']) ? '; includeSubDomains' : '';

    if ($fe || ($be && 'checked' == @$config['h_transport_be'])) {
        rex_response::setHeader('Strict-Transport-Security', 'max-age=' . $opt);
    }
endif;

// Content-Security-Policy
if ('checked' == @$config['h_csp']):
    $opt = '';

    $def = @$config['h_csp_definition'];
    if ('checked' == @$config['h_csp_noeditor'] && !empty($def)):
        // eigene Definition wird genutzt
        $opt .= trim(preg_replace('/^Content-Security-Policy:/i', '', $def));
    else:
        // Editor-Auswahl wird genutzt
        // default
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_default_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_default_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_default_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_default_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_default_inline']) ? " 'unsafe-inline'" : '';
        $tmp .= ('checked' == @$config['h_csp_default_eval']) ? " 'unsafe-eval'" : '';
        $tmp .= ('checked' == @$config['h_csp_default_hashes']) ? " 'unsafe-hashes'" : '';
        $tmp .= ('checked' == @$config['h_csp_default_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_default_url'])) ? ' ' . @$config['h_csp_default_url'] : '';
        $opt .= (!empty($tmp)) ? ' default-src' . $tmp . ';' : '';

        // img
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_img_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_img_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_img_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_img_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_img_inline']) ? " 'unsafe-inline'" : '';
        $tmp .= ('checked' == @$config['h_csp_img_eval']) ? " 'unsafe-eval'" : '';
        $tmp .= ('checked' == @$config['h_csp_img_hashes']) ? " 'unsafe-hashes'" : '';
        $tmp .= ('checked' == @$config['h_csp_img_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_img_url'])) ? ' ' . @$config['h_csp_img_url'] : '';
        $opt .= (!empty($tmp)) ? ' img-src' . $tmp . ';' : '';

        // media
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_media_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_media_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_media_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_media_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_media_inline']) ? " 'unsafe-inline'" : '';
        $tmp .= ('checked' == @$config['h_csp_media_eval']) ? " 'unsafe-eval'" : '';
        $tmp .= ('checked' == @$config['h_csp_media_hashes']) ? " 'unsafe-hashes'" : '';
        $tmp .= ('checked' == @$config['h_csp_media_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_media_url'])) ? ' ' . @$config['h_csp_media_url'] : '';
        $opt .= (!empty($tmp)) ? ' media-src' . $tmp . ';' : '';

        // font
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_font_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_font_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_font_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_font_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_font_inline']) ? " 'unsafe-inline'" : '';
        $tmp .= ('checked' == @$config['h_csp_font_eval']) ? " 'unsafe-eval'" : '';
        $tmp .= ('checked' == @$config['h_csp_font_hashes']) ? " 'unsafe-hashes'" : '';
        $tmp .= ('checked' == @$config['h_csp_font_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_font_url'])) ? ' ' . @$config['h_csp_font_url'] : '';
        $opt .= (!empty($tmp)) ? ' font-src' . $tmp . ';' : '';

        // script
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_script_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_script_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_script_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_script_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_script_inline']) ? " 'unsafe-inline'" : '';
        $tmp .= ('checked' == @$config['h_csp_script_eval']) ? " 'unsafe-eval'" : '';
        $tmp .= ('checked' == @$config['h_csp_script_hashes']) ? " 'unsafe-hashes'" : '';
        $tmp .= ('checked' == @$config['h_csp_script_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_script_url'])) ? ' ' . @$config['h_csp_script_url'] : '';
        $opt .= (!empty($tmp)) ? ' script-src' . $tmp . ';' : '';

        // style
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_style_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_style_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_style_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_style_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_style_inline']) ? " 'unsafe-inline'" : '';
        $tmp .= ('checked' == @$config['h_csp_style_eval']) ? " 'unsafe-eval'" : '';
        $tmp .= ('checked' == @$config['h_csp_style_hashes']) ? " 'unsafe-hashes'" : '';
        $tmp .= ('checked' == @$config['h_csp_style_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_style_url'])) ? ' ' . @$config['h_csp_style_url'] : '';
        $opt .= (!empty($tmp)) ? ' style-src' . $tmp . ';' : '';

        // object
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_object_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_object_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_object_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_object_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_object_inline']) ? " 'unsafe-inline'" : '';
        $tmp .= ('checked' == @$config['h_csp_object_eval']) ? " 'unsafe-eval'" : '';
        $tmp .= ('checked' == @$config['h_csp_object_hashes']) ? " 'unsafe-hashes'" : '';
        $tmp .= ('checked' == @$config['h_csp_object_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_object_url'])) ? ' ' . @$config['h_csp_object_url'] : '';
        $opt .= (!empty($tmp)) ? ' object-src' . $tmp . ';' : '';

        // form-action
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_form_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_form_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_form_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_form_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_form_inline']) ? " 'unsafe-inline'" : '';
        $tmp .= ('checked' == @$config['h_csp_form_eval']) ? " 'unsafe-eval'" : '';
        $tmp .= ('checked' == @$config['h_csp_form_hashes']) ? " 'unsafe-hashes'" : '';
        $tmp .= ('checked' == @$config['h_csp_form_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_form_url'])) ? ' ' . @$config['h_csp_form_url'] : '';
        $opt .= (!empty($tmp)) ? ' form-action' . $tmp . ';' : '';

        // frame
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_frame_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_frame_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_frame_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_frame_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_frame_inline']) ? " 'unsafe-inline'" : '';
        $tmp .= ('checked' == @$config['h_csp_frame_eval']) ? " 'unsafe-eval'" : '';
        $tmp .= ('checked' == @$config['h_csp_frame_hashes']) ? " 'unsafe-hashes'" : '';
        $tmp .= ('checked' == @$config['h_csp_frame_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_frame_url'])) ? ' ' . @$config['h_csp_frame_url'] : '';
        $opt .= (!empty($tmp)) ? ' frame-src' . $tmp . ';' : '';

        // frame-ancestors
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_frameanc_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_frameanc_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_frameanc_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_frameanc_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_frameanc_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_frameanc_url'])) ? ' ' . @$config['h_csp_frameanc_url'] : '';
        $opt .= (!empty($tmp)) ? ' frame-ancestors' . $tmp . ';' : '';

        // connect
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_connect_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_connect_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_connect_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_connect_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_connect_inline']) ? " 'unsafe-inline'" : '';
        $tmp .= ('checked' == @$config['h_csp_connect_eval']) ? " 'unsafe-eval'" : '';
        $tmp .= ('checked' == @$config['h_csp_connect_hashes']) ? " 'unsafe-hashes'" : '';
        $tmp .= ('checked' == @$config['h_csp_connect_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_connect_url'])) ? ' ' . @$config['h_csp_connect_url'] : '';
        $opt .= (!empty($tmp)) ? ' connect-src' . $tmp . ';' : '';

        // manifest
        $tmp = '';
        $tmp .= ('checked' == @$config['h_csp_manifest_https']) ? ' https:' : '';
        $tmp .= ('checked' == @$config['h_csp_manifest_data']) ? ' data:' : '';
        $tmp .= ('checked' == @$config['h_csp_manifest_blob']) ? ' blob:' : '';
        $tmp .= ('checked' == @$config['h_csp_manifest_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_csp_manifest_inline']) ? " 'unsafe-inline'" : '';
        $tmp .= ('checked' == @$config['h_csp_manifest_eval']) ? " 'unsafe-eval'" : '';
        $tmp .= ('checked' == @$config['h_csp_manifest_hashes']) ? " 'unsafe-hashes'" : '';
        $tmp .= ('checked' == @$config['h_csp_manifest_none']) ? " 'none'" : '';
        $tmp .= (!empty(@$config['h_csp_manifest_url'])) ? ' ' . @$config['h_csp_manifest_url'] : '';
        $opt .= (!empty($tmp)) ? ' manifest-src' . $tmp . ';' : '';

    endif;

if ($fe || ($be && 'checked' == @$config['h_csp_be'])):
    rex_response::setHeader('X-Content-Security-Policy', $opt);
    rex_response::setHeader('X-WebKit-CSP', $opt);
    rex_response::setHeader('Content-Security-Policy', $opt);
endif;
endif;

// Featuer-/Permissions-Policy
if ('checked' == @$config['h_fpp']):
    $opt_f = $opt_p = '';

    $def_f = @$config['h_fpp_definition_f'];
    $def_p = @$config['h_fpp_definition_p'];
    if ('checked' == @$config['h_fpp_noeditor'] && (!empty($def_f) || !empty($def_p))):
        // eigene Definition wird genutzt
        $opt_f .= trim(preg_replace('/^Feature-Policy:/i', '', $def_f));
        $opt_p .= trim(preg_replace('/^Permissions-Policy:/i', '', $def_p));
    else:
        // Editor-Auswahl wird genutzt
        // camera
        $tmp = '';
        $tmp .= ('checked' == @$config['h_fpp_cam_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_fpp_cam_none']) ? " 'none'" : '';
        $opt_f .= (!empty($tmp)) ? ' camera' . $tmp . ';' : '';
        $opt_p .= (!empty($tmp)) ? ' camera=(' . trim(str_replace([" 'none'", "'"], '', $tmp)) . '),' : '';

        // geo
        $tmp = '';
        $tmp .= ('checked' == @$config['h_fpp_geo_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_fpp_geo_none']) ? " 'none'" : '';
        $opt_f .= (!empty($tmp)) ? ' geolocation' . $tmp . ';' : '';
        $opt_p .= (!empty($tmp)) ? ' geolocation=(' . trim(str_replace([" 'none'", "'"], '', $tmp)) . '),' : '';

        // gyro
        $tmp = '';
        $tmp .= ('checked' == @$config['h_fpp_gyro_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_fpp_gyro_none']) ? " 'none'" : '';
        $opt_f .= (!empty($tmp)) ? ' gyroscope' . $tmp . ';' : '';
        $opt_p .= (!empty($tmp)) ? ' gyroscope=(' . trim(str_replace([" 'none'", "'"], '', $tmp)) . '),' : '';

        // mag
        $tmp = '';
        $tmp .= ('checked' == @$config['h_fpp_mag_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_fpp_mag_none']) ? " 'none'" : '';
        $opt_f .= (!empty($tmp)) ? ' magnetometer' . $tmp . ';' : '';
        $opt_p .= (!empty($tmp)) ? ' magnetometer=(' . trim(str_replace([" 'none'", "'"], '', $tmp)) . '),' : '';

        // mic
        $tmp = '';
        $tmp .= ('checked' == @$config['h_fpp_mic_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_fpp_mic_none']) ? " 'none'" : '';
        $opt_f .= (!empty($tmp)) ? ' microphone' . $tmp . ';' : '';
        $opt_p .= (!empty($tmp)) ? ' microphone=(' . trim(str_replace([" 'none'", "'"], '', $tmp)) . '),' : '';

        // usb
        $tmp = '';
        $tmp .= ('checked' == @$config['h_fpp_usb_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_fpp_usb_none']) ? " 'none'" : '';
        $opt_f .= (!empty($tmp)) ? ' usb' . $tmp . ';' : '';
        $opt_p .= (!empty($tmp)) ? ' usb=(' . trim(str_replace([" 'none'", "'"], '', $tmp)) . '),' : '';

        // docdom
        $tmp = '';
        $tmp .= ('checked' == @$config['h_fpp_docdom_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_fpp_docdom_none']) ? " 'none'" : '';
        $opt_f .= (!empty($tmp)) ? ' document-domain' . $tmp . ';' : '';
        $opt_p .= (!empty($tmp)) ? ' document-domain=(' . trim(str_replace([" 'none'", "'"], '', $tmp)) . '),' : '';

        // full
        $tmp = '';
        $tmp .= ('checked' == @$config['h_fpp_full_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_fpp_full_none']) ? " 'none'" : '';
        $opt_f .= (!empty($tmp)) ? ' fullscreen' . $tmp . ';' : '';
        $opt_p .= (!empty($tmp)) ? ' fullscreen=(' . trim(str_replace([" 'none'", "'"], '', $tmp)) . '),' : '';

        // pay
        $tmp = '';
        $tmp .= ('checked' == @$config['h_fpp_pay_self']) ? " 'self'" : '';
        $tmp .= ('checked' == @$config['h_fpp_pay_none']) ? " 'none'" : '';
        $opt_f .= (!empty($tmp)) ? ' payment' . $tmp . ';' : '';
        $opt_p .= (!empty($tmp)) ? ' payment=(' . trim(str_replace([" 'none'", "'"], '', $tmp)) . '),' : '';

        // letztes Komma entfernen
        $opt_p = preg_replace('/,$/i', '', $opt_p);
    endif;

if ($fe || ($be && 'checked' == @$config['h_fpp_be'])):
    rex_response::setHeader('Feature-Policy', $opt_f);
    rex_response::setHeader('Permissions-Policy', $opt_p);
endif;
endif;
