<?php

include('../../login/isLogin.php');
include ('../../../dll/config.php');

extract($_POST);

if (!$mysqli = getConectionDb()) {
    //echo "Error: No se ha podido conectar a la Base de Datos.";
    echo "{success:false, message: 'Error: No se ha podido conectar a la Base de Datos.'}";
} else {
    $idEmpresa = $_SESSION["IDCOMPANYKARVIEW"];
    $idPersona = $_SESSION["IDPERSONKARVIEW"];
    $idRol = $_SESSION["IDROLKARVIEW"];
    if ($idRol == 4) {
        $consultaSql = "SELECT emp.id_empresa, vh.id_vehiculo,emp.empresa, eq.id_equipo,emp.empresa, eq.equipo, vh.placa, vh.vehiculo, vh.icono,
                        sky.sky_evento, sky.id_sky_evento, udskps.velocidad, udskps.fecha_hora_ult_dato, udskps.latitud, udskps.longitud,udskps.rumbo, udskps.direccion
                        FROM karviewdb.empresas emp, karviewdb.equipos eq, karviewdb.vehiculos vh, 
                        karviewdb.sky_eventos sky, karviewdb.ultimo_dato_skps udskps
                        where udskps.id_sky_evento=sky.id_sky_evento 
                        and udskps.id_equipo= eq.id_equipo and eq.id_equipo=vh.id_equipo and vh.id_empresa=emp.id_empresa and vh.id_persona='$idPersona';"
        ;
    } else {

        $consultaSql = "SELECT emp.id_empresa, vh.id_vehiculo ,emp.empresa, eq.id_equipo,eq.equipo, vh.placa, vh.vehiculo, vh.icono, 
                        sky.sky_evento,sky.id_sky_evento, udskps.velocidad, udskps.fecha_hora_ult_dato,udskps.latitud, udskps.longitud,udskps.rumbo, udskps.direccion
                        FROM karviewdb.empresas emp, karviewdb.equipos eq, karviewdb.vehiculos vh, 
                        karviewdb.sky_eventos sky, karviewdb.ultimo_dato_skps udskps
                        where udskps.id_sky_evento=sky.id_sky_evento 
                        and udskps.id_equipo= eq.id_equipo and eq.id_equipo=vh.id_equipo and vh.id_empresa=emp.id_empresa and vh.id_empresa in ($listCoop);";

        $consultaSql2 = "SELECT emp.id_empresa, vh.id_vehiculo ,emp.empresa, eq.id_equipo,eq.equipo,vh.vehiculo,vh.icono,dcel.fecha_hora_ult_dato,dcel.latitud, dcel.longitud
                        FROM karviewdb.empresas emp, karviewdb.equipos eq, karviewdb.vehiculos vh, karviewdb.ultimo_dato_celulares dcel
                        where dcel.id_equipo= eq.id_equipo  and eq.id_equipo=vh.id_equipo and vh.id_empresa=emp.id_empresa and vh.id_empresa in ($listCoop);";
    }
    $result = $mysqli->query($consultaSql);
    $objJson = "dataGps : [";
    if ($result->num_rows > 0) {
        while ($myrow1 = $result->fetch_assoc()) {
            $objJson .= "{"
                    . "idVehiculo:'".$myrow1["id_vehiculo"] . "',"
                    . "idCoop: '" . $myrow1["id_empresa"] . "',"
                    . "company: '" . utf8_encode($myrow1["empresa"]) . "',"
                    . "idEqp: '" . $myrow1["id_equipo"] . "',"
                    . "equipo: '" . $myrow1["equipo"] . "',"
                    . "vehiculo: '" . $myrow1["vehiculo"] . "',"
                    . "placa: '" . $myrow1["placa"] . "',"
                    . "nombre_vehiculo: '" . utf8_encode('VH: ' . $myrow1["placa"] . ' - ' . $myrow1["vehiculo"]) . "',"
                    . "lat: " . $myrow1["latitud"] . ","
                    . "lon: " . $myrow1["longitud"] . ","
                    . "fec: '" . $myrow1["fecha_hora_ult_dato"] . "',"
                    . "vel: " . $myrow1["velocidad"] . ","
                    . "rumbo: " . $myrow1["rumbo"] . ","
                    . "dir: '" . utf8_encode($myrow1["direccion"]) . "',"
                    . "evt: '" . utf8_encode($myrow1["sky_evento"]) . "',"
                    . "icono: '".$myrow1["icono"]. "'"
                    . "},";
        }
    }
    $result2 = $mysqli->query($consultaSql2);
    if ($result2->num_rows > 0) {
        while ($myrow2 = $result2->fetch_assoc()) {
            $objJson .= "{"
                    . "idVehiculo:'".$myrow2["id_vehiculo"] . "',"
                    . "idCoop: '" . $myrow2["id_empresa"] . "',"
                    . "company: '" . utf8_encode($myrow2["empresa"]) . "',"
                    . "idEqp: '" . $myrow2["id_equipo"] . "',"
                    . "equipo: '" . $myrow2["equipo"] . "',"
                    . "vehiculo: '" . $myrow2["vehiculo"] . "',"
                    . "placa: '".utf8_encode('CEL:'. $myrow2["vehiculo"])."',"
                    . "nombre_vehiculo: '" . utf8_encode('CEL:'. $myrow2["vehiculo"]) . "',"
                    . "lat: " . $myrow2["latitud"] . ","
                    . "lon: " . $myrow2["longitud"] . ","
                    . "fec: '" . $myrow2["fecha_hora_ult_dato"] . "',"
                    . "vel: '" . "NO". "',"
                    . "rumbo: '" ."NO" . "',"
                    . "dir: '" ."NO". "',"
                    . "evt: '" . "N0" . "',"
                    . "icono: '".$myrow2["icono"] . "'"
                    . "},";
        }
    }
    $objJson .="]";
     echo "{success: true, $objJson }";
    $mysqli->close();
}
