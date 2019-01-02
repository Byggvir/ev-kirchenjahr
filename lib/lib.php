<?php
/**
 * lib/lib.php
 *
 * @package           Ev-Kirchenjahr
 * @link              http://byggvir.de
 * @since             2019.0.1
 * @version 2019.0.1
 * @copyright 2019 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @plugin-wordpress
 *
 */
function evkj_get_withoutcurl ( $url ) 
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

/* Get list of events if CURL is available.  */

function evkj_get_withcurl ( $url, $agent = 'Ev. Kirchenjahr Plugin 2019.0.0 / Thomas Arend / https://byggvir.de')
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
?>
