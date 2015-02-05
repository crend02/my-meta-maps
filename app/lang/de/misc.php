<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Client Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are send to the client as JSON file to 
	| be used as javascript language phrases at client-side.
	|
	*/

	//variables for frontpage.blade.php
	'register' => 'Registrieren',
	'addComment' => 'Kommentar hinzufügen',
	'profilChange' => 'Profil ändern',
	'pwchange' => 'Passwort ändern',
	'guest' => 'Gast',
	'login' => 'Anmelden',
	'imprint' => 'Impressum',
	'help' => 'Hilfe',
	'userinfo' => 'Benutzerhilfe',
	'clicktop' => 'Neu bei My Meta Maps? Wir erklären Ihnen gerne wie sie erfolgreich die ersten Schritte machen können. Klicken Sie einfach auf ',
	'furtherInfo' => '.',
	
	//variables for \app\views\pages\help.blade.php
	'headline' => 'Die Benutzerhilfe beantwortet Ihnen die wichtigsten Fragen zur Bedienung von My Meta Maps',
	'whatIsMMMTitle' => 'Was ist My Meta Maps?',
	'whatIsMMM' => 'My Meta Maps ist ein Web-Verzeichnis, das auf Basis von aggregierten Metadaten und Benutzerrezensionen das leichte Auffinden von Geodaten ermöglicht.',
	'howtoReg' => 'Wie registriere ich mich?',
	'howtoLogin' => 'Wie melde ich mich an?',
	'howtoComm' => 'Wie füge ich ein Kommentar hinzu?',
	'howtoChangeUserdata' => 'Wie ändere ich meine Daten?',
	'whichFilter' => 'Welche Filter gibt es?',
	'howtoSeeComments' => 'Wie kann ich die Kommentare zu einem Geodatensatz sehen?',
	'howtoShare' => 'Teile My Meta Maps mit anderen',
	'howtoLoginViaOAuth' => 'Melde dich über einen Drittanbieter an',
	'howtoChangeGeneral' => 'Wie ändere ich mein Profil?',
	'howtoChangePassword' => 'Wie ändere ich mein Passwort?',
	'filterInfoTitle' => 'Informationen zu den Filtern',
	'filterInfo' => 'Grundsätzlich beziehen sich die Filter auf die Kommentare zu Geodatensätzen. Falls du aber bei der Stichwortsuche die Metadaten miteinbeziehen möchtest,
	 kannst du dies über die passende Checkbox tun.',
	'spatialFilter' => 'Räumlicher Filter',
	'timeFilter' => 'Zeitlicher Filter',
	'rateFilter' => 'Filter nach Bewertung',
	'keywordSearch' => 'Stichwortsuche',
	'commentsFurtherInfosTitle' => 'Was sehe ich nun?',
	'buttonReg' => 'Die Registrierung auf My Meta Maps erfolgt über einen Klick auf die Schaltfläche',
	'buttonLogin' => 'Um sich nach der Registrierung einzuloggen klicken Sie oben rechts auf die Schaltfläche',
	'loginViaOAuth' => 'Alternativ kannst du dich sowohl über Facebook, GitHub, Google oder Twitter anmelden. Dir wird anschließend automatisch eine Account bei My Meta Maps erstellt.',
	'changeGeneral' => 'Oben rechts befindet sich ein Button mit ihrem Profilnamen. Dort kannst du zu einer Ansicht gelangen, um die Daten deines Profils zu ändern.
	 Du kannst sowohl deinen Benutzernamen als auch deine Email-Adresse ändern und zudem deine bevorzugte Sprache auswählen.',
	'changePassword' => 'Oben rechts befindet sich ein Button mit ihrem Profilnamen. Dort kannst du zu einer Ansicht gelangen, um dein Passwort zu ändern.',
	'buttonComment' => 'Oben rechts befindet sich die Schaltfläche zur Erstellung eines Kommentares',
	'noRegNec' => 'Es ist nicht nötig registriert oder angemeldet zu sein, um einen Kommentar hinzuzufügen.',
	'addCommentSteps' => 'Das Hinzufügen eines Kommentares erfolgt in zwei Schritten:',
	'addCommentStepOne' => 'Gebe die URL des Geodatensatzes ein und wähle das passende Datenformat aus. Falls es hier zu Problemen kommt, werden dir diese beschrieben.',
	'addCommentStepTwo' => 'Hier kannst du zum einen den Titel für den Geodatensatz festlegen, falls zu diesem noch keine Kommentare existieren, einen Layer, falls vorhanden, auswählen,
	 einen Fließtext eingeben, eine Geometrie erstellen und sowohl einen Zeitraum als auch eine Bewertung festlegen.',
	'addCommentNote' => 'Beachte: Der Fließtext ist verpflichtend. Beim Hinzufügen einer Geometrie kannst du zwischen Punkt, Linie und Polygon auswählen, allerdings auch nur eine Geometrie hinzufügen.',
	'addCommentTipp' => 'Tipp: In der Ansicht zu den Kommentaren eines Geodatensatzes kannst du direkt zu diesem Geodatensatz eine Kommentar erstellen und umgehst somit den ersten Schritt.',
	'acceptedFormats' => 'Folgende Datenformate werden von My Meta Maps akzeptiert:',
	'surrounding' => 'Der Umkreisfilter ermöglicht die selektierte Anzeige von Datensätzen in einem gewählten Umkreis um den Kartenmittelpunkt.',
	'searchDist' => 'Die Suche ist in festgelegten Stufen von 5 km bis 500 km möglich.',
	'timeFiltDef' => 'Der zeitliche Filter ermöglicht die Filterung von Datensätzen von bestimmten Zeiträumen.',
	'timeStartEnd' => 'Für die Einstellung des Zeitraumes können Sie einen Start- und einen Endzeitpunkt festlegen.',
	'rateDef' => 'Der Bewertungsfilter ermöglicht die selektierte Anzeige von Datensätzen mit bestimmten Bewertungen.',
	'rateScale' => 'Die Bewertungen reichen von 1 bis 5 Sternen.',
	'keyDef' => 'Die Stichwortsuche ermöglicht die Suche nach Wörtern die in einem Kommentar hinterlegt wurden.',
	'seeComments' => 'Unten rechts kannst du eine Liste mit Geodatensätzen sehen, zu denen es - passend zu den Filtern - Kommentare gibt. Durch einen Klick gelangst du zur Ansicht mit den Kommentaren.
	 Dir wird zudem angezeigt, wie viele Kommentare es zu den jeweiligen Geodatensätzen gibt. Falls die Filter Kommentare herausselektieren,
	 passt sich diese Zahl an und in der Ansicht mit den Kommentaren werden auch nur noch die selektierten angezeigt.',
	'commentsFurtherInfos' => 'Du siehst zunächst eine Liste mit zum einen allgemeine Kommentaren und zum anderen zu den jeweiligen Layern.
	 Durch Klick auf das jeweilige Element lassen sich die jeweiligen Kommentare anzeigen. Hier siehst du zudem von wem der Kommentar stammt, die Bewertung und den Zeitraum des Kommentares.
	 Rechts kannst du außerdem allgemeine und Metadaten und auf einer Karte die Bounding Box zu dem Geodatensatz sehen.',
	'shareMMM' => 'Sowohl in der Liste mit den Geodatensätzen als auch in der Ansicht mit den Kommentaren zu einem Geodatensatz wirst du dieses Symbol sehen ',
	'shareMMMFurtherInfos' => 'Damit kannst du sowohl deine gefilterte Liste an Geodatensätzen, die Liste an Kommentaren zu einem bestimmten Geodatensatz als auch nur einen einzelnden Kommentar teilen.',

	//variables for \app\views\pages\about.blade.php
	'imprint' => 'Impressum',
	'contact' => 'Kontakt',
	'license' => 'Lizenz',
	'intro' => 'My Meta Maps wurde von Studenten des Instituts für Geoinformatik der WWU Münster entwickelt.',
	'team' => 'Das Team besteht aus:',
	'pubAdress' => 'Adresse der öffentlichen Datenschnittstelle',
	'libs' => 'Genutzte Bibliotheken',

	//variables for \app\views\pages\addCommentFirstStep.blade.php
	'url' => 'URL',
	'createComm' => 'Kommentar erstellen',
	'dataFormat' => 'Datenformat',
	'chooseFormat' => 'Bitte Datenformat wählen',
	'create' => 'Erstellen',

	//variables for \app\views\pages\addCommentSecondStep.blade.php
	'enterData' => 'Daten eingeben',
	'commNoLay' => 'Kommentar keinem Layer zuordnen',
	'title' => 'Titel',
	'freetext' => 'Ihr Kommentar',
	'spatial' => 'Räumliche Zuordnung des Kommentars',
	'timerange' => 'Zeitraum',
	'rating' => 'Bewertung',
	'addMeta' => 'Zusätzliche Metadaten',
	'lang' => 'Sprache',
	'explane' => 'Beschreibung',
	'tags' => 'Tags',
	'copyright' => 'Copyright',

	//variables for \app\views\pages\login.blade.php
	'mailname' => 'E-Mail-Adresse / Benuzername',
	'pw' => 'Passwort',
	'stay' => 'Angemeldet bleiben?',
	
	//variables for \app\views\pages\map.blade.php
	'setFilter' => 'Filter einstellen',
	'reset' => 'Zurücksetzen',
	'metaUse' => 'Metadaten einbeziehen',
	'search' => 'Suchbegriffe',
	'searchTerm' => 'Suchbegriff(e)',
	'startEnd' => 'Wähle Start- und Endzeitpunkt',
	'buffer' => 'Lege einen Umkreis in km fest',
	'rateHigh' => 'Bewertung größer oder gleich ... ?',
	'geodata' => 'Geodatensätze',
	'share' => 'Teilen',

	//variables for \app\views\pages\password.blade.php
	'oldpw' => 'Altes Passwort', 
	'newpw' => 'Neues Passwort',
	'pwagain' => 'Neues Passwort wiederholen',
	'save' => 'Speichern',
	'loginAgain' => 'Sie sind nicht mehr angemeldet. Bitte melden Sie sich erneut an, um Ihr Passwort zu ändern.',

	//variables for \app\views\pages\register.blade.php
	'user' => 'Benutzername',
	'mail' => 'E-Mail-Adresse',
	
	//variables for \app\views\pages\userAccount.blade.php
	'lang' => 'Sprache',
	'loginAgainAcc' => 'Sie sind nicht mehr angemeldet. Bitte melden Sie sich erneut an, um Ihre Profildaten zu ändern.',
	
	//variables for \app\views\pages\showCommentsToGeodata.blade.php
	'noComm' => 'Es liegen keine allgemeinen Kommentare vor.',
	'noCommLayer' => 'Zu diesem Layer liegen noch keine Kommentare vor.',
	'adress' => 'Adresse',
	'dataFormatComm' => 'Datenformat',
	'comments' => 'Kommentare',
	'total' => 'gesamt',
	'map' => 'Karte',
	'metadata' => 'Metadaten',
	'description' => 'Beschreibung',
	'startingDate' => 'Beginn',
	'endingDate' => 'Ende',
	'author' => 'Autor',
	'generalData' => 'Allgemeine Daten',
	'layer' => 'Layer:',
	'permlink' => 'Permalink',
	'unknown' => 'Unbekannt',

	//variables for \app\views\pages\showCommentsToGeodataBit.blade.php
	'anonym' => 'Anonym',
	'rate' => 'Bewertung:',
	'stars' => 'Sterne',
	'notSpec' => 'Keine Angabe',
	'geoData' => 'Geodaten vorhanden',

	//variables for \app\views\pages\show GeodataBit.blade.php
	'noSearch' => 'Es entsprechen leider keine Daten der Suchanfrage.',

	//variables for \app\views\emails\auth\reminder.blade.php
	'pwReset' => 'Passwort zurücksetzen',
	'resetForm' => 'Um das Passwort zurückzusetzen, fülle folgendes Formular aus',
	'expire' => 'Der Link läuft ab in',
	'minutes' => 'Minuten',

	//variables for \app\views\oauth-alert.de.blade.php
	'hint' => 'Hinweis:',
	'extAuth' => 'Sie haben sich über einen externen Anbieter angemeldet. In diesem Zuge haben wir Ihnen einen My Meta Maps-Account eingerichtet, dessen Daten Sie hier ändern können. Ihre Daten beim externen Anbieter bleiben unberührt!',
);
