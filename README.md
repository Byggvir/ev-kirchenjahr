# ev-kirchenjahr
WordPress Plugin zur Anzeige des "Kirchenjahr evangelisch" mit einem Widget oder Shortcode *litkalender*

Das Widget zeigt die Informationen zu einem Feiertag von [Kirchenjahr evangelisch]([https://literliturgischer-kalender.bayern-evangelisch.de) als Widget in einer WordPress-Seitenleiste an.

Alternativ kann die Information in einem Artikel oder einer Seite mit dem Shortcode *litkalender* eingebunden werden.

Beispiel Shortcode:

    [litkalender size=big fields=0,1,2,3,4,5,6,7,8,9 date=2023-12-24]

## Beispiele

![Screenshot](https://raw.githubusercontent.com/Byggvir/ev-kirchenjahr/master/evkj-1.png)
![Screenshot](https://raw.githubusercontent.com/Byggvir/ev-kirchenjahr/master/evkj-2.png)
![Screenshot](https://raw.githubusercontent.com/Byggvir/ev-kirchenjahr/master/evkj-3.png)
![Screenshot](https://raw.githubusercontent.com/Byggvir/ev-kirchenjahr/master/evkj-4.png)
![Screenshot](https://raw.githubusercontent.com/Byggvir/ev-kirchenjahr/master/evkj-5.png)
![Screenshot](https://raw.githubusercontent.com/Byggvir/ev-kirchenjahr/master/evkj-6.png)

## Abrbeitsweise

Dau Plungin holt die Daten mittels [../widget-php?size=big&date=<datum>&fields=0,1,2,3,4,5,6,7,8,9]([https://literliturgischer-kalender.bayern-evangelisch.de/widget/widget-php?size=big&date=<datum>&fields=0,1,2,3,4,5,6,7,8,9) vom Server, wertet die Rückgabe aus und speichert das ergebnis in einer WordPress Tabelle *&lt;wp-prefix&gt;-evkj-cache*. Vor erneuter Abfrage eines bestimmten Datums wird geprüft, ob die Werte bereist in der Cache Tabelel enthalten sind. Dies entlastet den Server und beschleunigt die Auslieferung der Seiten.

## Parameter

Die Ausgabe des Widgets auf [Kirchenjahr evangelisch]([https://literliturgischer-kalender.bayern-evangelisch.de) kann über verschiedene Parameter gesteuert werden. Das Plugin erweitert den Wertevorrat der Parameter.

Während [Kirchenjahr evangelisch] das Datum im Format 'Y-m-d' erwartet, werden vom Plungin zusätzliche (englische) Werte wie 'today + 5 weeks' oder 'next year' akzepiert.


Parametername |  Werte
------------- | -------------
size    | 'small' oder 'big'. Gibt die gewünschte Variante des Widgets an. 'small' steht für Variante 1, 'big' für Variante 2. Standard: 'small'
        | Default for the WordPress plugin is 'big'
css     | Vollständige URL zu einer CSS-Datei. Ermöglicht die individuelle Gestaltung des Widgets mittels einer eigenen CSS-Datei.
        | not used by the WordPress plugin. We use our own style and remove all HTML from the response!
fields  | Eine kommaseparierte Liste von Werten aus folgender Tabelle. Ermöglicht die Auswahl der anzuzeigenden liturgischen Felder für Variante 2 des Widgets. Standard: 0,1,2,3,4,5
        | The WordPress plugin  accepts also 'all', 'few' and 'min'
date | Format: 'YYYY-mm-dd' (z.B. 2016-12-31). Hiermit gibt das Widget Daten für ein bestimmtes Datum aus. Standard: aktueller Tag.
current | 'true'. Falls gesetzt, gibt das Widget Daten für die laufende Woche aus. Standard: (leer)

### Auswahl liturgischer Felder (fields):

Liturgische Felder (fields):

Wert |Feld
-----|----
0    | Wochenspruch (als Bibelstelle)
1    | Wochenpsalm
2    | Eingangspsalm
3    | AT-Lesung
4    | Epistel
5    | Predigttext
6    | Evangelium
7    | Wochenlied
8    | liturgische Farbe als Text
9    | Wochenspruch (als Text)
all  | 0 .. 9
max  | 1 .. 9
min  | 0,1,5
few  | 0,1,5

Die Parameter *url* und *css* werden vom Plugin nicht genutzt. Die von *Kirchenjahr evangelisch* zurückgelieferten CSS-Informatioen werden entfernt und durch eigene ersetzt.

Der Parameter *url* wäre nur sinnvoll, wenn es eine zweite Quelle für die Informationen gäbe, was derzeit nicht der Fall ist. er kann aber über die Einstellungen geändert werden (Steht noch auf ToDo).

## Installation

### git

Mit **git** wird das Plugin mit folgendem Befehl installiert

```shell
git clone https://github.com/Byggvir/ev-kirchenjahr/
```

### ZIP-Archiv

Als ZIP-Archiv des Branch Master von github herunterladen und in */wp-content/plugins* entpacken.

Ungefähr so:

```shell
wget https://github.com/Byggvir/ev-kirchenjahr/archive/master.zip -d /var/www/html/wp-content/plugins/
unzip master.zip
```shell

Oder das letzte stabile Release 
* [zip](https://github.com/Byggvir/ev-kirchenjahr/archive/v2019.0.0.zip)
* [tar.gz](https://github.com/Byggvir/ev-kirchenjahr/archive/v2019.0.0.tar.gz)

## Changes

* v2019.1.0 Shortcode *litcalender*
* v2019.1.1 Erkenne Google und Bing Bot und hole keine Lit. Termine