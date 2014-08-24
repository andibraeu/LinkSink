# Installationanleitung

## Vorraussetzungen

  * Einen Webserver mit PHP (z.B. nginx oder Apache)
  * GIT
  * Eine Datenbank. Folgende werden unterstützt: [PostgreSQL](http://www.postgresql.org), [MySQL](https://www.mysql.com)/[MariaDB](https://mariadb.org) und [SQLite](https://www.sqlite.org). Ich empfehle PostgreSQL, weil die beste Datenbank ever.

## Anleitung

Diese Anleitung geht davon aus das du SSH-Zugriff auf deinen Server hast. Wenn du Calcifer auf einem Shared-Hosting-Anbieter installieren willst, so ist dies auch möglich, aber etwas komplizierter und wird irgendwann später beschrieben.

1. Das [Repo](https://github.com/andibraeu/LinkSink.git) irgendwo hin clonen
2. In das LinkSink Verzeichnis wechseln.
3. Abhängigkeiten installieren
 1. composer herunterladen ```curl -sS https://getcomposer.org/installer | php```
 2. Installation ausführen: ```php composer.phar install```
  - für PostgreSQL wähl pdo_pgsql als Datenbanktreiber
  - für MySQL wähle pdo_mysql als Datenbanktreiber
  - für SQLite ist pdo_sqlite zu nutzen, dabei ist der Pfad anzugeben. Der Standardpfad legt die Datei linksink.sqlite3 im Verzeichnis app an.
5. Dann die Tabellen erstellen: ```php app/console doctrine:schema:update --force```
6. Cache löschen ```php app/console cache:clear --env=prod --no-debug```
7. Assets dumpen ```php app/console assetic:dump --env=prod --no-debug```
6. Zum Schluss must du noch deinen Webserver [konfigurieren](http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html) und dann ist calcifer auch schon erreichbar.
