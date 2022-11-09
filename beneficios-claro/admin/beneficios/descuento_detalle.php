<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set ('America/Santiago');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$id = (isset($_GET["id"])) ? $_GET["id"] : "";

if ($id != ""){
    include("nav/global.php");

    $glob = new globales;

    $cuerpo = $glob->trae_datos("".$glob->local."descuento_detalle_mantenedor.php?token=ZGVzY3VlbnRvX2RldGFsbGUucGhw&id=".$id);

    $detalle_convenio=json_decode($cuerpo, TRUE);
    if ($detalle_convenio['mensaje'] != "error id" && $detalle_convenio!=NULL) { 
        $url=NULL;
        if(isset($detalle_convenio['sucursales'])){
            $url=1;
        }
        elseif($detalle_convenio['url']!=""){
            $detalle_convenio['sucursales']="";
            $sub=substr ($detalle_convenio['url'],0,4);
            if($sub!='http'){
                $url='http://'.$detalle_convenio['url'];
            }
            else{

                $url= $detalle_convenio['url'];
            }
            

        }
        else{
            $detalle_convenio['sucursales']="";
        }
    ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html lang="es-CL">
        <head>

            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-TVGSCZP');</script>
            <!-- End Google Tag Manager -->

            <title>Beneficios | Claro Chile</title>
            <!-- Meta -->
            <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
            <meta http-equiv="Content-Language" content="es">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <!-- Meta Responsive -->
            <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
            <!-- Meta SEO -->
            <meta name="Title" content="Clarochile">
            <meta name="description" content="Clarochile" />

            <meta name="distribution" content="global">
            <meta name="author" content="Claro Chile">
            <meta name="Googlebot-News" content="noindex, nofollow">
            <meta name="googlebot" content="noindex, nofollow">
            <meta name="robots" content="noindex, nofollow">
            <meta name="robots" content="noimageindex">
            <meta name="googlebot" content="unavailable_after: 27-Mar-19 20:16:16 CLST">
            <meta name="google" content="notranslate" />
            <!-- STYLE -->
            <link rel="stylesheet" href="assets/css/flexslider.css">
            <link rel="stylesheet" href="assets/css/detalle.css">
            <link rel="stylesheet"  href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
            
           
        </head>

        <body>

            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TVGSCZP"
                              height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->

            <div class="box-container">
                <?php if(isset($detalle_convenio["imagen2"])){
                    $imagen_conv=$detalle_convenio["imagen2"];
                }
                else{
                    $imagen_conv=$detalle_convenio["imagen"];
                }
                ?>
                <div class="box" id="box">

                    <?php if($detalle_convenio['alerta']!=""){ ?>
                        <div class="ribbon-aviso">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h3><?php echo $detalle_convenio['alerta']; ?></h3>
                        </div>
                    <?php } ?>
                    
                    <div class="contrast">
                        <div class="namewrap">
                            <?php if(!$detalle_convenio['sin_titulo']){ ?>
                                <h1 id="nombre_desc"><?php echo $detalle_convenio['nombre']; ?></h1>
                            <?php } ?>
                            <p><?php echo $detalle_convenio['modouso']; ?></p>
                            <!--<p>Envía
                                <strong>CLINICASKIN</strong> al
                                <strong>2582</strong>
                            </p>-->
                        </div>
                        <?php if($detalle_convenio['descuento']!=""){ ?>
                            <div class="offerwrap">
                                <h1><?php echo $detalle_convenio['descuento']; ?></h1>
                                <p></p>
                            </div>
                        <?php } ?>
                        
                    </div>
                    <?php if($detalle_convenio['oferta']!=""){ ?>
                        <div class="ribbon">
                            <span><?php echo $detalle_convenio['oferta']; ?></span>
                        </div>
                    <?php } ?>
                    
                </div>

                <div class="desc-box">
                    <?php
                    if(isset($detalle_convenio['detalle'])){
                        echo $detalle_convenio['detalle'];                            
                    }
                    ?>

                    <?php
                        /*FORMATEAR FECHA*/

                        $dia=date("d", strtotime($detalle_convenio['vigencia']));

                        $mes_espanol=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                        $mes_numero=array("01","02","03","04","05","06","07","08","09","10","11","12");
                        $mes=str_replace($mes_numero,$mes_espanol,date("m", strtotime($detalle_convenio['vigencia'])));

                        $anio=date("Y", strtotime($detalle_convenio['vigencia']));

                        $fecha_escrita = $dia." de ".$mes." de ".$anio;

                        /*FIN FORMATEAR FECHA*/
                    ?>
                    <h3>Vigencia hasta el  <?php echo $fecha_escrita?>.</h3>
                    <?php 
                        $legales = explode("\n", $detalle_convenio['importante']);
                        echo "<h6>";
                        foreach ( $legales as $key => $value) {
                             echo $value."<br/>";
                        }
                        echo "</h6>";
                    ?>

                    
                </div>
                <div class="map-display" style="display:none;">
                    <div class="map-left" id="map_canvas">
                    </div>
                    <div class="map-list">
                        <div class="list-header" >
                                <i class="fas fa-map-marked-alt"></i>
                                <h3 >Lista de sucursales</h3>
                        </div>
                        <?php foreach ($detalle_convenio['sucursales'] as $key => $value) { ?>
                            <div class="list-location"  id="sucursal<?php echo $key; ?>" data-lat="<?php echo $value['latitud']; ?>" data-lng="<?php echo $value['longitud']; ?>" onclick="center_map('sucursal<?php echo $key; ?>');">
                                <i class="fas fa-map-marker-alt"></i>
                                <h3><?php echo $value['nombre']; ?></h3>
                            </div>
                        <?php } ?>

                       
                    </div>
                </div>
                 <?php if($url==NULL){ ?>
                <div class="display-none">   
                    <h3>
                    </h3>         
                </div>
                <?php }
                else{ ?>
                <div class="sucursales-display">                   
                    <h3>VISITAR SITIO O SUCURSAL
                        <i class="far fa-arrow-alt-circle-down"></i>
                    </h3>                   
                </div>
                <?php } ?>
                

                <div class="rrss-container">
                    <a href="https://www.facebook.com/clarochile" target="_blank"><i class="fab fa-facebook-square"></i></a>
                    <a href="https://twitter.com/clarochile_cl" target="_blank"><i class="fab fa-twitter-square"></i></a>
                    <a href="https://www.youtube.com/user/canalclarochile" target="_blank"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <script src="assets/js/tippy.all.min.js"></script>
            <script src="assets/js/jquery-2.2.4.min.js"></script>
            <script defer src="assets/js/jquery.flexslider.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
            <script>
                /*$(function() {
                    $(window).resize(function() {
                        
                        if ($(this).width() < 768) {
                            
                           $("#box").css('background-image',"url('http://claro.mobext.cl/dev/claro/claro_club/beneficios/mantenedor/upload/<?php echo $imagen_conv; ?>')no-repeat");
                        } else { 
                            
                             $("#box").css('background-image',"url('http://claro.mobext.cl/dev/claro/claro_club/beneficios/mantenedor/upload/<?php echo $imagen_conv; ?>')top center /cover");
                        }
                    });
                });*/
            </script>

            <script>
                

                var url="<?php echo $url; ?>";
                var map=null;

                var suc = <?php echo json_encode($detalle_convenio['sucursales']); ?>;
      
                $(window).load(function () {
                    if($(window).width() >= 591){
                        $(".box").css("background","url('https://digital.clarochile.cl/beneficios-claro/admin/beneficios/mantenedor/upload/<?php echo $imagen_conv; ?>') top center / cover");
                        //$(".box").css("background-size","cover");
                         $(".box").css("background-size","contain");
                          $(".box").css("background-repeat","no-repeat");
                          $(".box").css("width","100%");
                          $(".box").css("height"," 0");
                          $(".box").css("padding-top","23.64%");


                    }
                   
                    if($(window).width() <= 590){
                        $(".box").css("background","url('https://digital.clarochile.cl/beneficios-claro/admin/beneficios/mantenedor/upload/<?php echo $detalle_convenio["imagen"]; ?>')top center / cover");
                        //$(".box").css("background-size","center / cover");
                   
                          $(".box").css("background-size","contain");
                          $(".box").css("background-repeat","no-repeat");
                          $(".box").css("width","100%");
                          $(".box").css("height"," 0");
                          $(".box").css("padding-top","37.64%");
                          $("#nombre_desc").hide();


                    }
                    
                    $('.flexslider').flexslider({
                        animation: "fade",
                        autoPlay: true,
                        controlNav: true,
                        directionNav: true
                    });
                    $('.sucursales-display').click(function() {
                        if(url=='1' || url==1){
                             $('.map-display').slideToggle();
                            $('html,body').animate({
                                scrollTop: $(".map-display").offset().top
                            }, 550);
                        }
                        else if(url!='' && url!=null){
                            window.open(url, '_blank');
                        }

                       
                    });
                    //Pre-fetch imágenes grandes
                    // $.preloadImages = function () {
                    //     for (var i = 0; i < arguments.length; i++) {
                    //         $("<img />").attr("src", arguments[i]);
                    //     }
                    // }
                    // $.preloadImages(
                    //     "assets/img/header-bg-1.png", );

                });
       
           //MAP
            /*var markers = [];//some array
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0; i < markers.length; i++) {
             bounds.extend(markers[i].getPosition());
            }

            map.fitBounds(bounds);*/

            jQuery(document).ready(function($) {

                
                function initializeMap() {
                    var myLatlng = new google.maps.LatLng(-33.4460571,-70.651364);
                    var myOptions = {
                      zoom: 15,
                      center: myLatlng,
                      styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}],
                      mapTypeId: google.maps.MapTypeId.ROADMAP
                      };
                    return myOptions;  

                     
                }

                var myOptions = initializeMap();
                
                if(url=='1' || url==1){
                    map = new google.maps.Map($("#map_canvas").get(0), myOptions);
                    $.each(suc, function(key, value) {
                            
                          var LatLngDestino = new google.maps.LatLng({lat: parseFloat(value.latitud), lng: parseFloat(value.longitud)});
                          map.setCenter(LatLngDestino);
                          //map.setZoom(17);
                          
                          marker = new google.maps.Marker({
                            position: LatLngDestino             
                          });
                          
                          marker.setMap(map);  


                    });

                    var LatLngDefault = new google.maps.LatLng({lat: -33.4681269, lng: -70.6875167});
                      map.setCenter(LatLngDefault);         
                      map.setZoom(11);  
                    }

                
            });
            function center_map(id){
                    var lat   = $('#'+id).attr('data-lat');
                    var lng   = $('#'+id).attr('data-lng');
                    var LatLngDestino = new google.maps.LatLng({lat: parseFloat(lat), lng: parseFloat(lng)});
                    map.setCenter(LatLngDestino);
                     map.setZoom(16);

                }
            

            </script>
            </script>
         <script src="https://maps.google.com/maps/api/js?sensor=true&signed_in=true&key=AIzaSyCj8G5gxIf2QmJCZLhdiK2JrrpQ1KZyQEs&libraries=places"></script>
            
        </body>
        </html>
<?php
    }else{
        echo "Error al acceder a este beneficio.";
    }
}else{
    echo "Se requiere ID de convenio.";
}
?>