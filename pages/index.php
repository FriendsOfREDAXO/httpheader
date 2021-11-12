<?php
/*
	Redaxo-Addon HTTP-Header
	Verwaltung: index
	v1.0
	by Falko Müller @ 2021
	package: redaxo5
*/

//Variablen deklarieren
$mypage = $this->getProperty('package');

$page = rex_request('page', 'string');
$subpage = rex_be_controller::getCurrentPagePart(2);						//Subpages werden aus page-Pfad ausgelesen (getrennt mit einem Slash, z.B. page=demo_addon/subpage -> 2 = zweiter Teil)
	$tmp = rex_request('subpage', 'string');
	$subpage = (!empty($tmp)) ? $tmp : $subpage;
$subpage2 = rex_be_controller::getCurrentPagePart(3);						//2. Unterebene = dritter Teil des page-Parameters
	$subpage2 = preg_replace("/.*-([0-9])$/i", "$1", $subpage2);			//Auslesen der ClangID
$func = rex_request('func', 'string');

	
//Userrechte prüfen
//$isAdmin = ( is_object($REX['USER']) AND ($REX['USER']->hasPerm($mypage.'[admin]') OR $REX['USER']->isAdmin()) ) ? true : false;


//Seitentitel ausgeben
echo rex_view::title($this->i18n('a1656_title').'<span class="addonversion">'.$this->getProperty('version').'</span>');


