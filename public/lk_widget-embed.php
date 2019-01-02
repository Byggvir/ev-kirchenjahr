<?php
# Konfigurationsmöglichkeiten

# Geben sie hier die gewünschte Widgetvariante ('small' oder 'big') an.
$size = 'big';

# Geben Sie hier die gewünschten liturgischen Informationen kommasepariert (0 = Wochenpsalm, 1 = Wochenspruch, 2 = Eingangspsalm, 3 = AT-Lesung, 4= Epistel, 5 = Predigttext) an.
$fields = '0,1,5';

# Geben Sie hier eine CSS-Datei an, die im Widget aufgerufen werden soll (z.B. http://www.ihredomain.de/meincss.css).
$css = '';

# Geben Sie hier ein spezifisches Datum an, zu dem das Widget Daten anzeigen soll
$date = '';

# Geben Sie hier ein 'true' ein, wenn das Widget den aktuellen statt den kommenden Feiertag anzeigen soll
$current = '';

# Ab hier bitte nichts ändern #
$queryString = 'size=' . $size . '&fields=' . $fields. '&css=' . $css. '&date=' . $date. '&current=' . $current;

$url = "https://liturgischer-kalender.bayern-evangelisch.de/widget/widget.php?" . $queryString;
$lk_widget_content = '';

if(function_exists('curl_init')){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $content = curl_exec ($curl);
    $curl_info = curl_getinfo ($curl);
    if($curl_info['http_code'] == '200'){
        $lk_widget_content =  $content;
    } else {
        $lk_widget_content = '<div>Der liturgische Kalender ist derzeit nicht verfügbar.</div>';
    }
} else {
    $lk_widget_content = "Das benötigte PHP-Modul curl ist nicht installiert.";
}

print $lk_widget_content;
?>