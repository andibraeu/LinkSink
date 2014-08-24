Freifunk LinkSink
=================

Mit diesem Dienst ist es möglich, Links zu sammeln, zu kategorisieren und mit Hilfe von Tags verschiedenen Themengebieten zuzuordnen. Somit ist es möglich, Links aus verschiedenen Quellen zusammenzutragen und damit z.B. einen Pressespiegel zu erstellen. Ein weiterer Anwendungsfall ist das Sammeln von Podcasts, die zu einem neuen Feed zusammengeführt werden.

 Nach Kategorien, Erscheinungsjahr oder Tags kann gefiltert werden. Aus diesen Filterergebnissen lassen sich RSS-Feeds ableiten.

Installation
------------

siehe INSTALL.md

mögliche Abfragerouten
----------------------

Die Suchabfragen lassen sich auch direkt per URL aufrufen. Das Format ist optional und kann rss oder html sein, für Kategorien oder Tags werden die Namen in URL-tauglicher Form in der Datenbank abgelegt

* ```/kategorie/s/{category}.{format}```: Suche nach Kategorie
* ```/kategorie/s/{category}/{year}.{format}```: Suche nach Kategorie und Jahr
* ```/kategorie/s/{category}/{year}/{tag}.{format}```: Suche nach Kategorie, Jahr und Tag
* ```/kategorie/s/{category}/{tag}.{format}```: Suche nach Kategorie und Tag
* ```/tags/{tag}.{format}```: Suche nach Tag

weitere Routen
--------------

* ```/kategorie```: Kategorieverwaltung
* ```/kategorie/neu```: neue Kategorie anlegen
* ```/links/neu```: neuen Link anlegen
