=== Plugin Name ===
Contributors: ByggvirOfBarley
Donate link: https://byggvir-de
Tags: Liturgie, Kalender
Requires at least: 3.0
Tested up to: 5.2.1
Stable tag: 2019.3.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

WordPress Plugin zur Anzeige des "Kirchenjahr evangelisch" als Widget

== Description ==

## Kirchenjahr Evangelisch
WordPress Plugin zur Anzeige des "Kirchenjahr evangelisch" als Widget

## Parameter

Die Ausgabe des Widgets oder der Shortcodes kann über mehrere Parameter gesteuert werden.

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

## Links zu Online-Bibeln

Mit der Version 2019.3.0 werden die Verse zu Online-Bibeln verlinkt. Getestet wurde die Verlinkung mit bibelserver.com und die-beibel.de.

In der Einstellungsseite kann die gewünschte Onlinebibel und die Übersetzung angegeben werden. Beispiele sind auf der Einstellungsseite aufgeführt. D
er Wert des Parameter Translation hängt von der jeweiligen Onlinebibel ab.

### Beispiele bibelserver.com

####Abkürzungen der Übersetzungen

LUT | Lutherbibel 2017
ELB | Elberfelder Bibel
HFA | Hoffnung für Alle
SLT | Schlachter 2000
ZB | Zürcher Bibel
NGÜ | Neue Genfer Übersetzung
GNB | Gute Nachricht Bibel
EU | Einheitsübersetzung 2016
NLB | Neues Leben. Die Bibel
NeÜ | Neue evangelistische Übersetzung
MENG | Menge Bibel
ESV | English Standard Version
NIV | New International Version
NIRV | New Int. Readers Version
KJV | King James Version
KJVS | King James V. with Strong's Dictionary
BDS | Bible du Semeur
S21 | Segond 21
ITA | La Parola è Vita
NRS | Nuova Riveduta 2006
HTB | Het Boek
LSG | Louis Segond 1910
CST | Nueva Versión Internacional (Castilian)
NVI | Nueva Versión Internacional
BTX | La Biblia Textual
PRT | O Livro
NOR | En Levende Bok
BSV | Nya Levande Bibeln
DK | Bibelen på hverdagsdansk
PSZ | Słowo Życia
CEP | Český ekumenický překlad
SNC | Slovo na cestu
B21 | Bible, překlad 21. století
BKR | Bible Kralická
NPK | Nádej pre kazdého
KAR | IBS-fordítás (Új Károli)
HUN | Hungarian
NTR | Noua traducere în limba românã
BGV | Верен
CBT | Библия, нов превод от оригиналните езици
CKK | Knjiga O Kristu
RSZ | Новый перевод на русский язык
CARS | Священное Писание, Восточный перевод
TR | Türkçe
NAV | Ketab El Hayat
FCB | کتاب مقدس، ترجمه تفسیری
CUVS | 中文和合本（简体）
CCBT | 聖經當代譯本修訂版
OT | Hebrew OT
LXX | Septuaginta
VUL | Vulgata
ABV | Hörbibel

### Beispiele die-bibel.de

####Abkürzungen der Übersetzungen

LU | Luther (ursprünglich Luther 1984, jetzt Luther 2017)
LUT17 | Luther 2017
LUT84 | Luther 1984
GNB | Gute Nachricht
MNG | Menge
EUE | Einheitsübersetzung
ZUB | Zürcher
NGUE | Neue Genfer Übersetzung
SCHL | Schlachter
KJV | King James 


== Installation ==

### Von WordPress ###

Unter Plugins -> Installieren nach "kirchenjahr" suchen. Dann "Installieren" und "Aktivieren" anklicken.  

### Von GitHub ###

Mit **git** wird das Plugin mit folgendem Befehl installiert

    git clone https://github.com/Byggvir/ev-kirchenjahr/

### ZIP-Archiv ###

Als ZIP -Archiv von github herunterladen und in */wp-content/plugins* entpacken.

Ungefähr so:

    get https://github.com/Byggvir/ev-kirchenjahr/archive/2019.3.1.zip
    unzip 2019.3.1.zip
    mv  ev-kirchenjahr-2019.3.1 /var/www/html

Die 2019.3.1 bitte durch die aktuelle Version ersetzen oder ein Update ausführen.
 
== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= Wie steht es mit dem Datenschutz? =

Das Plugin ist datenschutz-freundlich

Das Plugin bekommt alle Daten von dem Server, der die WordPress Seite hosted. Es werden keine Daten des Anfragenden an dritte Server weitergegeben.
Befindet sich ein Tag noch nicht im Datenbestand des Servers, versucht der Server die Daten von www.kirchenjahr-evangelisch.de zu holen und speichert
sie ins einem Cache. Anschließend werden die Daten aus dem Cache gelesen und ausgeliefert. Dabei werden keine Informationen über den Seitenaufrufer an
www.kirchenjahr-evangelisch.de weitergegeben. Daten des Anfragers (IP-Adresse, User-Agent ...) werden nicht im Cache gespeichert.  

== Screenshots ==

1. Example
2. Example
3. Example
4. Example
5. Example
6. Example



== Changelog ==

