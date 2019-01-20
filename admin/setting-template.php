<?php
/**
 * includes/setting-template.php
 *
 * @package kirchenjahr-evangelisch
 * @version 2019.3
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
  Ergibt: https://www.bibleserver.com/text/<strong style="color:blue">LUT</strong>/<strong style="color:blue">1.Mose1</strong>
  </p>
  <h3>Beispiel 2: die-bibel.de</h3>
  <ol>
  <li>URL = https://www.die-bibel.de/bibeln/online-bibeln/<strong style="color:blue">%s</strong>/bibeltext/bibel/text/lesen/?tx_bibelmodul_bibletext[scripture]=<strong style="color:blue">%s</strong></li>
  <li>Translation = lutherbibel-2017</li>
  <li>Vers = 1. Mose 1</li>
  </ol>
  <p>
  Ergibt: https://www.die-bibel.de/bibeln/online-bibeln/<strong style="color:blue">lutherbibel-2017</strong>/bibeltext/bibel/text/lesen/?tx_bibelmodul_bibletext[scripture]=<strong style="color:blue">1.Mose1</strong>
  </p>
  
  <form method="post" action="options.php">
    <?php @settings_fields('evkj_group'); ?>
    <?php @do_settings_fields('evkj_group'); ?>
    <?php do_settings_sections('evkj_kirchenjahr'); ?>
    <?php @submit_button(); ?>
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
