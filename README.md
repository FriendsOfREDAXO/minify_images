## Minify (Bilder)

Das AddOn stellt einen __Effekt für REDAXOs Media Manager__ zur Verfügung, über den Bilder optimiert werden können. Die Optimierung kann direkt auf dem Server oder über einen externen Dienst (TinyPNG) erfolgen.

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/minify_images/assets/minify_images_01.png)

### Anwendung

1. AddOn installieren und aktivieren.
2. In der Konfiguration des AddOn eins der angebotenen Optimierungs-Tools auswählen.
3. In der Konfiguration des Media Managers die gewünschte Bildqualität einstellen.
4. Dem gewünschten Mediatyp den Effekt `Bild: Minify` hinzufügen.

#### ImageOptimizer

ImageOptimizer nutzt verschiedene bekannte Bildoptimierer wie __optipng, pngquant, jpegoptim oder svgo__. Bitte beachten, dass diese auf dem Webserver installiert sein müssen! Infos dazu finden sich in der Dokumentation: [https://github.com/psliwa/image-optimizer](https://github.com/psliwa/image-optimizer)

#### Tinify (extern)

Tinify nutzt den __externen Webdienst__ [TinyPNG](https://tinypng.com), der Bilder über einen speziellen Algorithmus optimiert, um eine möglichst geringe Dateigröße bei optimaler Qualität zu erzielen.

Der Dienst ist in geringem Umfang kostenlos, bei normaler Nutzung aber kostenpflichtig. Es ist eine Anmeldung erforderlich. Danach wird ein __API-Key__ bereitgestellt, der in der Konfiguration des AddOns eingetragen werden muss.

#### Imagemagick

Imagemagick ist ein __populärer Bildprozessor__, der leider nicht auf allen Webservern installiert ist. Wenn er jedoch installiert ist, leistet er hervorragende Dienste.


### Funktion

Das AddOn stellt den Effekt `Bild: Minify` bereit, der im Media Manager angewendet werden kann. Damit wird das Bild dem ausgewählten Optimierungs-Tool übergeben. Sollte dieses Tool aus verschiedenen Gründen nicht funktionieren, greift REDAXOs normaler Bildprozess, und das Bild wird einfach nicht weiter optimiert. Im Fehlerlog (unter System > Logdateien) sollte dann ersichtlich sein, aus welchen Gründen die Optimierung nicht funktioniert hat.


### Credits

* [Friends Of REDAXO](https://github.com/FriendsOfREDAXO) Gemeinsame REDAXO-Entwicklung!
* [Thomas Kaegi](https://github.com/phoebusryan) für die initiale Entwicklung
