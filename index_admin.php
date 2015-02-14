<?php
include("dll/config.php");
include("php/login/isLogin.php");
if (!isset($_SESSION["IDROLKARVIEW"])) {
    header("Location: index.php");
} else {
    if ($_SESSION["IDROLKARVIEW"] == 2) {
        header("Location: index_empresas.php");
    } else if ($_SESSION["IDROLKARVIEW"] == 3) {
        header("Location: index_propietario.php");
    }
}
?>
<!DOCTYPE html>
<html lang='es'>
    <head>
        <meta charset="utf-8">
        <?php echo "<title>" . $site_title . "</title>" ?>
        <link rel="shortcut icon" href="<?php echo $site_icon ?>" type="image/x-icon">

        <link rel="stylesheet" type="text/css" href="extjs-docs-5.0.0/extjs-build/build/packages/ext-theme-neptune/build/resources/ext-theme-neptune-all.css">
        <link rel="stylesheet" type="text/css" href="extjs-docs-5.0.0/extjs-build/build/examples/shared/example.css">
        <link rel="stylesheet" type="text/css" href="css/principal.css"/>

        <script type="text/javascript" src="extjs-docs-5.0.0/extjs-build/build/ext-all.js"></script>
        <script type="text/javascript" src="extjs-docs-5.0.0/extjs-build/build/packages/ext-theme-neptune/build/ext-theme-neptune.js"></script>
        <script type="text/javascript" src="extjs-docs-5.0.0/extjs-build/build/examples/shared/examples.js"></script>
        <script type="text/javascript" src="extjs-docs-5.0.0/extjs-build/build/examples/shared/options-toolbar.js"></script>

        <script type="text/javascript">
<?php
echo "               
                var idCompanyKarview = '" . $_SESSION["IDCOMPANYKARVIEW"] . "';
                var userKarview = '" . $_SESSION["USERKARVIEW"] . "';
                var idRolKarview = " . $_SESSION["IDROLKARVIEW"] . ";
                var personKarview = '" . $_SESSION["PERSONKARVIEW"] . "';
                var correo = '" . $_SESSION["EMAIL"] . "';
                ";
?>
        </script>
        <script type="text/javascript" src="js/ext-lang-es.js"></script>
        <script type="text/javascript" src="js/requerid/functions.js"></script>
        <script type="text/javascript" src="js/roles/admin.js"></script>

        <script type="text/javascript" src="js/requerid/stores.js"></script>

        <script type="text/javascript" src="js/administracion/ventanaPersonal.js"></script>
        <script type="text/javascript" src="js/administracion/ventanaEmpresa.js"></script>
        <script type="text/javascript" src="js/administracion/ventanaVehiculo.js"></script>
        <script type="text/javascript" src="js/administracion/ventanaUsuario.js"></script>
        <script type="text/javascript" src="js/administracion/ventanaEquipos.js"></script>


        <script type="text/javascript" src="js/interface/report/recorridoGeneral.js"></script>
        <script type="text/javascript" src="js/interface/report/ventanaSimbologia.js"></script>

        <!--Dependencias-->

        <!--Mapa-->
        <script src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
        <script type="text/javascript" src="http://openlayers.org/api/OpenLayers.js"></script>
        <script type="text/javascript" src="js/mapa.js"></script>
        <!--Fin Mapa-->
    </head>
</html>
