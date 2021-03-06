<?php

/* DATOS DE MI APLICACION */
$site_title = "PoliciaNacional";
$site_icon = "img/sindicato.PNG";

function getConectionDb() {
    /* DATOS DE MI SERVIDOR */
    $db_name = "karviewdb";
    $db_host = "localhost";
    $db_user = "root";
    $db_password="";

    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);
    if ($mysqli->connect_errno) {
        echo "{failure: true, msg: 'Falló tu conexión con MySQL: (" . $mysqli->connect_errno . ")ç " . $mysqli->connect_error . "'}";
    } else {
             return ($mysqli->connect_errno) ? false : $mysqli;
    }
}



function allRows($result) {
    $vector = null;
    $pos = 0;

    while ($myrow = $result->fetch_row()) {
        $fila = "";
        for ($i = 0; $i < count($myrow); $i++) {
            $infoCampo = $result->fetch_field_direct($i);
            $fila[$infoCampo->name] = $myrow[$i];
        }
        $vector[$pos] = $fila;
        $pos++;
    }
    return $vector;
}
