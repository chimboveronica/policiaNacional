<?php

extract($_POST);

include ('../../../dll/config.php');


if (!$mysqli = getConectionDb()) {
    echo "{success:false, message: 'Error: No se ha podido conectar a la Base de Datos.<br>Compruebe su conexión a Internet.'}";
} else {

    $consultaSql = "SELECT v.vehiculo, v.placa, V.id_vehiculo, concat(p.apellidos,' ',p.nombres) persona
    FROM  karviewdb.geocerca_vehiculos vg, karviewdb.vehiculos v, karviewdb.geocercas g, karviewdb.personas p
    WHERE vg.id_geocerca ='$idGeo' AND g.id_empresa = '$empresa'
    AND vg.id_vehiculo = v.id_vehiculo AND vg.id_geocerca = g.id_geocerca AND v.id_persona= p.id_persona";


    $result = $mysqli->query($consultaSql);
    $haveData = false;
    if ($result->num_rows > 0) {
        $haveData = true;
        $objJson = "datos : [";

        while ($myrow = $result->fetch_assoc()) {
            $objJson .= "{
                text:'" . $myrow["placa"] . "_" . utf8_encode($myrow["vehiculo"]) . "_" . utf8_encode($myrow["persona"]) . "',
                id:" . $myrow["id_vehiculo"] . ",
                placa:'" . $myrow["placa"] . "'  
            },";
        }
        $objJson .="]";
    }
    if ($haveData) {
        echo "{success: true,$objJson}";
    } else {
        echo "{failure: true, msg: 'Problemas al Obtener los  Datos'}";
    }

    $mysqli->close();
}