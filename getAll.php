<?php
//Quelle: http://stefan-draeger-software.de/blog/android-app-mit-mysql-datenbank-verbinden/

//Konfiguration einlesen
require_once("Conf.php");
//Datenbankverbindung aufbauen
$connection = mysqli_connect($host,$user,$passwort,$datenbank);
//auf Fehler prüfen
if (mysqli_connect_errno()) {
    echo mysql_errno($connection) . ": " . mysql_error($connection). "\n";
    die();
}

	//Wir lesen alle Informationen zu allen Studien aus.
	$sqlStmt = "SELECT * FROM `studies`;";
  //Abfrage vorbereiten
	$result =  mysqli_query($connection,$sqlStmt);
  //Es soll ein JSON-Array mit den Studien als Objekten erzeugt werden, dieses wird durch [] begrenzt.
  echo "[";
  $erste = true;
  //alles auslesen
	while ($zeile = mysqli_fetch_array( $result)){
    //Objekte sind durch , getrennt; wir wollen kein leeres Objekt erzeugen.
    if(!$erste)
      echo ",";
  		//Felder auslesen und als JSON Key-Value-Paar ausgeben.
      $out = "{\"id\":\"".$zeile["id"]."\", \"description\":\"".$zeile["description"]."\", \"status\":\"";
	  if($zeile["status"] == 1)
		  $out = $out."true";
	  else
		  $out = $out."false";
	  
	  $out = $out."\", \"name\":\"".$zeile["study_name"]."\", \"creator_id\":\""
        .$zeile["creator_id"]."\", \"created\":\"".$zeile["created"]."\", \"api_key\":\"".$zeile["api_key"]."\", \"mqtt_password\":\"".$zeile["mqtt_password"]."\"}";
    echo $out;
	if($erste)
      $erste = false;
    }
    //Ende des JSON
    echo "]";
	//Verbindung schließen
	closeConnection($connection);



//Verbindung schließen.
function closeConnection($connection){
  mysqli_close($connection);
}
?>
