<?php
/**
 * includes/setting-template.php
 *
 * @package kirchenjahr-evangelisch
 * @version 2023.1
 * @copyright 2019 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author Thomas Arend <thomas@arend-rhb.de>
 */
 
//Security check!

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

?>

<!-- EVKJ Kirchenjahr evangelisch Settings -->

  <h1>Kirchenjahr evangelisch</h1>
  <h2>Beschreibung</h2>
  <p>
  Hier k&ouml;nnen die vorgegebenen Werte des Plugins "Kirchenjahr evangelisch" angepasst werden.
  </p>
  <p>
  Die Links zu den Bibelstellen werden aus der URL , der Translation und dem Vers gebildet. Dazu werden in der URL die <strong style="color:blue">%s</strong> durch Translation und Vers ersetzt. 
  </p>

  <h3>Beispiel 1: bibelserver.com</h3> www.die-bibel.de
  <ol>
  <li>URL = https://www.bibleserver.com/text/<strong style="color:blue">%s</strong>/<strong style="color:blue">%s</strong></li>
  <li>Translation = LUT</li>
  <li>Vers = 1. Mose 1</li>
  </ol>
  <p>
  Ergibt: https://www.bibleserver.com/text/<strong style="color:blue">LUT</strong>/<strong style="color:blue">1.%20Mose%201</strong>
  </p>
  <h3>Beispiel 2: die-bibel.de</h3>
  <ol>
  <li>URL = https://www.die-bibel.de/bibeln/online-bibeln/<strong style="color:blue">%s</strong>/bibeltext/<strong style="color:blue">%s</strong><strong style="color:blue">%s/</strong></li>
  <li>Translation = lutherbibel-2017</li>
  <li>Vers = 1. Mose 1</li>
  </ol>
  <p>
  Ergibt: https://www.die-bibel.de/bibeln/online-bibeln/<strong style="color:blue">lutherbibel-2017</strong>/bibeltext/<strong style="color:blue">1.%20Mose%201</strong>/
  </p>
  <p>
  <strong>Achtung:</strong> Der Beispiellink unter <a href="https://www.die-bibel.de/bibeln/online-bibeln/bibeltext-verlinken/" target="_blank">Die Bibel</a> funktioniert leider nicht, da die Übersetzung vor dem Vers in der URL stehen muss. Die Abkürzungen für die Übersetzung funktionieren an der Stelle auch nicht; hier ist die Langversion erforderlich.
  </p>
 
  <form method="post" action="options.php">
    <?php settings_fields('evkj_group'); ?>
    <?php do_settings_sections('evkj_kirchenjahr'); ?>
    <?php submit_button(); ?>
  </form>

  <h2>Parameter des Shortcodes [litkalender]</h2>

  <p>Folgende Parameter werden unterstützt:
	<ol>
	<li>size</li>
	<li>date</li>
	<li>current</li>
	<li>fields</li>
	</ol>
  </p>
