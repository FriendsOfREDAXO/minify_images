## REDAXO-AddOn: minify_images

Das AddOn stellt Media Effekte zur Verfügung, über die Bilder optimiert werden können. Hierzu wird ein auf dem Server installiertes ImageMagick verwendet, falls vorhanden. Außerdem können Bilder über den Webdienst tinypng zusätzlich weiter optimiert werden. Hierzu ist ein apikey notwendig.

### Installation

1. Über den Installer laden oder Zip-Datei im AddOn-Ordner entpacken, der Ordner muss „minify_images“ heißen.
2. AddOn installieren und aktivieren.
3. In der Konfiguration des AddOns ein Optimierungstool auswählen. Ggf. eine andere Einstellung vornehmen und das Ergebnis prüfen.
4. In der Konfiguration des MediaManagers die gewünschte Qualität einstellen.
5. Dem Media Effekt zum Schluss den Effekt rex_effect_optimize hinzufügen

### Tinypng

[Tinypng](https://tinypng.com/) ist ein Webdienst, der Bilder über einen speziellen Algorithmus optimiert, um eine möglichst geringe Dateigröße bei optimaler Qualität zu erzielen.
Der Dienst ist kostenpflichtig, eine Anmeldung ist erforderlich. Der API Key wird ins Feld Tinify Key der AddOn Konfiguration eingetragen.

### Credits

* [Friends Of REDAXO](https://github.com/FriendsOfREDAXO) Gemeinsame REDAXO-Entwicklung!
* [Thomas Kaegi](https://github.com/phoebusryan) für die Entwicklung
* [Thomas Skerbis ](http://klxm.de)
* [Dirk Schürjohann](https://github.com/schuer)

---

