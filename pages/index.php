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