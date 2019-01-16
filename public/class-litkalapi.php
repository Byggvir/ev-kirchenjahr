<?php
/**
 * public/class-litcalapi.php
 *
 * @link              http://byggvir.de
 * @since             2019.1.0
 * @version 2019.2.0
 * @copyright 2019 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @plugin-wordpress
 *
 *
 *
 * API zur Web-Seitehttps://liturgischer-kalender.bayern-evangelisch.de/widget/widget.php
 *
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @package  EvKj
 */


/**
 * Security check: Exit if script is called directly
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once EVKJ_PATH . 'lib/class-wget.php' ;

$evkj_DefFields = array (
	0 => 'wochenvers', // (als Bibelstelle)
	1 => 'wochenpsalm' ,
	2 => 'eingangspsalm' ,
	3 => 'atlesung' ,
	4 => 'epistel' ,
	5 => 'predigttext' ,
	6 => 'evangelium' ,
	7 => 'wochenlied' ,
	8 => 'liturgischefarbe' ,
	9 => 'wochenspruch' // Text + Bibelstelle
) ;

$evkj_DefLabels = array (
	'id'                  => 'Id', // (als Bibelstelle)
	'cachetime'           => 'Ab&shy;ge&shy;ruf&shy;en am' , // (als Bibelstelle)
	'reqdate'             => 'für den' , // (als Bibelstelle)
	'litdate'             => 'Näch&shy;ster Feier&shy;tag' , // (als Bibelstelle)
	'litname'             => 'Name' , // (als Bibelstelle)
	'litfarbe'            => 'Lit. Farbe' , // (als Bibelstelle)
	'nextdate'            => 'Näch&shy;ster ho&shy;her Feier&shy;tag' , // (als Bibelstelle)
	'nextname'            => 'Näch&shy;ster ho&shy;her Feier&shy;tag', // (als Bibelstelle)
	'nextfarbe'           => 'Näch&shy;ster ho&shy;her Feier&shy;tag', // (als Bibelstelle)
	'wochenvers'          => 'Woc&shy;hen&shy;vers' , // (als Bibelstelle)
	'wochenspruch'        => 'Woc&shy;hen&shy;spruch' , // Text + Bibelstelle
	'wochenpsalm'         => 'Woc&shy;hen&shy;psalm' ,
	'wochenlied'          => 'Woc&shy;hen&shy;lied' ,
	'eingangspsalm'       => 'Ein&shy;gangs&shy;psalm' ,
	'atlesung'            => 'AT-Le&shy;sung' ,
	'epistel'             => 'E&shy;pis&shy;tel' ,
	'predigttext'         => 'Pre&shy;digt&shy;text' ,
	'evangelium'          => 'E&shy;van&shy;ge&shy;li&shy;um' ,
	'liturgischefarbe'    => 'Lit. Farbe'
) ;

/**
 * Define class
 *
 * @class evkj_WidgetAPI
 *
 */
class evkj_WidgetAPI {

	/**
	 * Schnittstelle zum Widget Liturgischer Kalender
	 *
	 * @param text    $text
	 * @return formtierter text
	 */
	public $version;

	/** constructor */

	function __construct() {

		$this->version = EVKJ_VERSION;

	}


	/**
	 * Schnittstelle um eine HTMML-Seite zu laden.
	 *
	 * Funktioniert auch ohne Curl (nicht gestestet sonder 1:1 von TA EvTermine übernommen).
	 *
	 * @since 2019.1.0
	 * @param string  $url
	 * @return string (HTML)
	 */

	/**
	 * Beliebiges halbwegs interpretierbares englisches Datum in das Format der Schnittstelle konvertieren
	 *
	 * @param string  $date (optional)
	 * @return unknown
	 */
	private function convertDate( $date = '') {

		if (($timestamp = strtotime($date)) === false) {
			return date('Y-m-d');
		} else {
			return date('Y-m-d', $timestamp);
		}

	}



