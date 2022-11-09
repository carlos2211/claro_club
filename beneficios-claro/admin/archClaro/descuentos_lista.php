<?php ini_set('display_errors', 1); ?> 
<?php

/**
*DESPCRIPCION:          Trae categorias de descuentos
*CLUB:                  Club Claro Chile
*FECHA CREACION:        05/05/2016.
*FECHA MODIFICACION:    05/05/2016.
*AUTOR MODIFICACION:    Felipe Polanco.
*MOTIVO MODIFICACION:   Mostrar categorias de descuentos
*
**/

include("class/conectar.class.php");
include("class/control.class.php");


$club = 35 ; //Club 

$control = new control();

$control->club=$club;

  $result = $control->descuentos_categorias();


?>
<section class="beneficios">
<?php

    foreach ($result as $key => $value) {  

    $control->id_categoria = $value["id"];
    $result_aux=$control->descuentos_lista();
?>   
    <section id="<?=utf8_encode($value["class"])?>">
        <?php
            if (!empty($result_aux)){

                    foreach ($result_aux as $keyaux => $valueaux){

                ?>
                      <a href="">
                            <article class="<?=utf8_encode($value["class"])?>">
                                <div class="img">
                                    <img src="http://servicios.fidelis.cl/mc/adm/modsis/img_blob.php?id=<?=$valueaux["idarchivo_imagen"]?>">
                                </div>
                                <div class="info">
                                    <p><b><?=trim(utf8_encode($valueaux['descuento']))?></b> <?=trim(utf8_encode($valueaux['descripcion']))?></p>
                                    <span>Desde tu celular, envía "CINE" al 2290</span>
                                </div>
                            </article>
                        </a>      
                    
                <?php
                    }
            }
        ?>
    </section>
<?php
 }
?>
</section>
            <!--

            <ul class="menu">
                <li class="destacados activo"><a href="#destacados-club">Destacados</a></li>
                <li class="belleza"><a href="#belleza">Belleza & Wellness</a></li>
                <li class="cursos"><a href="#cursos">Cursos</a></li>
                <li class="entretencion"><a href="#entretencion">Entretención</a></li>
                <li class="gastronomia"><a href="#gastronomia">Gastronomía</a></li>
                <li class="tiempo-libre"><a href="#tiempo-libre">Tiempo Libre</a></li>
                <li class="tiendas"><a href="#tiendas">Tiendas</a></li>
                <li class="servicios"><a href="#servicios">Servicios</a></li>
                <li class="viajes"><a href="#viajes">Viajes</a></li>
            </ul>

            -->