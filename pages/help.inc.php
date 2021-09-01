<?php
/*
	Redaxo-Addon HTTP-Header
	Verwaltung: Hilfe
	v1.0
	by Falko Müller @ 2021
	package: redaxo5
*/
?>

<style>
.faq { margin: 0px !important; cursor: pointer; }
.faq + div { margin: 0px 0px 15px; }
</style>

<section class="rex-page-section">
	<div class="panel panel-default">

		<header class="panel-heading"><div class="panel-title"><?php echo $this->i18n('a1656_head_help'); ?></div></header>
        
		<div class="panel-body">
			<div class="rex-docs">
				<div class="rex-docs-sidebar">
                	<nav class="rex-nav-toc">
                    	<ul>
                        	<li><a href="#default">Wichtige Information</a>
                            <li><a href="#header">Header</a>
                            <li><a href="#autor">Autor</a>
                      </ul>
                    </nav>
        	    </div>
                
				<div class="rex-docs-content">
                
					<h1>Addon: <?php echo $this->i18n('a1656_title'); ?></h1>

					<p>Mit dieser Erweiterung können verschiedene Webseiten-Header zur Einstellung von Sicherheitsmaßnahmen und Optimierungen aktiviert werden.
				  </p>
<p>&nbsp;</p>
                  <h2>Wichtige Information</h2>
              
              
                    
                    <!-- Allgemein (Artikel-Checkup) -->
                    <a name="default"></a>
                                  <p><strong>Prüfen Sie immer den jeweils gesetzten Header, da es u.U. passieren kann, dass die Webseite anschließend nicht mehr wie gewünscht funktioniert.</strong></p>
                  <p>Des weiteren werden nicht alle Header von allen Browsern berücksichtigt. Auch unterstützen nicht alle Webserver alle Header bzw. können die Aktivierung auch verhindern.</p>
                  <p>Prüfen Sie nach der Aktivierung der Header Ihre Webseite und die korrekte Funktion der Header.<br>
                  Nützliche Prüftools sind u.a.:</p>
                  <ul>
                    <li><a href="https://gf.dev/http-headers-test" target="_blank">https://gf.dev/http-headers-test</a></li>
                    <li><a href="https://securityheaders.com" target="_blank">https://securityheaders.com</a></li>
                    <li><a href="https://observatory.mozilla.org" target="_blank">https://observatory.mozilla.org</a></li>
                    <li><a href="https://siwecos.de" target="_blank">https://siwecos.de</a></li>
                    <li><a href="https://csp-evaluator.withgoogle.com" target="_blank">https://csp-evaluator.withgoogle.com</a></li>
                  </ul>