	/**
	 *
	 * @param unknown $reqdate (optional)
	 * @param unknown $fields  (optional)
	 * @return unknown
	 */
	private function getcache( $reqdate = '', $fields = '0,1,2,3,4,5,6,7,8,9' )  // Format reqdate = 'Y-m-d'
		{

		global $wpdb, $evkj_DefFields ;
        
        $table_name = $wpdb->prefix . EVKJ_CACHETAB;

        $fieldsarr = preg_split('/,/', $fields);

        $sqlfields = 'litdate,litname,litfarbe,nextdate,nextname,nextfarbe';

        if ( WP_DEBUG ) {
            $sqlfields = 'id,cachetime,reqdate,' . $sqlfields;
        }

        if ( $fields != '' ) {
            foreach ( $fieldsarr as $value ) {
                $sqlfields .= "," . $evkj_DefFields[$value];
            }
        }
        $result = $wpdb->get_row (
            "SELECT $sqlfields FROM $table_name WHERE reqdate = \"$reqdate\" order by reqdate;" ,
            ARRAY_A
        ) ;

        if (empty($result)) {
            $this->updatecache($reqdate);
            $result = $wpdb->get_row (
                "SELECT $sqlfields FROM $table_name WHERE reqdate = \"$reqdate\" order by reqdate;" ,
                ARRAY_A
            ) ;
        }
		
		return $result;
	}


	// reqdate as 'Y-m-d'

	/**
	 *
	 * @param unknown $reqdate
	 * @param unknown $content
	 * @return unknown
	 */
	private function makeinsert_sql($reqdate, $content) {

		global $wpdb;

		$table_name = $wpdb->prefix . EVKJ_CACHETAB;

		$lines=preg_split('/[\r\n]+/', $content);

		$datelist=preg_grep('#article.php#', $lines);
		$fieldlist=preg_grep('#<br />#', $lines);

		$test="";

		$sql="INSERT INTO $table_name ";

		/* Datum und Namen extrahieren */

		$keylist = '(cachetime,reqdate,litdate,litname,litfarbe,nextdate,nextname,nextfarbe';
		$vallist = '("' . date('Y-m-d H:i:s') . '","' . $reqdate . '"';

		//Tage filtern
		foreach ($datelist as $key => $field) {

			preg_match('#.*class="lk_widget_([a-z]*) lk_widget_bulletpoint lk_widget_icon-circle"></span><a target="_blank" href="[^"]*">([0-9]{2}\.[0-9]{2}\.[0-9]{4}) (.*)</a>#', $field, $treffer);

			$field = trim(preg_replace('#<[^>]*>#', '', $field));

			$fval1 = trim(addslashes(preg_replace('# .*#', '', $field)));
			$fval2 = trim(addslashes(preg_replace('#.*20[0-9][0-9]#', '', $field)));
			$vallist.= ',"'. $this->convertDate($treffer[2]) . '","' . $treffer[3] . '","' . $treffer[1] .'"' ;
		}

		/* Verse, Farben ... extrahieren */

		foreach ($fieldlist as $key => $field) {

			if ( ! preg_match('/Zum Kalender/', $field)) {
				$temp = trim(preg_replace('#<br />#', ' ', $field)); // Zeilenumbruch zu lehrzeichen

				$temp=preg_replace('/<[^>]*>/', '', $temp);   // HTML Code entfernen
				$temp=preg_replace('/^[\t ]*/', '', $temp);  // Einrückungen entfernen

				if ( preg_match( '/([A-Za-z\- ]+): (.*)/', $temp, $treffer ) ) {
					$keylist .= "," . trim(addslashes(strtolower(preg_replace('/[^A-Za-z]/', '', $treffer[1]))));
					$vallist .= ",\"". $treffer[2] ."\"";
				}
			}

		} //foreach


		$sql .= $keylist . " ) VALUES " . $vallist . " );";
		return $sql;

	}