//globales Inline-CSS + Javascript
?>
<style type="text/css">
input.rex-form-submit { margin-left: 190px !important; }	/* Rex-Button auf neue (Labelbreite +10) verschieben */
td.name { position: relative; padding-right: 20px !important; }
.nowidth { width: auto !important; }
.togglebox { display: none; margin-top: 8px; font-size: 90%; color: #666; line-height: 130%; }
.toggler { width: 15px; height: 12px; position: absolute; top: 10px; right: 3px; }
.toggler a { display: block; height: 11px; background-image: url(../assets/addons/<?php echo $mypage; ?>/arrows.png); background-repeat: no-repeat; background-position: center -6px; cursor: pointer; }
.required { font-weight: bold; }
.inlinelabel { display: inline !important; width: auto !important; float: none !important; clear: none !important; padding: 0px  !important; margin: 0px !important; font-weight: normal !important; }
.inlineform { display: inline-block !important; }
.form_auto { width: auto !important; }
.form_plz { width: 25%px !important; margin-right: 6px; }
.form_ort { width: 73%px !important; }
.form_25perc { width: 25% !important; min-width: 120px; }
.form_50perc { width: 50% !important; min-width: 120px; }
.form_75perc { width: 75% !important; }
.form_content { display: block; padding-top: 5px; }
.form_readonly { background-color: #EEE; color: #999; }
.form_isoffline { color: #A00; }
.addonversion { margin-left: 7px; }
.radio label, .checkbox label { margin-right: 20px; }

.form_column, .datepicker-widget { display: inline-block; vertical-align: middle; }
	.form_column-spacer, .datepicker-widget-spacer { padding: 0px 5px; }

.form_2spaltig > div { display: inline-block; width: 49%; }

.addon_failed, .addonfailed { color: #F00; font-weight: bold; margin-bottom: 15px; }
		
.addon_inlinegroup { display: inline-block; }
.addon_input-group { display: table; }
	.addon_input-group > * { display: table-cell; border-radius: 0px; border: 1px solid #7586a0; margin-left: -1px; }
	.addon_input-group > *:first-child { margin: 0px; }
	.addon_input-group > *:last-child { border-radius: 0px 2px 2px 0px; }
	
.addon_input-group-field {}
.addon_input-group-btn {}

.block { display: block; }
.info { font-size: 0.825em; }
.info-labels { display: inline-block; padding: 3px 6px; background: #EAEAEA; margin-right: 5px; font-size: 0.80em; }
	.info-green { background: #360; color: #FFF; }
	.info-red { background: #900; color: #FFF; }
.infoblock { display: block; font-size: 0.825em; margin-top: 7px; }

/* Boxen */
.boxed-group { position: relative; background: rgba(255,255,255, 0.6); margin: 0px 0px 15px; padding: 15px 20px; border: #CCC; }
.boxed-group dl.form-group { margin-bottom: 0px; margin-top: 15px; }
	.boxed-group dl.form-group:first-child { margin-top: 0px; }
	.boxed-group .hiddencontent > dl:first-child { margin-top: 15px; }
.boxed-group label.nobold { font-weight: normal; }
a.modallink { cursor: pointer; }

.cspblock { display: inline-block; vertical-align: top; min-width: 182px; margin: 0px 23px 18px 0px; padding: 7px 14px; transition: all .3s ease; }
	.cspblock:hover { background: #FFF; }
.cspblock label { margin-right: 0px !important; }
.cspblock ul { list-style: none; margin: 0px; padding: 0px;}
.cspblock li { margin: 0px 0px 5px; }

/* Header-Farben */
.hh-risk { border-left: 3px solid orange; }
.hh-highrisk { border-left: 3px solid #D9534F; }

/* Checkbox/Radio-Toggler */
.checkbox.toggle label input, .radio.toggle label input { -webkit-appearance: none; -moz-appearance: none; appearance: none; width: 3em; height: 1.5em; background: #ddd; vertical-align: middle; border-radius: 1.6em; position: relative; outline: 0; margin-top: -3px; margin-right: 10px; cursor: pointer; transition: background 0.1s ease-in-out; }
	.checkbox.toggle label input::after, .radio.toggle label input::after, .radio.switch label input::before { content: ''; width: 1.5em; height: 1.5em; background: white; position: absolute; border-radius: 1.2em; transform: scale(0.7); left: 0; box-shadow: 0 1px rgba(0, 0, 0, 0.5); transition: left 0.1s ease-in-out; }
.checkbox.toggle label input:checked, .radio.toggle label input:checked { background: #5791CE; }
	.checkbox.toggle label input:checked::after { left: 1.5em; }

.radio.switch label { margin-right: 1.5em; }
.radio.switch label input { width: 1.5em; margin-right: 5px; }
	.radio.switch label input:checked::after { transform: scale(0.5); }
.radio.switch label input::before { background: #5791CE; opacity: 0; box-shadow: none; }
	.radio.switch label input:checked::before { animation: radioswitcheffect 0.65s; }
@keyframes radioswitcheffect { 0% { opacity: 0.75; } 100% { opacity: 0; transform: scale(2.5); } }

/* Checkbox-Toggler small */
.includebackend { text-align: right; zoom: 0.75; margin: 0px; position: absolute; top: 13px; right: 13px; }
.includebackend label { margin-right: 0px !important; }
.includebackend label input[type=checkbox].toggle { margin-right: 8px; }

/* Modalfenster */
.hh-modal { background: rgba(40,53,66, 0.4); }
.hh-modal .modal-header { background: #dfe3e9; line-height: 1.25; padding: 10px 15px; font-size: 16px; }
.hh-modal .modal-title { display: inline; }
.hh-content { display: none; }


@media (min-width: 768px){
	.hh-modal-large .modal-dialog { width: 90%; max-width: 800px;}
}


<?php if (rex_string::versionCompare(rex::getVersion(), '5.13.0-dev', '>=')): ?>
@media (prefers-color-scheme: dark){
	
	body:not(.rex-theme-light) .cspblock:hover { background: #1f3d3c; }
	body:not(.rex-theme-light) .boxed-group { background: rgba(54,81,80, 0.45); }
	body:not(.rex-theme-light) .hh-modal .modal-header { background: inherit; }


	body:not(.rex-theme-light) .checkbox.toggle label input,
	body:not(.rex-theme-light) .radio.toggle label input
		{ background: #202b35; }
	body:not(.rex-theme-light) .checkbox.toggle label input::after, 
	body:not(.rex-theme-light) .radio.toggle label input::after, 
	body:not(.rex-theme-light) .radio.switch label input::before
		{ background: #CCC; }
	
	body:not(.rex-theme-light) .checkbox.toggle label input:checked,
	body:not(.rex-theme-light) .radio.toggle label input:checked 
		{ background: #409be4; }
	body:not(.rex-theme-light) .checkbox.toggle label input:checked::after, 
	body:not(.rex-theme-light) .radio.toggle label input:checked::after, 
	body:not(.rex-theme-light) .radio.switch label input:checked::before
		{ background: #EEE; }
}
<?php endif; ?>
</style>


<script type="text/javascript">
setTimeout(function() { jQuery('.alert-info').fadeOut(); }, 5000);			//Rückmeldung ausblenden
</script>


<?php
//Unterseite einbinden
switch($subpage):
	case "help":				//Hilfe
								require_once("help.inc.php");
								break;				

	default:					//Index = Einstellungen
								require_once("default.inc.php");
								break;
endswitch;
?>


<!-- PLEASE DO NOT REMOVE THIS COPYRIGHT -->
<p><?php echo $this->getProperty('author'); ?></p>
<!-- THANK YOU! -->