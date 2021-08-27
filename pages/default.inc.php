<?php
/*
	Redaxo-Addon HTTP-Header
	Verwaltung: Hauptseite (Default)
	v1.0
	by Falko Müller @ 2021
	package: redaxo5
*/

//Variablen deklarieren
$form_error = 0;

//Formular dieser Seite verarbeiten
if ($func == "save" && isset($_POST['submit'])):
	//Konfig speichern
	$newCfg = $this->getConfig('config');												//alte Config laden

	$newCfg = array_merge($newCfg, [													//neue Werte der Standardfelder hinzufügen
		'h_connection'				=> rex_post('h_connection'),
		'h_connection_be'			=> rex_post('h_connection_be'),
		'h_vary'					=> rex_post('h_vary'),
		'h_vary_be'					=> rex_post('h_vary_be'),
		'h_server'					=> rex_post('h_server'),
		'h_server_be'				=> rex_post('h_server_be'),
		'h_poweredby'				=> rex_post('h_poweredby'),
		'h_poweredby_be'			=> rex_post('h_poweredby_be'),
		'h_contenttype'				=> rex_post('h_contenttype'),
		'h_contenttype_be'			=> rex_post('h_contenttype_be'),
		'h_frame'					=> rex_post('h_frame'),
		'h_frame_be'				=> rex_post('h_frame_be'),
		'h_frame_option'			=> rex_post('h_frame_option'),
		'h_xss'						=> rex_post('h_xss'),
		'h_xss_be'					=> rex_post('h_xss_be'),
		'h_xss_block'				=> rex_post('h_xss_block'),
		'h_referer'					=> rex_post('h_referer'),
		'h_referer_be'				=> rex_post('h_referer_be'),
		'h_referer_option'			=> rex_post('h_referer_option'),
		'h_transport'				=> rex_post('h_transport'),
		'h_transport_be'			=> rex_post('h_transport_be'),
		'h_transport_maxage'		=> rex_post('h_transport_maxage'),
		'h_transport_subdomains'	=> rex_post('h_transport_subdomains'),
		'h_csp'						=> rex_post('h_csp'),
		'h_csp_be'					=> rex_post('h_csp_be'),
		'h_csp_noeditor'			=> rex_post('h_csp_noeditor'),
		'h_csp_definition'			=> rex_post('h_csp_definition'),
		
		'h_csp_default_https'		=> rex_post('h_csp_default_https'),
		'h_csp_default_data'		=> rex_post('h_csp_default_data'),
		'h_csp_default_blob'		=> rex_post('h_csp_default_blob'),
		'h_csp_default_self'		=> rex_post('h_csp_default_self'),
		'h_csp_default_inline'		=> rex_post('h_csp_default_inline'),
		'h_csp_default_eval'		=> rex_post('h_csp_default_eval'),
		'h_csp_default_hashes'		=> rex_post('h_csp_default_hashes'),
		'h_csp_default_none'		=> rex_post('h_csp_default_none'),
		
		'h_csp_img_https'			=> rex_post('h_csp_img_https'),
		'h_csp_img_data'			=> rex_post('h_csp_img_data'),
		'h_csp_img_blob'			=> rex_post('h_csp_img_blob'),
		'h_csp_img_self'			=> rex_post('h_csp_img_self'),
		'h_csp_img_inline'			=> rex_post('h_csp_img_inline'),
		'h_csp_img_eval'			=> rex_post('h_csp_img_eval'),
		'h_csp_img_hashes'			=> rex_post('h_csp_img_hashes'),
		'h_csp_img_none'			=> rex_post('h_csp_img_none'),
		
		'h_csp_media_https'			=> rex_post('h_csp_media_https'),
		'h_csp_media_data'			=> rex_post('h_csp_media_data'),
		'h_csp_media_blob'			=> rex_post('h_csp_media_blob'),
		'h_csp_media_self'			=> rex_post('h_csp_media_self'),
		'h_csp_media_inline'		=> rex_post('h_csp_media_inline'),
		'h_csp_media_eval'			=> rex_post('h_csp_media_eval'),
		'h_csp_media_hashes'		=> rex_post('h_csp_media_hashes'),
		'h_csp_media_none'			=> rex_post('h_csp_media_none'),
		
		'h_csp_font_https'			=> rex_post('h_csp_font_https'),
		'h_csp_font_data'			=> rex_post('h_csp_font_data'),
		'h_csp_font_blob'			=> rex_post('h_csp_font_blob'),
		'h_csp_font_self'			=> rex_post('h_csp_font_self'),
		'h_csp_font_inline'			=> rex_post('h_csp_font_inline'),
		'h_csp_font_eval'			=> rex_post('h_csp_font_eval'),
		'h_csp_font_hashes'			=> rex_post('h_csp_font_hashes'),
		'h_csp_font_none'			=> rex_post('h_csp_font_none'),
		
		'h_csp_script_https'		=> rex_post('h_csp_script_https'),
		'h_csp_script_data'			=> rex_post('h_csp_script_data'),
		'h_csp_script_blob'			=> rex_post('h_csp_script_blob'),
		'h_csp_script_self'			=> rex_post('h_csp_script_self'),
		'h_csp_script_inline'		=> rex_post('h_csp_script_inline'),
		'h_csp_script_eval'			=> rex_post('h_csp_script_eval'),
		'h_csp_script_hashes'		=> rex_post('h_csp_script_hashes'),
		'h_csp_script_none'			=> rex_post('h_csp_script_none'),
		
		'h_csp_style_https'			=> rex_post('h_csp_style_https'),
		'h_csp_style_data'			=> rex_post('h_csp_style_data'),
		'h_csp_style_blob'			=> rex_post('h_csp_style_blob'),
		'h_csp_style_self'			=> rex_post('h_csp_style_self'),
		'h_csp_style_inline'		=> rex_post('h_csp_style_inline'),
		'h_csp_style_eval'			=> rex_post('h_csp_style_eval'),
		'h_csp_style_hashes'		=> rex_post('h_csp_style_hashes'),
		'h_csp_style_none'			=> rex_post('h_csp_style_none'),
		
		'h_csp_object_https'		=> rex_post('h_csp_object_https'),
		'h_csp_object_data'			=> rex_post('h_csp_object_data'),
		'h_csp_object_blob'			=> rex_post('h_csp_object_blob'),
		'h_csp_object_self'			=> rex_post('h_csp_object_self'),
		'h_csp_object_inline'		=> rex_post('h_csp_object_inline'),
		'h_csp_object_eval'			=> rex_post('h_csp_object_eval'),
		'h_csp_object_hashes'		=> rex_post('h_csp_object_hashes'),
		'h_csp_object_none'			=> rex_post('h_csp_object_none'),
		
		'h_csp_form_https'			=> rex_post('h_csp_form_https'),
		'h_csp_form_data'			=> rex_post('h_csp_form_data'),
		'h_csp_form_blob'			=> rex_post('h_csp_form_blob'),
		'h_csp_form_self'			=> rex_post('h_csp_form_self'),
		'h_csp_form_inline'			=> rex_post('h_csp_form_inline'),
		'h_csp_form_eval'			=> rex_post('h_csp_form_eval'),
		'h_csp_form_hashes'			=> rex_post('h_csp_form_hashes'),
		'h_csp_form_none'			=> rex_post('h_csp_form_none'),
		
		'h_csp_frame_https'			=> rex_post('h_csp_frame_https'),
		'h_csp_frame_data'			=> rex_post('h_csp_frame_data'),
		'h_csp_frame_blob'			=> rex_post('h_csp_frame_blob'),
		'h_csp_frame_self'			=> rex_post('h_csp_frame_self'),
		'h_csp_frame_inline'		=> rex_post('h_csp_frame_inline'),
		'h_csp_frame_eval'			=> rex_post('h_csp_frame_eval'),
		'h_csp_frame_hashes'		=> rex_post('h_csp_frame_hashes'),
		'h_csp_frame_none'			=> rex_post('h_csp_frame_none'),
		
		'h_csp_frameanc_https'		=> rex_post('h_csp_frameanc_https'),
		'h_csp_frameanc_data'		=> rex_post('h_csp_frameanc_data'),
		'h_csp_frameanc_blob'		=> rex_post('h_csp_frameanc_blob'),
		'h_csp_frameanc_self'		=> rex_post('h_csp_frameanc_self'),
		'h_csp_frameanc_none'		=> rex_post('h_csp_frameanc_none'),
		
		
		'h_fpp'						=> rex_post('h_fpp'),
		'h_fpp_be'					=> rex_post('h_fpp_be'),
		'h_fpp_noeditor'			=> rex_post('h_fpp_noeditor'),
		'h_fpp_definition_f'		=> rex_post('h_fpp_definition_f'),
		'h_fpp_definition_p'		=> rex_post('h_fpp_definition_p'),
		
		'h_fpp_cam_self'			=> rex_post('h_fpp_cam_self'),
		'h_fpp_cam_none'			=> rex_post('h_fpp_cam_none'),
		
		'h_fpp_geo_self'			=> rex_post('h_fpp_geo_self'),
		'h_fpp_geo_none'			=> rex_post('h_fpp_geo_none'),
		
		'h_fpp_gyro_self'			=> rex_post('h_fpp_gyro_self'),
		'h_fpp_gyro_none'			=> rex_post('h_fpp_gyro_none'),
		
		'h_fpp_mag_self'			=> rex_post('h_fpp_mag_self'),
		'h_fpp_mag_none'			=> rex_post('h_fpp_mag_none'),
		
		'h_fpp_mic_self'			=> rex_post('h_fpp_mic_self'),
		'h_fpp_mic_none'			=> rex_post('h_fpp_mic_none'),
		
		'h_fpp_usb_self'			=> rex_post('h_fpp_usb_self'),
		'h_fpp_usb_none'			=> rex_post('h_fpp_usb_none'),
		
		'h_fpp_docdom_self'			=> rex_post('h_fpp_docdom_self'),
		'h_fpp_docdom_none'			=> rex_post('h_fpp_docdom_none'),
		
		'h_fpp_full_self'			=> rex_post('h_fpp_full_self'),
		'h_fpp_full_none'			=> rex_post('h_fpp_full_none'),
		
		'h_fpp_pay_self'			=> rex_post('h_fpp_pay_self'),
		'h_fpp_pay_none'			=> rex_post('h_fpp_pay_none'),
	]);

	$res = $this->setConfig('config', $newCfg);											//Config speichern (ersetzt komplett die alte Config)

	//Rückmeldung
	echo ($res) ? rex_view::info($this->i18n('a1656_settings_saved')) : rex_view::warning($this->i18n('a1656_error'));
