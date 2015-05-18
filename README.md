# Webseite der Sparte Badminton im TSV Gersthofen

## Development Setup (Windows)
* Verzeichnisse erstellen
	* Webseite: c:\src\www.badminton-gersthofen.de
	* Git Arbeitskopie: c:\src\badminton-gersthofen
* FTP Sync
	* Vom FTP nach c:\src\www.badminton-gersthofen.de synchronisieren
* XAMPP [download](https://www.apachefriends.org/de/index.html)
	* Installation: 
		* Wir brauchen Apache, MySQL, PHP, phpMyAdmin. 
		* Das Standardverzeichnis c:\xampp ist hier ok.
		* Windows Firewall: Zugriff für httpd.exe akzeptieren
	* XAMPP Control Panel öffnen
	* Apache einrichten
		* Vhost konfigurieren: in der Datei "c:\xampp\apache\conf\extra\httpd-vhosts.conf" folgendes einfügen:
				
				```apache
				<VirtualHost *:80>
					DocumentRoot "C:/src/www.badminton-gersthofen.de/htdocs"
					ServerName localhost
					DirectoryIndex index.html index.php
					ErrorLog "logs/www.badminton-gersthofen.de-error.log"
					CustomLog "logs/www.badminton-gersthofen.de-access.log" common
					<Directory "C:/src/www.badminton-gersthofen.de/htdocs">
						Options All
						AllowOverride All
						Require all granted
					</Directory>
				</VirtualHost>
				```
				
		* Apache starten
	* MySQL DB einrichten
		* MySQL starten
		* Windows Firewall: Zugriff für mysqld.exe akzeptieren
		* Live DB exportieren und in lokalen MySQL Server importieren
	* Testen der lokalen Webseite unter [http://localhost](http://localhost)
* Git z.B.: [GitHub Windows](https://windows.github.com/) oder [SourceTree](https://www.sourcetreeapp.com/)
	* ToDo
* NetBeans IDE die HTML5 & PHP Variante reicht hier vollkommend aus, [download](https://netbeans.org/downloads/)
	* ToDo


## Development Workflow
* Branches
	* dev: Alle Eintwicklungen sollten hier eingecheckt werden
	* master: hier sollte niemand einchecken, wir wollen bei abgeschlossenen Tasks immer vom dev-Branch hier rein "mergen" und dann auf den FTP Server synchronisieren
* Issue-Tracking: jeder Task sollte in den Issues erfasst sein, siehe hierzu: [Mastering Issues](https://guides.github.com/features/issues/)
* Commit-Messages: jeder Commit sollte eine gültige Issue Nummer beinhalten, z.B.: "#123: Fehler xyz behoben"
* **WICHTIG !!!: keine Passworter oder Benutzer Daten im Github ablegen oder in irgendwelchen Issues aufschreiben.**