	/**
	 * Get the information for a requested date and update the cache table_name
	 *
	 * @param unknown $reqdate
	 */
	private function updatecache( $reqdate ) {

		global $wpdb;

		$table_name = $wpdb->prefix . EVKJ_CACHETAB;

		$queryString = 'size=big&fields=0,1,2,3,4,5,6,7,8,9&date=' . $reqdate ;
		$wget = new evkj_wget ();
		$content = $wget->get( EVKJ_URL . '?' . $queryString ) ;

		$sql = $this->makeinsert_sql($reqdate, $content);

		$wpdb->query($sql);

		$wochenvers = addslashes(preg_replace('/.*\(([^\)]*)\).*/', '\1', ( $wpdb->get_var ( "SELECT wochenspruch from " . $wpdb->prefix . EVKJ_CACHETAB . " WHERE reqdate = \"$reqdate\" ;" ))));
		$wpdb->query("UPDATE " . $wpdb->prefix . EVKJ_CACHETAB . " set wochenvers= \"$wochenvers\" WHERE reqdate = \"$reqdate\" ;" );

		/*		if (WP_DEBUG){
            echo '<div style="color:green; font-size:1em;z-index:1000;">' . $sql .'</div>';
        }
*/

	} // function updatecache


	/**
	 *
	 * @param unknown $size   (optional)
	 * @param unknown $result
	 * @param unknown $fields (optional)
	 * @return unknown
	 */
	private function toHTMLdivtable( $size = 'small', $result, $fields = '0,1,2,3,4,5,6,7,8,9' ) {

		global $evkj_DefFields, $evkj_DefLabels;

		$content  = "<div class=\"evkj-table evkj-table-". $result['litfarbe'] . "\">\n" ;
		$content .= "<div class=\"evkj-table-body evkj-table-". $result['litfarbe'] . "\">\n";

		$content .= "\t<div class=\"evkj-row evkj-row-date evkj-litdate evkj-row-". $result['litfarbe'] . "\">\n";

		$content .= "\t\t<div class=\"evkj-h1\">Nächster Feiertag</div>\n";
		$content .= "\t\t<div class=\"evkj-cell evjk-cell-litdate evkj-cell-". $result['litfarbe'] . "\">" . date_i18n( get_option( 'date_format' ), strtotime( $result['litdate'] ) ) . "</div>\n";
		$content .= "\t\t<div class=\"evkj-cell evkj-cell-litname evkj-cell-". $result['litfarbe'] . "\">" . $result['litname'] . "</div>\n";

		$content .= "\t</div>\n";

		if ( $size == 'big' ) {

			$fieldsarr = preg_split('/,/', $fields);
			$content .= "\t<div class=\"evkj-fields\">\n";
			foreach ( $fieldsarr as $key => $value ) {
				if ($value != 0 ) {

					$f = $evkj_DefFields[$value];
					$l = $evkj_DefLabels[$f];
					$v = preg_replace('/Evangelisches Gesangbuch/', 'EG', $result[$evkj_DefFields[$value]]);
					$v = preg_replace('/ oder EG/', '<br />EG', $v);
					$content .= "\t<div class=\"evkj-row evkj-row-fields evkj-row-$f\">\n";
					$content .= "\t\t<div class=\"evkj-head evkj-field-label evkj-head-$f\">$l:</div>\n";
					$content .= "\t\t<div data-label=\"$l\" class=\"evkj-cell evkj-field-value evkj-cell-$f\">" . $v . "</div>\n";
					$content .= "\t</div>\n";
				}
			}

			$content .= "\t</div> <!-- End of fields-->\n";

			/* Nächster hoher Feiertag */


			$content .= "\t<div class=\"evkj-row evkj-row-date  evkj-nextdate evkj-row-". $result['nextfarbe'] . "\">\n";

			$content .= "\t\t<div class=\"evkj-h1\">Nächster hoher Feiertag</div>\n";
			$content .= "\t\t<div class=\"evkj-cell evjk-cell-nextdate evkj-cell-". $result['nextfarbe'] . "\">" . date_i18n( get_option( 'date_format' ), strtotime( $result['nextdate'] ) ) . "</div>\n";
			$content .= "\t\t<div class=\"evkj-cell evkj-cell-nextname evkj-cell-". $result['nextfarbe'] . "\">" . $result['nextname'] . "</div>\n";

			$content .= "\t</div>\n";
		}

		return $content . "</div>\n</div>\n";
	}


