<?php

include('../../login/isLogin.php');
require_once('../../../dll/config.php');
extract($_POST);

if (!$mysqli = getConectionDb()) {
    echo "{failure:true, message: 'Error: No se ha podido conectar a la Base de Datos.<br>Compruebe su conexión a Internet.'}";
} else {
    $coord = explode(";", $coord);
    $area = substr($area, 0, strlen($area) - 4);

    function coneccion() {
        if (!$mysqli = getConectionDb()) {
            
        } else {
            return $mysqli;
        }
    }

    //    idGeo:1
//coord:
//area:
//vehiculolist:45
//vehiculolist:46
//idempresa:
//geocerca:geoe
//areaGeocerca:8153118.15
//cbxEmpresasV:2
//desc_geo:Descripción de la Geocerca...
//listVehiGeos:45,46


    function pasosInsersion($idGeo, $geocerca, $cbxEmpresasV, $desc_geo, $area, $listVehiGeos, $coord) {
        $idemp;
        if ($cbxEmpresasV === 'KRADAC') {
            $idemp = 1;
        } else if ($cbxEmpresasV === 'COOPMEGO') {
            $idemp = 2;
        } else {
            $idemp = $cbxEmpresasV;
        }
//   
        if ($area == "") {
            
        } else {
            $consultaSql2 = "UPDATE GEOCERCAS SET area='$area'
         WHERE id_geocerca='$idGeo'";
            coneccion()->query($consultaSql2);
        }

        if ($geocerca == "") {
            
        } else {
            $consultaSql2 = "UPDATE GEOCERCAS SET geocerca='$geocerca'
         WHERE id_geocerca='$idGeo'";
            coneccion()->query($consultaSql2);
        }

        if ($desc_geo == "") {
            
        } else {
            $descripcionG = utf8_decode($desc_geo);
            $consultaSql2 = "UPDATE GEOCERCAS SET descripcion='$descripcionG'
         WHERE id_geocerca='$idGeo'";
            coneccion()->query($consultaSql2);
        }

////     Eliminar vehiculos existentes
        $consultaSql = "DELETE FROM geocerca_vehiculos WHERE id_geocerca='$idGeo'";
        coneccion()->query($consultaSql);
//        //Vinculación de nuevos Vehículos
        $vehVector = explode(",", $listVehiGeos);
        for ($i = 0; $i < count($vehVector); $i++) {
            //Extracción ID de vehículo según ID de equipo
            $consultaSql3 = "INSERT INTO geocerca_vehiculos (id_geocerca,id_vehiculo)
                VALUES($idGeo, $vehVector[$i])";
            coneccion()->query($consultaSql3);
        }

        if (count($coord) > 1) {
            ////     Eliminar de Puntos a la GeoCerca
            $consultaSql = "DELETE FROM geocerca_puntos WHERE id_geocerca='$idGeo'";
            coneccion()->query($consultaSql);
            //Vinculación de Puntos a la GeoCerca
            for ($i = 0; $i < count($coord); $i++) {
                $xy = explode(",", $coord[$i]);
                $consultaSql4 = "INSERT geocerca_puntos(id_geocerca,orden ,latitud, longitud)
                VALUES($idGeo," . ($i + 1) . " ,$xy[1], $xy[0])";
                coneccion()->query($consultaSql4);
            }
        }

        $consultaSql0 = "UPDATE GEOCERCAS SET id_empresa='$cbxEmpresasV'
         WHERE id_geocerca='$idGeo'";
        coneccion()->query($consultaSql0);
        return 1;
    }

    $est = pasosInsersion($idGeo, $geocerca, $cbxEmpresasV, $desc_geo, $area, $listVehiGeos, $coord);
    if ($est == 0) {
        echo "{success:false}";
    } else {
        echo "{success:true}";
    }
}
  

