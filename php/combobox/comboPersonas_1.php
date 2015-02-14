<?php

include('../login/isLogin.php');
include ('../../dll/config.php');
extract($_GET);

if (!$mysqli = getConectionDb()) {
    echo "{success:false, msg: 'Error: No se ha podido conectar a la Base de Datos.<br>Compruebe su conexión a Internet.'}";
} else {
    $userKarview = $_SESSION["USERKARVIEW"];
    $idEmpresa = $_SESSION["IDCOMPANYKARVIEW"];
    $idPersona = $_SESSION["IDPERSONKARVIEW"];
    $idRol = $_SESSION["IDROLKARVIEW"];

   
        $consultaSql = "SELECT cedula,nombres,apellidos,correo, celular FROM karviewdb.personas where id_genero=1;";
   

    $result = $mysqli->query($consultaSql);
    $mysqli->close();

    if ($result->num_rows > 0) {
        $objJson = "{personas: [";
        while ($myrow = $result->fetch_assoc()) {
            $objJson .= "{"
                    . "cedula:'" . $myrow["cedula"] . "', "
                    . "nombres:'" . utf8_encode($myrow["nombres"]) . "', "
                    . "celular:'" . utf8_encode($myrow["celular"]) . "', "
                    . "apellidos:'" . utf8_encode($myrow["apellidos"]) . "', "
                    . "correo:'" . utf8_encode($myrow["correo"]) . "', "
                    . "}, ";
        }

        $objJson .="]}";
        echo $objJson;
    } else {
        echo "{success:false, msg: 'No hay datos que obtener'}";
    }
}
