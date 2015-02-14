<?php

include('../../login/isLogin.php');
require_once('../../../dll/config.php');
extract($_POST);

if (!$mysqli = getConectionDb()) {
    echo "{failure:true, message: 'Error: No se ha podido conectar a la Base de Datos.<br>Compruebe su conexión a Internet.'}";
} else {

    $coord = explode(";", $coord);
    $area = substr($area, 0, strlen($area) - 4);
    function coneccion() {if (!$mysqli = getConectionDb()) {} else {return $mysqli;}}
    
    function pasosInsersion($geocerca, $cbxEmpresasV, $desc_geo, $area, $listVehiGeos, $coord) {
//        //Extracción de ID      
        $sql = "SELECT MAX(ID_GEOCERCA) AS M FROM GEOCERCAS";
        $result1 = coneccion()->query($sql);
        $myrow = $result1->fetch_assoc();
        $idGeo = $myrow["M"];
        $idGeo++;
        $descripcionG=utf8_decode($desc_geo);
        //Inserción de GeoCerca. Datos iniciales
        $consultaSql2 = " INSERT INTO GEOCERCAS(id_geocerca,id_empresa, geocerca, descripcion, area)
         VALUES($idGeo, '$cbxEmpresasV', '$geocerca', '$descripcionG', $area) ";
        coneccion()->query($consultaSql2);
////     
//        //Vinculación de Vehículos
        $vehVector = explode(",", $listVehiGeos);
        for ($i = 0; $i < count($vehVector); $i++) {
            //Extracción ID de vehículo según ID de equipo
            $consultaSql3 = "INSERT INTO geocerca_vehiculos (id_geocerca,id_vehiculo)
                VALUES($idGeo, $vehVector[$i])";
            coneccion()->query($consultaSql3);
        }
        //Vinculación de Puntos a la GeoCerca
        for ($i = 0; $i < count($coord); $i++) {
            $xy = explode(",", $coord[$i]);
            $consultaSql4 = "INSERT geocerca_puntos(id_geocerca,orden ,latitud, longitud)
                VALUES($idGeo," . ($i + 1) . " ,$xy[1], $xy[0])";
            coneccion()->query($consultaSql4);
        }
        return 1;
    }

    $est = pasosInsersion($geocerca, $cbxEmpresasV, $desc_geo, $area,$listVehiGeos, $coord);
    if ($est == 0) {
        echo "{success:false}";
    } else {
        echo "{success:true}";
    }
}
  

