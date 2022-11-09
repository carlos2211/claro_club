<?php
session_start();
if (isset($_SESSION["id"])){

    include("includes/connLocal.php");

    include("clases/convenio.class.php");

    $objConv=new convenio($link_local);
    $msg="";

    if($_POST["nombreConvenio"]!="")
        $nombreConvenio=$_POST["nombreConvenio"];
    else
        $msg.="Ingrese nombre convenio<BR>";
    if($_POST["breveDes"]!="")
        $breveDes=$_POST["breveDes"];
    else
        $msg.="Ingrese descripción de convenio<BR>";
    if($_POST["descuento"]!="")
        $descuento=$_POST["descuento"];
    else
        $descuento="";
    if($_POST["url"]!="")
        $url=$_POST["url"];
    /*else
        $msg.="Ingrese url de convenio<BR>";*/
    if($_POST["detalle"]!="")
        $detalle=$_POST["detalle"];
    else
        $msg.="Ingrese detalle de convenio<BR>";
    if($_POST["legal"]!="")
        $legal=$_POST["legal"];
    else
        $msg.="Ingrese condiciones comerciales<BR>";


    if($_POST["categoria"]!="" && $_POST["categoria"]!="0")
        $categoria=$_POST["categoria"];
    else
        $msg.="Seleccione categoría<BR>";
    if($_POST["orden_home"]!="" && $_POST["orden_home"]!="0")
        $categoria=$_POST["categoria"];
    else
        $msg.="Seleccione Orden para home<BR>";
    if($_POST["orden_cat"]!="" && $_POST["orden_cat"]!="0")
        $categoria=$_POST["categoria"];
    else
        $msg.="Seleccione Orden para categoría<BR>";


    if($_POST["vigenciaDesde"]!="")
        $vigenciaDesde=$_POST["vigenciaDesde"];
    else
        $msg.="Seleccione inicio vigencia<BR>";
    if($_POST["vigenciaHasta"]!="")
        $vigenciaHasta=$_POST["vigenciaHasta"];
    else
        $msg.="Seleccione fin de vigencia<BR>";
    if($_POST["sucursal"]!="")
        $sucursal=$_POST["sucursal"];
    /*else
        $msg.="Ingrese sucursal<BR>";*/
    if($_POST["regiones"]!="")
        $regiones=$_POST["regiones"];
    else
        $msg.="Seleccione regiones<BR>";

    if($_POST["alerta"]!="")
        $alerta=$_POST["alerta"];
    if($_POST["oferta"]!="")
        $oferta=$_POST["oferta"];
    if($_POST["modouso"]!="")
        $modouso=$_POST["modouso"];

    //MOSTRAR NOMBRE DE CONVENIO EN DETALLE
    $sin_titulo=0;
    if(isset($_POST["sin_titulo"])){
        $sin_titulo=1;
    }

    //SUCURSALES
    $latitud=$_POST['latitud'];
    $longitud=$_POST['longitud'];
    $nombre_sucursal=$_POST['nombre_sucursal'];

    foreach  ($nombre_sucursal as $key => $value) {
        if(count($nombre_sucursal)==1 && $value=="" &&  $latitud[$key]=="" && $longitud[$key]==""){
            $nombre_sucursal=NULL;
            break;
        }
        if($value==""){
           $msg.="Ingrese nombre de todas las sucursales<BR>"; 
           break;
        }
        if( !$latitud[$key]){
            $msg.="Ingrese latitud de todas las sucursales<BR>"; 
           break;
        }
        if(!$longitud[$key]){
            $msg.="Ingrese longitud de todas las sucursales<BR>"; 
           break;
        }

    }

    $name = $_FILES['imagen']["name"];
    $tmp_name = $_FILES['imagen']["tmp_name"];

    $img_BD = $_POST["imagen_BD"];

    $name2 = $_FILES['imagen2']["name"];
    $tmp_name2 = $_FILES['imagen2']["tmp_name"];

    $img_BD2 = $_POST["imagen_BD2"];


    $id_conv = $_POST["id_conv"];

    if($msg=="")
    {     
         $sql_orden = "SELECT orden_home, orden_cat_destacados, orden_cat_belleza, orden_cat_cursos, orden_cat_entretencion, orden_cat_gastronomia, orden_cat_tiempo, orden_cat_servicios, orden_cat_tiendas,orden_cat_viajes, idcat FROM convenio WHERE id = '$id_conv'";
        $result_orden=mysql_query($sql_orden,$link_local);
        $array_orden = mysql_fetch_assoc( $result_orden);
        $msg = $objConv->update_convenio($nombreConvenio,$breveDes,$descuento,$url,$detalle,$legal,$vigenciaDesde,$vigenciaHasta,$sucursal,$categoria,$name,$tmp_name,$img_BD,$name2,$tmp_name2,$img_BD2,$id_conv,$regiones,$alerta,$oferta,$modouso,$latitud,$longitud,$nombre_sucursal,$sin_titulo);

       
        
        //$detalle = "<p>".$detalle."</p>";
        $promocion = "";

        //CAMBIAR ORDEN HOME
        if($array_orden['orden_home']!= $_POST['orden_home'] ){
            if($array_orden['orden_home']>$_POST['orden_home']){
                $sql = "UPDATE convenio set orden_home=orden_home+1 where orden_home >=".$_POST['orden_home']."  AND  orden_home < ".$array_orden['orden_home'];
                 $result=mysql_query($sql,$link_local);
            }
            else{
                $sql = "UPDATE convenio set orden_home=orden_home-1 where orden_home <=".$_POST['orden_home']."  AND  orden_home > ".$array_orden['orden_home'];
                 $result=mysql_query($sql,$link_local);
            }
            $sql="UPDATE convenio set orden_home=".$_POST['orden_home']." Where id=".$id_conv; 
            $result=mysql_query($sql,$link_local);
        }
        //FIN CAMBIAR ORDEN HOME

        $cat_conv['306']='destacados';
        $cat_conv['307']='belleza';
        $cat_conv['308']='cursos';
        $cat_conv['309']='entretencion';
        $cat_conv['310']='gastronomia';
        $cat_conv['311']='tiempo';
        $cat_conv['312']='tiendas';
        $cat_conv['313']='servicios';
        $cat_conv['314']='viajes';

        $orden_cat="orden_cat_".$cat_conv[$array_orden['idcat']];
        if($array_orden['idcat']!=$_POST["categoria"]){ //si cambia la categoría
            
            //Se elimina del orden de categoría anterior
            $sql = "UPDATE convenio set $orden_cat=$orden_cat-1 where $orden_cat >".$array_orden[$orden_cat]." AND idcat=".$array_orden['idcat'];
            $result=mysql_query($sql,$link_local);
            $sql="UPDATE convenio set $orden_cat=NULL Where id=".$id_conv; 
            $result=mysql_query($sql,$link_local);

            //Se agrega al orden de categoria nueva
            $orden_cat="orden_cat_".$cat_conv[$_POST["categoria"]];
            $sql = "UPDATE convenio set $orden_cat=$orden_cat+1 where $orden_cat >=".$_POST['orden_cat']." AND idcat=".$_POST["categoria"];
            $result=mysql_query($sql,$link_local);
            $sql="UPDATE convenio set $orden_cat=".$_POST['orden_cat']." Where id=".$id_conv; 
            $result=mysql_query($sql,$link_local);
        }
        else{
           
            if($_POST['orden_cat']!= $array_orden[$orden_cat]){
               
                if($array_orden[$orden_cat]>$_POST['orden_cat']){
                $sql = "UPDATE convenio set $orden_cat=$orden_cat+1 where $orden_cat >=".$_POST['orden_cat']."  AND  $orden_cat < ".$array_orden[$orden_cat]." AND idcat=".$array_orden['idcat'];
                 $result=mysql_query($sql,$link_local);
                }
                else{
                    $sql = "UPDATE convenio set $orden_cat=$orden_cat-1 where $orden_cat <=".$_POST['orden_cat']."  AND  $orden_cat > ".$array_orden[$orden_cat]." AND idcat=".$array_orden['idcat'];;
                     $result=mysql_query($sql,$link_local);
                }
                $sql="UPDATE convenio set $orden_cat=".$_POST['orden_cat']." Where id=".$id_conv; 
                $result=mysql_query($sql,$link_local);
            }
        }  

        ?>

        <link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" >
        <link rel="shorcut icon" href="img/favicon.ico">
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" ></script>

        <body>
        <div align="center">
            <br><br>
            <br><br>
            <div class="container">
                <div class="jumbotron">
                    <h2>Convenio Modificado con Exito!</h2>
                    <h4><a href="http://clarofans.clarochile.cl/admin/beneficios/descuento_detalle.php?id=<?php echo $id_conv ?>" target="_blank">Vista Previa</a></h4>
                    <button type="button" class="btn btn-primary btn-md" onClick="self.location.href='Lista_Convenios.php'">Aceptar</button>
                </div>
            </div>
        </div>
        </body>
    <?php }else{ ?>
        <link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" >
        <link rel="shorcut icon" href="img/favicon.ico">
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" ></script>

        <body>
        <div align="center">
            <br><br>
            <br><br>
            <div class="container">
                <div class="jumbotron">
                    <h2>ERROR!</h2>
                    <h4><?php echo $msg ?></h4>
                    <p><button type="button" class="btn btn-primary btn-md" onClick="self.location.href='Modificar_Convenio.php?idconvenio=<?php echo $id_conv ?>'">Volver</button><br><br></p>
                </div>
            </div>
        </div>
        </body>
    <?php }
}else{
    header ("Location: Login.php");
}
?>