<?php
/*
    Redaxo-Addon HTTP-Header
    Verwaltung: index
    v1.0
    by Falko Müller @ 2021
    package: redaxo5
*/

// Variablen deklarieren
$mypage = $this->getProperty('package');

$page = rex_request('page', 'string');
$subpage = rex_be_controller::getCurrentPagePart(2);						// Subpages werden aus page-Pfad ausgelesen (getrennt mit einem Slash, z.B. page=demo_addon/subpage -> 2 = zweiter Teil)
$tmp = rex_request('subpage', 'string');
$subpage = (!empty($tmp)) ? $tmp : $subpage;
$func = rex_request('func', 'string');

// Userrechte prüfen
// $isAdmin = ( is_object($REX['USER']) AND ($REX['USER']->hasPerm($mypage.'[admin]') OR $REX['USER']->isAdmin()) ) ? true : false;

// Seitentitel ausgeben
echo rex_view::title($this->i18n('a1656_title') . '<span class="addonversion">' . $this->getProperty('version') . '</span>');

// Unterseite einbinden
switch ($subpage):
    case 'help':				// Hilfe
                                require_once 'help.inc.php';
                                break;

    default:					// Index = Einstellungen
                                require_once 'default.inc.php';
                                break;
endswitch;
?>


<!-- PLEASE DO NOT REMOVE THIS COPYRIGHT -->
<p><?= $this->getProperty('author') ?></p>
<!-- THANK YOU! -->