endif;


//reload Konfig
$config = $this->getConfig('config');
	$config = aFM_maskArray($config);
	
//dump($config);	
?>


<script type="text/javascript">setTimeout(function() { jQuery('.alert-info').fadeOut(); }, 5000);</script>

<form action="index.php?page=<?php echo $page; ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="subpage" value="<?php echo $subpage; ?>" />
<input type="hidden" name="func" value="save" />

<section class="rex-page-section">
    <div class="panel panel-edit">
    
		<header class="panel-heading"><div class="panel-title"><?php echo $this->i18n('a1656_head_basics'); ?></div></header>
        
		<div class="panel-body">

			<legend><?php echo $this->i18n('a1656_subheader_basic1'); ?></legend>
            
             
            <!-- connection keep-alive -->
            <div class="boxed-group">
                <dl class="rex-form-group form-group">
                    <dt><label for=""><?php echo $this->i18n('a1656_bas_h_connection'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_connection">
                            <input name="h_connection" type="checkbox" id="h_connection" class="toggle" value="checked" <?php echo @$config['h_connection']; ?> /> <?php echo $this->i18n('a1656_bas_active'); ?>
                        </label>
                        </div>
                    </dd>
                    
                   
                   <div class="checkbox includebackend">
                        <label for="h_connection_be">
                            <input name="h_connection_be" type="checkbox" id="h_connection_be" class="toggle" value="checked" <?php echo @$config['h_connection_be']; ?> /> <?php echo $this->i18n('a1656_bas_includebackend'); ?>
                        </label>
                   </div> 
                </dl>
            </div>
            
			
            <!-- vary acept-encoding -->
            <div class="boxed-group">
                <dl class="rex-form-group form-group">
                    <dt><label for=""><?php echo $this->i18n('a1656_bas_h_vary'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_vary">
                            <input name="h_vary" type="checkbox" id="h_vary" class="toggle" value="checked" <?php echo @$config['h_vary']; ?> /> <?php echo $this->i18n('a1656_bas_active'); ?>
                        </label>
                        </div>
                    </dd>
                    
                   
                   <div class="checkbox includebackend">
                        <label for="h_vary_be">
                            <input name="h_vary_be" type="checkbox" id="h_vary_be" class="toggle" value="checked" <?php echo @$config['h_vary_be']; ?> /> <?php echo $this->i18n('a1656_bas_includebackend'); ?>
                        </label>
                   </div> 
                </dl>
            </div>
            
            

            <dl class="rex-form-group form-group"><dt></dt></dl>
            
			<legend><?php echo $this->i18n('a1656_subheader_basic2'); ?></legend>
            
			
            <!-- remove server -->
            <div class="boxed-group">
                <dl class="rex-form-group form-group">
                    <dt><label for=""><?php echo $this->i18n('a1656_bas_h_server'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_server">
                            <input name="h_server" type="checkbox" id="h_server" class="toggle" value="checked" <?php echo @$config['h_server']; ?> /> <?php echo $this->i18n('a1656_bas_remove'); ?>
                        </label>
                        </div>
                    </dd>
                    
                   
                   <div class="checkbox includebackend">
                        <label for="h_server_be">
                            <input name="h_server_be" type="checkbox" id="h_server_be" class="toggle" value="checked" <?php echo @$config['h_server_be']; ?> /> <?php echo $this->i18n('a1656_bas_includebackend'); ?>
                        </label>
                   </div> 
                </dl>
            </div>
            
			
            <!-- remove x-powered-by -->
            <div class="boxed-group">
                <dl class="rex-form-group form-group">
                    <dt><label for=""><?php echo $this->i18n('a1656_bas_h_poweredby'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_poweredby">
                            <input name="h_poweredby" type="checkbox" id="h_poweredby" class="toggle" value="checked" <?php echo @$config['h_poweredby']; ?> /> <?php echo $this->i18n('a1656_bas_remove'); ?>
                        </label>
                        </div>
                    </dd>
                    
                   
                   <div class="checkbox includebackend">
                        <label for="h_poweredby_be">
                            <input name="h_poweredby_be" type="checkbox" id="h_poweredby_be" class="toggle" value="checked" <?php echo @$config['h_poweredby_be']; ?> /> <?php echo $this->i18n('a1656_bas_includebackend'); ?>
                        </label>
                   </div> 
                </dl>
            </div>
            
			
            <!-- X-Content-Type-Options -->
            <div class="boxed-group">
                <dl class="rex-form-group form-group">
                    <dt><label for=""><?php echo $this->i18n('a1656_bas_h_contenttype'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_contenttype">
                            <input name="h_contenttype" type="checkbox" id="h_contenttype" class="toggle" value="checked" <?php echo @$config['h_contenttype']; ?> /> <?php echo $this->i18n('a1656_bas_active'); ?>
                        </label>
                        </div>
                    </dd>
                    
                   
                   <div class="checkbox includebackend">
                        <label for="h_contenttype_be">
                            <input name="h_contenttype_be" type="checkbox" id="h_contenttype_be" class="toggle" value="checked" <?php echo @$config['h_contenttype_be']; ?> /> <?php echo $this->i18n('a1656_bas_includebackend'); ?>
                        </label>
                   </div> 
                </dl>
			</div>
            
			
            <!-- X-Frame-Options -->
            <div class="boxed-group">
                <dl class="rex-form-group form-group">
                    <dt><label for=""><?php echo $this->i18n('a1656_bas_h_frame'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_frame">
                            <input name="h_frame" type="checkbox" id="h_frame" class="toggle" value="checked" <?php echo @$config['h_frame']; ?> data-opener="#h_frame_option" /> <?php echo $this->i18n('a1656_bas_active'); ?>
                        </label>
                        </div>
                    </dd>
                </dl>
 
 				<div class="hiddencontent <?php echo @$config['h_frame']; ?>" id="h_frame_option">
				<dl class="rex-form-group form-group">
					<dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_property'); ?></label></dt>
                    <dd>                        
                        <select size="1" name="h_frame_option" class="form-control" id="h_frame_option">
                            <?php
                            $arr = array('DENY', 'SAMEORIGIN');
                            
                            foreach ($arr as $val):
                                $sel = ($config['h_frame_option'] == $val) ? 'selected' : '';
                                echo '<option value="'.$val.'" '.$sel.'>'.$val.'</option>';
                            endforeach;
                            ?>
                        </select>                    
                    </dd>
                </dl>
                </div>
               
                
                <div class="checkbox includebackend">
                    <label for="h_frame_be">
                        <input name="h_frame_be" type="checkbox" id="h_frame_be" class="toggle" value="checked" <?php echo @$config['h_frame_be']; ?> /> <?php echo $this->i18n('a1656_bas_includebackend'); ?>
                    </label>
                </div> 
            </div>
            
			
            <!-- X-XSS-Protection -->
            <div class="boxed-group">
                <dl class="rex-form-group form-group">
                    <dt><label for=""><?php echo $this->i18n('a1656_bas_h_xss'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_xss">
                            <input name="h_xss" type="checkbox" id="h_xss" class="toggle" value="checked" <?php echo @$config['h_xss']; ?> data-opener="#h_xss_block" /> <?php echo $this->i18n('a1656_bas_active'); ?>
                        </label>
                        </div>
                    </dd>
                </dl>
 
 				<div class="hiddencontent <?php echo @$config['h_xss']; ?>" id="h_xss_block">
                <dl class="rex-form-group form-group">
                    <dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_h_xss_block'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_xss_block">
                            <input name="h_xss_block" type="checkbox" id="h_xss_block" class="toggle" value="checked" <?php echo @$config['h_xss_block']; ?> /> <?php echo $this->i18n('a1656_bas_active'); ?>
                        </label>
                        </div>
                    </dd>
                </dl>
                </div>
               
                
                <div class="checkbox includebackend">
                    <label for="h_xss_be">
                        <input name="h_xss_be" type="checkbox" id="h_xss_be" class="toggle" value="checked" <?php echo @$config['h_xss_be']; ?> /> <?php echo $this->i18n('a1656_bas_includebackend'); ?>
                    </label>
                </div> 
            </div>
            
			
            <!-- Referrer-Policy -->
            <div class="boxed-group">
                <dl class="rex-form-group form-group">
                    <dt><label for=""><?php echo $this->i18n('a1656_bas_h_referer'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_referer">
                            <input name="h_referer" type="checkbox" id="h_referer" class="toggle" value="checked" <?php echo @$config['h_referer']; ?> data-opener="#h_referer_option" /> <?php echo $this->i18n('a1656_bas_active'); ?>
                        </label>
                        </div>
                    </dd>
                </dl>
 
 				<div class="hiddencontent <?php echo @$config['h_referer']; ?>" id="h_referer_option">
				<dl class="rex-form-group form-group">
					<dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_property'); ?></label></dt>
                    <dd>                        
                        <select size="1" name="h_referer_option" class="form-control" id="h_referer_option">
                            <?php
                            $arr = array('no-referrer', 'no-referrer-when-downgrade', 'same-origin', 'origin', 'strict-origin', 'origin-when-cross-origin', 'strict-origin-when-cross-origin', 'unsafe-url');
                            
                            foreach ($arr as $val):
                                $sel = ($config['h_referer_option'] == $val) ? 'selected' : '';
                                echo '<option value="'.$val.'" '.$sel.'>'.$val.'</option>';
                            endforeach;
                            ?>
                        </select>                    
                    </dd>
                </dl>
                </div>
               
                
                <div class="checkbox includebackend">
                    <label for="h_referer_be">
                        <input name="h_referer_be" type="checkbox" id="h_referer_be" class="toggle" value="checked" <?php echo @$config['h_referer_be']; ?> /> <?php echo $this->i18n('a1656_bas_includebackend'); ?>
                    </label>
                </div> 
            </div>
            
			
            <!-- Strict-Transport-Security -->
            <div class="boxed-group">
                <dl class="rex-form-group form-group">
                    <dt><label for=""><?php echo $this->i18n('a1656_bas_h_transport'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_transport">
                            <input name="h_transport" type="checkbox" id="h_transport" class="toggle" value="checked" <?php echo @$config['h_transport']; ?> data-opener="#h_transport_option" /> <?php echo $this->i18n('a1656_bas_active'); ?>
                        </label>
                        </div>
                    </dd>
                </dl>
 
 				<div class="hiddencontent <?php echo @$config['h_transport']; ?>" id="h_transport_option">
				<dl class="rex-form-group form-group">
					<dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_h_transport_maxage'); ?></label></dt>
                    <dd>                        
						<input type="text" size="25" name="h_transport_maxage" id="h_transport_maxage" value="<?php echo @$config['h_transport_maxage']; ?>" maxlength="15" class="form-control" />
                    </dd>
                </dl>
                
                <dl class="rex-form-group form-group">
                    <dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_h_transport_subdomains'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_transport_subdomains">
                            <input name="h_transport_subdomains" type="checkbox" id="h_transport_subdomains" class="toggle" value="checked" <?php echo @$config['h_transport_subdomains']; ?> /> <?php echo $this->i18n('a1656_bas_active'); ?>
                        </label>
                        </div>
                    </dd>
                </dl>                
                </div>
               
                
                <div class="checkbox includebackend">
                    <label for="h_transport_be">
                        <input name="h_transport_be" type="checkbox" id="h_transport_be" class="toggle" value="checked" <?php echo @$config['h_transport_be']; ?> /> <?php echo $this->i18n('a1656_bas_includebackend'); ?>
                    </label>
                </div> 
            </div>

			
            <!-- X-Content-Security-Policy -->
            <div class="boxed-group">
                <dl class="rex-form-group form-group">
                    <dt><label for=""><?php echo $this->i18n('a1656_bas_h_csp'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_csp">
                            <input name="h_csp" type="checkbox" id="h_csp" class="toggle" value="checked" <?php echo @$config['h_csp']; ?> data-opener="#h_csp_option" /> <?php echo $this->i18n('a1656_bas_active'); ?>
                        </label>
                        </div>
                    </dd>
                </dl>
 
 				<div class="hiddencontent <?php echo @$config['h_csp']; ?>" id="h_csp_option">
                <dl class="rex-form-group form-group">
                    <dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_h_csp_noeditor'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_csp_noeditor">
                            <input name="h_csp_noeditor" type="checkbox" id="h_csp_noeditor" class="toggle" value="checked" <?php echo @$config['h_csp_noeditor']; ?> /> <?php echo $this->i18n('a1656_yes'); ?>
                        </label>
                        </div>
                    </dd>
                </dl>
                
                
                <dl class="rex-form-group form-group"><dt>&nbsp;</dt></dl>
                
                
                <div class="hiddencontent <?php echo @$config['h_csp_noeditor']; ?>" id="h_csp_option_noeditor">
                	<!-- CSP-Eingabefeld -->
                    <dl class="rex-form-group form-group">
                        <dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_h_csp_definition'); ?></label></dt>
                        <dd>                        
                            <input type="text" size="25" name="h_csp_definition" id="h_csp_definition" value="<?php echo @$config['h_csp_definition']; ?>" maxlength="250" class="form-control" placeholder="<?php echo aFM_noQuote($this->i18n('a1656_bas_h_csp_definition_example')); ?>" />
                        </dd>
                    </dl>
				</div>
                
                
                <div class="hiddencontent <?php echo (@$config['h_csp_noeditor'] != 'checked') ? 'checked' : ''; ?>" id="h_csp_option_editor">
                	<!-- CSP-Editorfelder -->
                    <dl class="rex-form-group form-group">
                        <dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_h_csp_editor'); ?></label></dt>
                        <dd>      
                                          
                            <!-- default-src -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_csp_default'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_default_https">
                                            <input name="h_csp_default_https" type="checkbox" id="h_csp_default_https" class="toggle" value="checked" <?php echo @$config['h_csp_default_https']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_https'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_default_data">
                                            <input name="h_csp_default_data" type="checkbox" id="h_csp_default_data" class="toggle" value="checked" <?php echo @$config['h_csp_default_data']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_data'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_default_blob">
                                            <input name="h_csp_default_blob" type="checkbox" id="h_csp_default_blob" class="toggle" value="checked" <?php echo @$config['h_csp_default_blob']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_blob'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_default_self">
                                            <input name="h_csp_default_self" type="checkbox" id="h_csp_default_self" class="toggle" value="checked" <?php echo @$config['h_csp_default_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_default_inline">
                                            <input name="h_csp_default_inline" type="checkbox" id="h_csp_default_inline" class="toggle" value="checked" <?php echo @$config['h_csp_default_inline']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_inline'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_default_eval">
                                            <input name="h_csp_default_eval" type="checkbox" id="h_csp_default_eval" class="toggle" value="checked" <?php echo @$config['h_csp_default_eval']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_eval'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_default_hashes">
                                            <input name="h_csp_default_hashes" type="checkbox" id="h_csp_default_hashes" class="toggle" value="checked" <?php echo @$config['h_csp_default_hashes']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_hashes'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_default_none">
                                            <input name="h_csp_default_none" type="checkbox" id="h_csp_default_none" class="toggle" value="checked" <?php echo @$config['h_csp_default_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                            
                            
                            <!-- img-src -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_csp_img'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_img_https">
                                            <input name="h_csp_img_https" type="checkbox" id="h_csp_img_https" class="toggle" value="checked" <?php echo @$config['h_csp_img_https']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_https'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_img_data">
                                            <input name="h_csp_img_data" type="checkbox" id="h_csp_img_data" class="toggle" value="checked" <?php echo @$config['h_csp_img_data']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_data'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_img_blob">
                                            <input name="h_csp_img_blob" type="checkbox" id="h_csp_img_blob" class="toggle" value="checked" <?php echo @$config['h_csp_img_blob']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_blob'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_img_self">
                                            <input name="h_csp_img_self" type="checkbox" id="h_csp_img_self" class="toggle" value="checked" <?php echo @$config['h_csp_img_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_img_inline">
                                            <input name="h_csp_img_inline" type="checkbox" id="h_csp_img_inline" class="toggle" value="checked" <?php echo @$config['h_csp_img_inline']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_inline'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_img_eval">
                                            <input name="h_csp_img_eval" type="checkbox" id="h_csp_img_eval" class="toggle" value="checked" <?php echo @$config['h_csp_img_eval']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_eval'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_img_hashes">
                                            <input name="h_csp_img_hashes" type="checkbox" id="h_csp_img_hashes" class="toggle" value="checked" <?php echo @$config['h_csp_img_hashes']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_hashes'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_img_none">
                                            <input name="h_csp_img_none" type="checkbox" id="h_csp_img_none" class="toggle" value="checked" <?php echo @$config['h_csp_img_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                            
                            
                            <!-- media-src -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_csp_media'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_media_https">
                                            <input name="h_csp_media_https" type="checkbox" id="h_csp_media_https" class="toggle" value="checked" <?php echo @$config['h_csp_media_https']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_https'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_media_data">
                                            <input name="h_csp_media_data" type="checkbox" id="h_csp_media_data" class="toggle" value="checked" <?php echo @$config['h_csp_media_data']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_data'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_media_blob">
                                            <input name="h_csp_media_blob" type="checkbox" id="h_csp_media_blob" class="toggle" value="checked" <?php echo @$config['h_csp_media_blob']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_blob'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_media_self">
                                            <input name="h_csp_media_self" type="checkbox" id="h_csp_media_self" class="toggle" value="checked" <?php echo @$config['h_csp_media_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_media_inline">
                                            <input name="h_csp_media_inline" type="checkbox" id="h_csp_media_inline" class="toggle" value="checked" <?php echo @$config['h_csp_media_inline']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_inline'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_media_eval">
                                            <input name="h_csp_media_eval" type="checkbox" id="h_csp_media_eval" class="toggle" value="checked" <?php echo @$config['h_csp_media_eval']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_eval'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_media_hashes">
                                            <input name="h_csp_media_hashes" type="checkbox" id="h_csp_media_hashes" class="toggle" value="checked" <?php echo @$config['h_csp_media_hashes']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_hashes'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_media_none">
                                            <input name="h_csp_media_none" type="checkbox" id="h_csp_media_none" class="toggle" value="checked" <?php echo @$config['h_csp_media_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                    
                            
                            <!-- font-src -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_csp_font'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_font_https">
                                            <input name="h_csp_font_https" type="checkbox" id="h_csp_font_https" class="toggle" value="checked" <?php echo @$config['h_csp_font_https']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_https'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_font_data">
                                            <input name="h_csp_font_data" type="checkbox" id="h_csp_font_data" class="toggle" value="checked" <?php echo @$config['h_csp_font_data']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_data'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_font_blob">
                                            <input name="h_csp_font_blob" type="checkbox" id="h_csp_font_blob" class="toggle" value="checked" <?php echo @$config['h_csp_font_blob']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_blob'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_font_self">
                                            <input name="h_csp_font_self" type="checkbox" id="h_csp_font_self" class="toggle" value="checked" <?php echo @$config['h_csp_font_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_font_inline">
                                            <input name="h_csp_font_inline" type="checkbox" id="h_csp_font_inline" class="toggle" value="checked" <?php echo @$config['h_csp_font_inline']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_inline'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_font_eval">
                                            <input name="h_csp_font_eval" type="checkbox" id="h_csp_font_eval" class="toggle" value="checked" <?php echo @$config['h_csp_font_eval']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_eval'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_font_hashes">
                                            <input name="h_csp_font_hashes" type="checkbox" id="h_csp_font_hashes" class="toggle" value="checked" <?php echo @$config['h_csp_font_hashes']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_hashes'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_font_none">
                                            <input name="h_csp_font_none" type="checkbox" id="h_csp_font_none" class="toggle" value="checked" <?php echo @$config['h_csp_font_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                    
                            
                            <!-- script-src -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_csp_script'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_script_https">
                                            <input name="h_csp_script_https" type="checkbox" id="h_csp_script_https" class="toggle" value="checked" <?php echo @$config['h_csp_script_https']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_https'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_script_data">
                                            <input name="h_csp_script_data" type="checkbox" id="h_csp_script_data" class="toggle" value="checked" <?php echo @$config['h_csp_script_data']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_data'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_script_blob">
                                            <input name="h_csp_script_blob" type="checkbox" id="h_csp_script_blob" class="toggle" value="checked" <?php echo @$config['h_csp_script_blob']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_blob'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_script_self">
                                            <input name="h_csp_script_self" type="checkbox" id="h_csp_script_self" class="toggle" value="checked" <?php echo @$config['h_csp_script_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_script_inline">
                                            <input name="h_csp_script_inline" type="checkbox" id="h_csp_script_inline" class="toggle" value="checked" <?php echo @$config['h_csp_script_inline']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_inline'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_script_eval">
                                            <input name="h_csp_script_eval" type="checkbox" id="h_csp_script_eval" class="toggle" value="checked" <?php echo @$config['h_csp_script_eval']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_eval'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_script_hashes">
                                            <input name="h_csp_script_hashes" type="checkbox" id="h_csp_script_hashes" class="toggle" value="checked" <?php echo @$config['h_csp_script_hashes']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_hashes'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_script_none">
                                            <input name="h_csp_script_none" type="checkbox" id="h_csp_script_none" class="toggle" value="checked" <?php echo @$config['h_csp_script_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                    
                            
                            <!-- style-src -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_csp_style'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_style_https">
                                            <input name="h_csp_style_https" type="checkbox" id="h_csp_style_https" class="toggle" value="checked" <?php echo @$config['h_csp_style_https']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_https'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_style_data">
                                            <input name="h_csp_style_data" type="checkbox" id="h_csp_style_data" class="toggle" value="checked" <?php echo @$config['h_csp_style_data']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_data'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_style_blob">
                                            <input name="h_csp_style_blob" type="checkbox" id="h_csp_style_blob" class="toggle" value="checked" <?php echo @$config['h_csp_style_blob']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_blob'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_style_self">
                                            <input name="h_csp_style_self" type="checkbox" id="h_csp_style_self" class="toggle" value="checked" <?php echo @$config['h_csp_style_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_style_inline">
                                            <input name="h_csp_style_inline" type="checkbox" id="h_csp_style_inline" class="toggle" value="checked" <?php echo @$config['h_csp_style_inline']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_inline'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_style_eval">
                                            <input name="h_csp_style_eval" type="checkbox" id="h_csp_style_eval" class="toggle" value="checked" <?php echo @$config['h_csp_style_eval']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_eval'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_style_hashes">
                                            <input name="h_csp_style_hashes" type="checkbox" id="h_csp_style_hashes" class="toggle" value="checked" <?php echo @$config['h_csp_style_hashes']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_hashes'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_style_none">
                                            <input name="h_csp_style_none" type="checkbox" id="h_csp_style_none" class="toggle" value="checked" <?php echo @$config['h_csp_style_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                    
                            
                            <!-- object-src -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_csp_object'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_object_https">
                                            <input name="h_csp_object_https" type="checkbox" id="h_csp_object_https" class="toggle" value="checked" <?php echo @$config['h_csp_object_https']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_https'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_object_data">
                                            <input name="h_csp_object_data" type="checkbox" id="h_csp_object_data" class="toggle" value="checked" <?php echo @$config['h_csp_object_data']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_data'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_object_blob">
                                            <input name="h_csp_object_blob" type="checkbox" id="h_csp_object_blob" class="toggle" value="checked" <?php echo @$config['h_csp_object_blob']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_blob'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_object_self">
                                            <input name="h_csp_object_self" type="checkbox" id="h_csp_object_self" class="toggle" value="checked" <?php echo @$config['h_csp_object_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_object_inline">
                                            <input name="h_csp_object_inline" type="checkbox" id="h_csp_object_inline" class="toggle" value="checked" <?php echo @$config['h_csp_object_inline']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_inline'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_object_eval">
                                            <input name="h_csp_object_eval" type="checkbox" id="h_csp_object_eval" class="toggle" value="checked" <?php echo @$config['h_csp_object_eval']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_eval'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_object_hashes">
                                            <input name="h_csp_object_hashes" type="checkbox" id="h_csp_object_hashes" class="toggle" value="checked" <?php echo @$config['h_csp_object_hashes']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_hashes'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_object_none">
                                            <input name="h_csp_object_none" type="checkbox" id="h_csp_object_none" class="toggle" value="checked" <?php echo @$config['h_csp_object_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                    
                            
                            <!-- form-action -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_csp_form'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_form_https">
                                            <input name="h_csp_form_https" type="checkbox" id="h_csp_form_https" class="toggle" value="checked" <?php echo @$config['h_csp_form_https']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_https'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_form_data">
                                            <input name="h_csp_form_data" type="checkbox" id="h_csp_form_data" class="toggle" value="checked" <?php echo @$config['h_csp_form_data']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_data'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_form_blob">
                                            <input name="h_csp_form_blob" type="checkbox" id="h_csp_form_blob" class="toggle" value="checked" <?php echo @$config['h_csp_form_blob']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_blob'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_form_self">
                                            <input name="h_csp_form_self" type="checkbox" id="h_csp_form_self" class="toggle" value="checked" <?php echo @$config['h_csp_form_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_form_inline">
                                            <input name="h_csp_form_inline" type="checkbox" id="h_csp_form_inline" class="toggle" value="checked" <?php echo @$config['h_csp_form_inline']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_inline'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_form_eval">
                                            <input name="h_csp_form_eval" type="checkbox" id="h_csp_form_eval" class="toggle" value="checked" <?php echo @$config['h_csp_form_eval']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_eval'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_form_hashes">
                                            <input name="h_csp_form_hashes" type="checkbox" id="h_csp_form_hashes" class="toggle" value="checked" <?php echo @$config['h_csp_form_hashes']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_hashes'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_form_none">
                                            <input name="h_csp_form_none" type="checkbox" id="h_csp_form_none" class="toggle" value="checked" <?php echo @$config['h_csp_form_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                    
                            
                            <!-- frame-src -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_csp_frame'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frame_https">
                                            <input name="h_csp_frame_https" type="checkbox" id="h_csp_frame_https" class="toggle" value="checked" <?php echo @$config['h_csp_frame_https']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_https'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frame_data">
                                            <input name="h_csp_frame_data" type="checkbox" id="h_csp_frame_data" class="toggle" value="checked" <?php echo @$config['h_csp_frame_data']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_data'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frame_blob">
                                            <input name="h_csp_frame_blob" type="checkbox" id="h_csp_frame_blob" class="toggle" value="checked" <?php echo @$config['h_csp_frame_blob']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_blob'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frame_self">
                                            <input name="h_csp_frame_self" type="checkbox" id="h_csp_frame_self" class="toggle" value="checked" <?php echo @$config['h_csp_frame_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frame_inline">
                                            <input name="h_csp_frame_inline" type="checkbox" id="h_csp_frame_inline" class="toggle" value="checked" <?php echo @$config['h_csp_frame_inline']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_inline'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frame_eval">
                                            <input name="h_csp_frame_eval" type="checkbox" id="h_csp_frame_eval" class="toggle" value="checked" <?php echo @$config['h_csp_frame_eval']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_eval'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frame_hashes">
                                            <input name="h_csp_frame_hashes" type="checkbox" id="h_csp_frame_hashes" class="toggle" value="checked" <?php echo @$config['h_csp_frame_hashes']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_hashes'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frame_none">
                                            <input name="h_csp_frame_none" type="checkbox" id="h_csp_frame_none" class="toggle" value="checked" <?php echo @$config['h_csp_frame_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                    
                            
                            <!-- frame-ancestors -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_csp_frameanc'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frameanc_https">
                                            <input name="h_csp_frameanc_https" type="checkbox" id="h_csp_frameanc_https" class="toggle" value="checked" <?php echo @$config['h_csp_frameanc_https']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_https'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frameanc_data">
                                            <input name="h_csp_frameanc_data" type="checkbox" id="h_csp_frameanc_data" class="toggle" value="checked" <?php echo @$config['h_csp_frameanc_data']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_data'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frameanc_blob">
                                            <input name="h_csp_frameanc_blob" type="checkbox" id="h_csp_frameanc_blob" class="toggle" value="checked" <?php echo @$config['h_csp_frameanc_blob']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_blob'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frameanc_self">
                                            <input name="h_csp_frameanc_self" type="checkbox" id="h_csp_frameanc_self" class="toggle" value="checked" <?php echo @$config['h_csp_frameanc_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_csp_frameanc_none">
                                            <input name="h_csp_frameanc_none" type="checkbox" id="h_csp_frameanc_none" class="toggle" value="checked" <?php echo @$config['h_csp_frameanc_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>                    
                    
                        </dd>
                    </dl>
				</div>
                </div>
                
                
                <div class="checkbox includebackend">
                    <label for="h_csp_be">
                        <input name="h_csp_be" type="checkbox" id="h_csp_be" class="toggle" value="checked" <?php echo @$config['h_csp_be']; ?> /> <?php echo $this->i18n('a1656_bas_includebackend'); ?>
                    </label>
                </div> 
            </div>
            

			
            <!-- Feature-Policy / Permissions-Policy -->
            <div class="boxed-group">
                <dl class="rex-form-group form-group">
                    <dt><label for=""><?php echo $this->i18n('a1656_bas_h_fpp'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_fpp">
                            <input name="h_fpp" type="checkbox" id="h_fpp" class="toggle" value="checked" <?php echo @$config['h_fpp']; ?> data-opener="#h_fpp_option" /> <?php echo $this->i18n('a1656_bas_active'); ?>
                        </label>
                        </div>
                    </dd>
                </dl>
 
 				<div class="hiddencontent <?php echo @$config['h_fpp']; ?>" id="h_fpp_option">
                <dl class="rex-form-group form-group">
                    <dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_h_fpp_noeditor'); ?></label></dt>
                    <dd>
                        <div class="checkbox">
                        <label for="h_fpp_noeditor">
                            <input name="h_fpp_noeditor" type="checkbox" id="h_fpp_noeditor" class="toggle" value="checked" <?php echo @$config['h_fpp_noeditor']; ?> /> <?php echo $this->i18n('a1656_yes'); ?>
                        </label>
                        </div>
                    </dd>
                </dl>
                
                
                <dl class="rex-form-group form-group"><dt>&nbsp;</dt></dl>
                
                
                <div class="hiddencontent <?php echo @$config['h_fpp_noeditor']; ?>" id="h_fpp_option_noeditor">
                	<!-- Feature-Policy-Eingabefeld -->
                    <dl class="rex-form-group form-group">
                        <dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_h_fpp_definition_f'); ?></label></dt>
                        <dd>                        
                            <input type="text" size="25" name="h_fpp_definition_f" id="h_fpp_definition_f" value="<?php echo @$config['h_fpp_definition_f']; ?>" maxlength="250" class="form-control" placeholder="<?php echo aFM_noQuote($this->i18n('a1656_bas_h_fpp_definition_f_example')); ?>" />
                        </dd>
                    </dl>
                    
                	<!-- Permissions-Policy-Eingabefeld -->
                    <dl class="rex-form-group form-group">
                        <dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_h_fpp_definition_p'); ?></label></dt>
                        <dd>                        
                            <input type="text" size="25" name="h_fpp_definition_p" id="h_fpp_definition_p" value="<?php echo @$config['h_fpp_definition_p']; ?>" maxlength="250" class="form-control" placeholder="<?php echo aFM_noQuote($this->i18n('a1656_bas_h_fpp_definition_p_example')); ?>" />
                        </dd>
                    </dl>
				</div>
                
                
                <div class="hiddencontent <?php echo (@$config['h_fpp_noeditor'] != 'checked') ? 'checked' : ''; ?>" id="h_fpp_option_editor">
                	<!-- FPP-Editorfelder -->
                    <dl class="rex-form-group form-group">
                        <dt><label for="" class="nobold"><?php echo $this->i18n('a1656_bas_h_fpp_editor'); ?></label></dt>
                        <dd>      
                                          
                            <!-- camera -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_fpp_camera'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_cam_self">
                                            <input name="h_fpp_cam_self" type="checkbox" id="h_fpp_cam_self" class="toggle" value="checked" <?php echo @$config['h_fpp_cam_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_cam_none">
                                            <input name="h_fpp_cam_none" type="checkbox" id="h_fpp_cam_none" class="toggle" value="checked" <?php echo @$config['h_fpp_cam_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                            
                                          
                            <!-- gelocation -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_fpp_geolocation'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_geo_self">
                                            <input name="h_fpp_geo_self" type="checkbox" id="h_fpp_geo_self" class="toggle" value="checked" <?php echo @$config['h_fpp_geo_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_geo_none">
                                            <input name="h_fpp_geo_none" type="checkbox" id="h_fpp_geo_none" class="toggle" value="checked" <?php echo @$config['h_fpp_geo_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                            
                                          
                            <!-- gyroscope -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_fpp_gyro'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_gyro_self">
                                            <input name="h_fpp_gyro_self" type="checkbox" id="h_fpp_gyro_self" class="toggle" value="checked" <?php echo @$config['h_fpp_gyro_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_gyro_none">
                                            <input name="h_fpp_gyro_none" type="checkbox" id="h_fpp_gyro_none" class="toggle" value="checked" <?php echo @$config['h_fpp_gyro_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                            
                                          
                            <!-- magnetometer -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_fpp_magnet'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_mag_self">
                                            <input name="h_fpp_mag_self" type="checkbox" id="h_fpp_mag_self" class="toggle" value="checked" <?php echo @$config['h_fpp_mag_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_mag_none">
                                            <input name="h_fpp_mag_none" type="checkbox" id="h_fpp_mag_none" class="toggle" value="checked" <?php echo @$config['h_fpp_mag_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                            
                                          
                            <!-- microphone -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_fpp_micro'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_mic_self">
                                            <input name="h_fpp_mic_self" type="checkbox" id="h_fpp_mic_self" class="toggle" value="checked" <?php echo @$config['h_fpp_mic_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_mic_none">
                                            <input name="h_fpp_mic_none" type="checkbox" id="h_fpp_mic_none" class="toggle" value="checked" <?php echo @$config['h_fpp_mic_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                            
                                          
                            <!-- usb -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_fpp_usb'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_usb_self">
                                            <input name="h_fpp_usb_self" type="checkbox" id="h_fpp_usb_self" class="toggle" value="checked" <?php echo @$config['h_fpp_usb_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_usb_none">
                                            <input name="h_fpp_usb_none" type="checkbox" id="h_fpp_usb_none" class="toggle" value="checked" <?php echo @$config['h_fpp_usb_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                            
                                          
                            <!-- document-domain -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_fpp_docdomain'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_docdom_self">
                                            <input name="h_fpp_docdom_self" type="checkbox" id="h_fpp_docdom_self" class="toggle" value="checked" <?php echo @$config['h_fpp_docdom_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_docdom_none">
                                            <input name="h_fpp_docdom_none" type="checkbox" id="h_fpp_docdom_none" class="toggle" value="checked" <?php echo @$config['h_fpp_docdom_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                            
                                          
                            <!-- fullscreen -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_fpp_fullscreen'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_full_self">
                                            <input name="h_fpp_full_self" type="checkbox" id="h_fpp_full_self" class="toggle" value="checked" <?php echo @$config['h_fpp_full_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_full_none">
                                            <input name="h_fpp_full_none" type="checkbox" id="h_fpp_full_none" class="toggle" value="checked" <?php echo @$config['h_fpp_full_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
                            
                                          
                            <!-- payment -->
                            <div class="cspblock">
                                <label for=""><?php echo $this->i18n('a1656_bas_h_fpp_payment'); ?></label>
                            
                                <ul>
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_pay_self">
                                            <input name="h_fpp_pay_self" type="checkbox" id="h_fpp_pay_self" class="toggle" value="checked" <?php echo @$config['h_fpp_pay_self']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_self'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                    <li>
                                        <div class="checkbox">
                                        <label for="h_fpp_pay_none">
                                            <input name="h_fpp_pay_none" type="checkbox" id="h_fpp_pay_none" class="toggle" value="checked" <?php echo @$config['h_fpp_pay_none']; ?> /> <?php echo $this->i18n('a1656_bas_h_editor_none'); ?>
                                        </label>
                                        </div>
                                    </li> 
                                </ul>
                            </div>
              
                    
                        </dd>
                    </dl>
				</div>
                </div>
                
                
                <div class="checkbox includebackend">
                    <label for="h_fpp_be">
                        <input name="h_fpp_be" type="checkbox" id="h_fpp_be" class="toggle" value="checked" <?php echo @$config['h_fpp_be']; ?> /> <?php echo $this->i18n('a1656_bas_includebackend'); ?>
                    </label>
                </div> 
            </div>            
            
            
            
            
        </div>
        
        
		<script type="text/javascript">
		$('.hiddencontent').not('.checked').hide();
		
		$('input[data-opener]').change(function(){
			dst = $(this).attr('data-opener');
			
			if (dst != undefined && dst.length > 2) {
				if ($(this).is(':checked')) {
					$(dst).slideDown();
				} else {
					$(dst).slideUp();
				}
			}
		});
		
		$('#h_csp_noeditor').change(function(){
			if ($(this).is(':checked')) {
				$('#h_csp_option_noeditor').slideDown();
				$('#h_csp_option_editor').slideUp();
			} else {
				$('#h_csp_option_noeditor').slideUp();
				$('#h_csp_option_editor').slideDown();
			}
		});
		
		$('#h_fpp_noeditor').change(function(){
			if ($(this).is(':checked')) {
				$('#h_fpp_option_noeditor').slideDown();
				$('#h_fpp_option_editor').slideUp();
			} else {
				$('#h_fpp_option_noeditor').slideUp();
				$('#h_fpp_option_editor').slideDown();
			}
		});
        </script>
        
        
        <footer class="panel-footer">
        	<div class="rex-form-panel-footer">
            	<div class="btn-toolbar">
                	<input class="btn btn-save rex-form-aligned" type="submit" name="submit" title="<?php echo $this->i18n('a1656_save'); ?>" value="<?php echo $this->i18n('a1656_save'); ?>" />
                </div>
			</div>
		</footer>
        
	</div>
</section>

</form>