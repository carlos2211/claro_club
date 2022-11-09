<script>
    function redirect(){
        window.location.href = "http://clarofans.clarochile.cl/admin/beneficios/mantenedor/Lista_Convenios.php";
    }
</script>

<?php
include("includes/connLocal.php");
$service = $_GET["idconvenio"];
mysql_query("update convenio set status = 0 where id=".$service, $link_local);
mysql_query("update cliente_convenio set status = 0 where idconvenio=".$service, $link_local);
mysql_query("update imagen_convenio set status = 0 where idconvenio=".$service, $link_local);
echo "<script>";
echo "redirect()";
echo "</script>";
?>