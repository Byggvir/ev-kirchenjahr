<?php
/**
 * public/class_litcalapi.php
 *
 * @package           WP Losungen SQL
 * @link              http://byggvir.de
 * @since             2019.0.1
 * @version 2019.0.1
 * @copyright 2019 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @plugin-wordpress
 *
 */

/**
 * Security check: Exit if script is called directly
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Define class
 *
 * @class Evkj_WidgetAPI
 *
 */
class Evkj_WidgetAPI {

	/**
	 * Schnittstelle zum Widget Liturgischer Kalender
	 *
	 * @param text    $text
	 * @return formtierter text
	 */

	/** constructor */
	function __construct() {

	} 

private function get_withoutcurl ( $url ) 
{

  $page='';
  $fd = fopen($url,"r");
  $returned = "";
  if ($fd) 
  {
    while(!feof($fd))
    {
      $line = fgets($fd,4096);
      $returned .= $line;
    }
    fclose($fd);
  } 
  else
  {
    $returned = "<p class=\"evkj-warning\">Der Liturgische Kalender ist nicht erreichbar!</p>";;
  }
  return $returned;
}

private function get_withcurl ( $url, $agent = 'Ev. Kirchenjahr Plugin 2019.0.0 / Thomas Arend / https://byggvir.de')
{
  // use curl
  $sobl = curl_init($url);

  curl_setopt($sobl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($sobl, CURLOPT_USERAGENT, $agent);
  curl_setopt($sobl, CURLOPT_REFERER, $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
  # timeout max 2 Sek.
  curl_setopt($sobl, CURLOPT_CONNECTTIMEOUT, 5);
  
  $pageContent = curl_exec ($sobl);
  
  $sobl_info = curl_getinfo ($sobl);
	
  if($sobl_info['http_code'] == '200')
  {
    $returned = $pageContent;
	
  } 
  else 
  {
    # Fehlermeldung:
    $returned = "<p class=\"evkj-warning\">Der Liturgische Kalender ist nicht erreichbar!</p>";
  }
  return $returned;

} 

private function removeHeadBody ( $content) {

		/**
		 * Überflüssiges HTML entfernen!
		 */
        
		/**
		 * Zeilenumbrüche entfernen!
		 */
        
        $despojado = preg_replace( "#\r|\n#", " ", $content );
        
        /**
         * Nur den Teil zwischen <body .. > und </body> behalten
         */
		$despojado = preg_replace('#^<.*<body[^>]*>#', '', $despojado);
		$despojado = preg_replace('#</body>.*#', '', $despojado);
		
		/**
		 * Neue Zeilenumbrüche einfügen
		 */
		$despojado = preg_replace('#<#', "\n<", $despojado);
        
        /**
		 * Feldnamen formatierbar machen
		 */
		$despojado = preg_replace( "#(<br />|<p>)[\t ]*(.*:)#", "$1<span class=\"evkj-fieldname\">$2</span>", $despojado);
        
		return $despojado ;
		
}

/**
Parametername | 	Werte
------------- | -------------
size |	'small' oder 'big'. Gibt die gewünschte Variante des Widgets an. 'small' steht für Variante 1, 'big' für Variante 2. Standard: 'small'
css  |	Vollständige URL zu einer CSS-Datei. Ermöglicht die individuelle Gestaltung des Widgets mittels einer eigenen CSS-Datei. Standard: (leer)
fields |	Eine kommaseparierte Liste von Werten aus folgender Tabelle. Ermöglicht die Auswahl der anzuzeigenden liturgischen Felder für Variante 2 des Widgets. Standard: 0,1,2,3,4,5
date |	Format: 'YYYY-mm-dd' (z.B. 2016-12-31). Hiermit gibt das Widget Daten für ein bestimmtes Datum aus. Standard: aktueller Tag.
current |	'true'. Falls gesetzt, gibt das Widget Daten für die laufende Woche aus. Standard: (leer)

### Auswahl liturgischer Felder (fields):

Wert |Feld
-----|----
0 |	Wochenspruch (als Bibelstelle)
1 |	Wochenpsalm
2 |	Eingangspsalm
3 |	AT-Lesung
4 |	Epistel
5 |	Predigttext
6 |	Evangelium
7 |	Wochenlied
8 |	liturgische Farbe als Text
9 |	Wochenspruch (als Text)

*/

public function litdayinfo (

	$size = 'big',
	$fields = '0,1,2,3,4,5,6,7,8,9',
	$css = '',
	$date = '',
	$current = '',
	$url = 'https://liturgischer-kalender.bayern-evangelisch.de/widget/widget.php',
	$bodyonly = true ) {

    switch  (strtolower($fields)) {
        case "all":
        case "max":
            $fields = '0,1,2,3,4,5,6,7,8,9';
            break;
        case "few":
            $fields='0,1,5';
            break;
    }
		$queryString = 'size=' . $size . '&fields=' . $fields . '&css=' . $css . '&date=' . $date . '&current=' . $current ;

		$widgeturl = $url . '?' . $queryString ;

		$content = '';

		if (function_exists('curl_init')) {
			$content = $this->get_withcurl($widgeturl) ;
		}
		else {
			$content = $this->get_withoutcurl($widgeturl) ;
		}

		/**
		 * Überflüssiges bei Bedarf HTML entfernen!
		 */
	
        if ($bodyonly) { $content = $this->removeHeadBody( $content ); }
        
        return $content;
}

} // End of class

?>