<p>&nbsp;</p>
              
              
                    
                    <!-- Header -->
                    <a name="urlcheckup"></a>
                  <h2>Einstellungen</h2>
                  
                  <p>Jeder Header kann separat aktiviert werden und bedarf u.U. noch weiterer Optionen.</p>
                  <p> Die Aktivierung des jeweiligen Header erfolgt immer für das Frontend - Ihre Webseite. <br>
                    Sofern der jeweilige Header auch für das Backend (Redaxo) aktiviert werden soll, so setzen Sie die Option &quot;Inklusive Backend&quot; auf aktiv.
                  </p>
                  <p>&nbsp;</p>

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th scope="col">Header</th>
                        <th scope="col">Erklärung</th>
                    </tr>
                      <tr>
                        <td valign="top"><strong>Connection keep-alive</strong></td>
                        <td valign="top">Die Verbindung soll nicht nach jeder Anfrage beendet werden, um die Ladegeschwindigkeit zu erhöhen.</td>
                      </tr>
                      <tr>
                        <td valign="top"><strong>Vary Accept-Encoding</strong></td>
                        <td valign="top">Der Client soll erfahren können, welche Komprimierung die Website verwendet.</td>
                      </tr>
                      <tr>
                        <td valign="top"><strong>Serverkennung</strong></td>
                        <td valign="top">Über diesen Header kann je nach Servereinstellung die Ausgabe des Servertyps unterdrückt werden.</td>
                      </tr>
                      <tr>
                        <td valign="top"><strong>X-Powered-By</strong></td>
                        <td valign="top">Über diesen Header kann je nach Servereinstellung die Ausgabe der PHP-Version unterdrückt werden.</td>
                      </tr>
                      <tr>
                        <td valign="top"><strong>X-Content-Type-Options</strong></td>
                        <td valign="top">Mit diesem Header können Browser angewiesen werden, aufgerufene Dateien nicht als etwas anderes zu interpretiern als vom Inhaltstyp definiert.</td>
                      </tr>
                      <tr>
                        <td valign="top"><strong>X-Frame-Options</strong></td>
                        <td valign="top">Das Setzen von X-Frame-Options hilft dabei, Angriffe über Framing-Mechanismen zu unterbinden.</td>
                      </tr>
                        <tr>
                          <td valign="top"><strong>X-XSS-Protection</strong></td>
                          <td valign="top">Der X-XSS-Header definiert, wie in Browsern eingebaute XSS-Filter konfiguriert werden.</td>
                        </tr>
                        <tr>
                          <td valign="top"><strong>Referrer-Policy</strong></td>
                          <td valign="top">Mit der Referrer Policy wird geregelt, welche der Referrer-Informationen in Anfragen aufgenommen werden sollen und welche nicht.</td>
                        </tr>
                        <tr>
                          <td width="200" valign="top"><strong>Strict-Transport-Security</strong></td>
                          <td valign="top">Strict-Transport-Security stellt sicher, dass die Webseite für die deefinierte Zeit lediglich über HTTPS aufgerufen werden kann.<br>
                          <br>
                          Die Angabe &quot;max-age&quot; ist dabei für eine korrekte Funktion Pflicht.</td>
                        </tr>
                        <tr>
                          <td valign="top"><strong>Content-Security-Policy</strong></td>
                          <td valign="top">Die Content-Security-Policy definiert, aus welchen Quellen verschiedene Anfragen/Ressourcen, welche das Injizieren und Ausführen von evtl. bösartigen Befehlen, eingebunden werden dürfen.<br>
                          <br>
                          Die default-Angabe sollte dabei immer gesetzt werden. Alle weiteren Angaben ändern die default-Angabe entsprechend ab.</td>
                        </tr>
                        <tr>
                          <td valign="top"><strong>Featuer-/Permissions-Policy</strong></td>
                          <td valign="top">Mit der Permissions-Policy (früher Feature-Policy) kann dem Webbrowser mitgeteilt werden,   auf welche Browser- bzw. Systemfeatures zugegriffen werden kann.<br>
                            <br>
                          Werden keine Features/Permissions definiert, so ist der Zugriff auf entsprechende Features immer möglich.</td>
                        </tr>
                  </table>
                  </table>


				  <p>Weitere Information zu den Headern finden Sie hier:</p>
				  <ul>
				    <li><a href="https://siwecos.de/wiki/Kategorie:Glossar" target="_blank">https://siwecos.de/wiki/Kategorie:Glossar</a></li>
				    <li><a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers</a></li>
                    <li><a href="https://wiki.selfhtml.org/wiki/Sicherheit" target="_blank">https://wiki.selfhtml.org/wiki/Sicherheit</a></li>
			      </ul>
              
              
                    
                    <!-- Autor -->
                    <a name="autor"></a>
                  <h2>Autoren / Projekt-Leads</h2>
                  
                  <p><strong>Friends Of REDAXO</strong></p>
                  
                  <p><a href="https://github.com/iceman-fx" target="_blank">Falko Müller</a><br><a href="https://getaweb.de">
                  getaweb / Oliver Kreischer</a></p>

                  
<p>&nbsp;</p>
                    
                    <h3>Fragen, Wünsche, Probleme?</h3>
                    Du hast einen Fehler gefunden oder ein nettes Feature parat?<br>
				Lege ein Issue unter <a href="<?php echo $this->getProperty('supportpage'); ?>" target="_blank"><?php echo $this->getProperty('supportpage'); ?></a> an. </div>
            </div>

	  </div>
	</div>
</section>