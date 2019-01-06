# ev-kirchenjahr
WordPress Plugin zur Anzeige des "Kirchenjahr evangelisch" mit einem Widget oder Shortcode *litkalender*

Das Widget zeigt die Informatione zu einem Feiertag von Kirchenjahr evangelisch]([https://literliturgischer-kalender.bayern-evangelisch.de) als Widget in einer WordPress-Seitenleiste an.

Alternativ kann die Information in einem Artikel oder einer Seite mit dem Shortcode *litkalender* eingebunden werden.

Beispiel Shortcode:

    [litkalender size=big fields=0,1,2,3,4,5,6,7,8,9 date=2023-12-24]

## Beispiel

![Screenshot](https://raw.githubusercontent.com/Byggvir/ev-kirchenjahr/master/screeshot-1.png)

## Parameter

Die Ausgabe des Widgets kann über verschiedene Parameter gesteuert werden.

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


Die Parameter *url* und *css* sind im Shordcode nicht implementiert, da nicht sinnvoll. Die von *Kirchenjahr evangelisch* zurückgelieferten CSS-Informatioen werden entfernt und durch eigene ersetzt.

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