	/**
	 * Meaning of the request parabeter from https://liturgischer-kalender.bayern-evangelisch.de/
	 *
	 * Parametername |  Werte
	 * ------------- | -------------
	 * size    | 'small' oder 'big'. Gibt die gewünschte Variante des Widgets an. 'small' steht für Variante 1, 'big' für Variante 2. Standard: 'small'
	 *         | Default for the WordPress plugin is 'big'
	 * css     | Vollständige URL zu einer CSS-Datei. Ermöglicht die individuelle Gestaltung des Widgets mittels einer eigenen CSS-Datei.
	 *         | not used by the WordPress plugin. We use our own style and remove all HTML from the response!
	 * fields  | Eine kommaseparierte Liste von Werten aus folgender Tabelle. Ermöglicht die Auswahl der anzuzeigenden liturgischen Felder für Variante 2 des Widgets. Standard: 0,1,2,3,4,5
	 *         | The WordPress plugin  accepts also 'all', 'few' and 'min'
	 * date | Format: 'YYYY-mm-dd' (z.B. 2016-12-31). Hiermit gibt das Widget Daten für ein bestimmtes Datum aus. Standard: aktueller Tag.
	 *
	 * current | 'true'. Falls gesetzt, gibt das Widget Daten für die laufende Woche aus. Standard: (leer)
	 *
	 *
	 * Liturgische Felder (fields):
	 *
	 * Wert |Feld
	 * -----|----
	 * 0    | Wochenspruch (als Bibelstelle)
	 * 1    | Wochenpsalm
	 * 2    | Eingangspsalm
	 * 3    | AT-Lesung
	 * 4    | Epistel
	 * 5    | Predigttext
	 * 6    | Evangelium
	 * 7    | Wochenlied
	 * 8    | liturgische Farbe als Text
	 * 9    | Wochenspruch (als Text)
	 *
	 * @param string  $size     (optional)
	 * @param string  $fields   (optional)
	 * @param string  $current  (optional)
	 * @param string  $date     (optional)
	 * @param string  $bodyonly (optional)
	 * @return string
	 */
	public function getday(

		$size = 'big' ,
		$fields = '1,2,3,4,5,6,7,8,9' ,
		$current = '' ,
		$date = '' ,
		$bodyonly = true
	) {

		switch ( strtolower( $fields ) ) {
		case "all" :
			$fields = '0,1,2,3,4,5,6,7,8,9' ;
			break ;
		case "max" :
			$fields = '1,2,3,4,5,6,7,8,9' ;
			break ;
		case "min" :
			$fields = '0,1,5' ;
			break ;
		case "few" :
			$fields = '0,1,5' ;
			break ;
		case "none" :
			$fields = '' ;
			break ;
		}
       if (preg_match('/(Googlebot|bingbot)/', $_SERVER['HTTP_USER_AGENT'])) {
        
        $return '
                <div>Der HERR sprach zu den Bots:<br /> Und ich sage euch auch:<br />Bittet, so wird euch gegeben;<br /> suchet, so werdet ihr finden;<br />klopfet an, so wird euch aufgetan<br />
                <a href="https://www.bibleserver.com/search/LUT/suchet/1">Lukas 11,9</a></div>
            ';
		} else {
		
            $fields = preg_replace('#([0-9](,[0-9])*).*#', '$1', $fields);

            /**
            * The Plugin accepts all date formate which are acceppted by the strtotime
            */
            ( $date != "" )? $reqdate = $this->convertDate( $date ) : $reqdate = date( 'Y-m-d' ) ;

            // Nur true oder leer!

            ( strtolower( $current ) == "true" ) ? $current = "true" : $current = "" ;

            $result = $this->getcache ( $reqdate, $fields ) ;

            if (empty ( $result ) ) {
                return $this->fallback ( $size, $fields, $current, $reqdate, $bodyonly ) ;
            }
            else {
                return $this->toHTMLdivtable ( $size, $result, $fields ) ;
            }
        }
	}


} // End of class

?>
