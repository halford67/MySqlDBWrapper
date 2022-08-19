<?php

//error_reporting(0);
//mysqli_report(MYSQLI_REPORT_OFF);

require_once ('../php-bin/config.php') ;
require_once('MySqlDBWrapper.php') ;

$MyDB = new MySqlDBWrapper($DBHOST, $DBUSER, $DBPWRD, $DBNAME) ;

// Test x INSERT
$MyDB->Query("INSERT IGNORE INTO TEST SET ebookFormat='PIPPO6'") ;
echo "affected_rows: " . $MyDB->AffectedRows . "\n" ;

// Test x UPDATE
$MyDB->Query("UPDATE TEST SET IsAmazonCompatible=1") ;
echo "affected_rows: " . $MyDB->AffectedRows . "\n" ;

// Test x DELETE
$MyDB->Query("DELETE FROM TEST WHERE ebookFormat='PIPPO6'") ;
echo "affected_rows: " . $MyDB->AffectedRows . "\n" ;

// Test x SELECT (1)
$result = $MyDB->Query("SELECT ebookFormat, IsAmazonCompatible, ContainsMetadata FROM TEST") ;
echo "affected_rows: " . $MyDB->AffectedRows . "\n" ;

while ($row = $result->fetch_assoc()) {
    $ebookFormat = $row['ebookFormat'] ; echo "ebookFormat: $ebookFormat\n" ;
    $IsAmazonCompatible = $row['IsAmazonCompatible'] ; echo "IsAmazonCompatible: $IsAmazonCompatible\n" ;
    $ContainsMetadata = $row['ContainsMetadata'] ; echo "ContainsMetadata: $ContainsMetadata\n" ;
}
$result->close();

// Test x SELECT (2)
$MyDB->Query("SELECT userid FROM users") ;
echo "affected_rows: " . $MyDB->AffectedRows . "\n" ;

// Test metodo CountTableRows
echo "Totale righe in tabella: " . $MyDB->CountTableRows("ebooks") . "\n";

// Disconnessione dal DB
if ($MyDB->Disconnect())
    echo "Connessione DB chiusa correttamente\n" ;
else
    echo "Errore in chiusura connessione!\n" ;

?>
