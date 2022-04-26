<html>
    <head>
    <title>jugar</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- estilos -->
    <link rel="stylesheet" href="assets/css/style-editar.css" />

    
    </head>
    <body>
<?php
    session_start();
    /**
     * comentarios en docblocks
     * @param  $_SESSION['usuario'] que guarda el request usuario
     * 
     */
    /*SI NO EXISTE*/
    if (!isset($_SESSION['usuario'])) {                    
    $_SESSION['usuario'] =$_REQUEST['usuario'];//usuario que luego guardaremos en el csv(en esta parte aun no se guarda en el csv,solo en la sesion)
    $_SESSION['contador']=0;//contador de las preguntas que vaya haciendo 
    $_SESSION['contadorRacha']=0;//contador de las rachas 
    $_SESSION['contadorFallos']=0;//numero de veces que falla 
    $_SESSION['puntos']=0;//puntuacion  de lo que vayas sacando 
   
    
    //PREGUNTAS
            $archivoleer=fopen('preguntas.csv','r');//abrimos el archivo en modo lectura
            //leer contenido        
            $mezclarPreguntas=[];
            while(!feof($archivoleer)){//este while es que mientras no termines de leer de leer el fichero le vamos a meter cosas
                    $mezclarPreguntas[]=fgetcsv($archivoleer,0,';');

            }
            fclose($archivoleer);//cerramos el archivo

            /*MEZCLAMOS las preguntas*/
            array_pop($mezclarPreguntas);//elimina el elemento de la linea en blanco
            shuffle($mezclarPreguntas);
            $_SESSION['preguntas']=$mezclarPreguntas;//lo metemos en una sesion para que no se pierdan una vez mezcladas
            $_SESSION['contadorTotal'] = count($mezclarPreguntas);//tamaño total de preguntas que lo guardaremos en una sesion
          
    }
    /*SI EXISTE EL USUARIO */
    if (isset($_SESSION['usuario'])) {
     
        //echo"preguntas mezcladas</br>"; PARA VER SI SE MEZCLABAN LAS PREGUNTAS
        
        
        //asignamos a estas variables las opciones
        $opcionA=$_SESSION['preguntas'][$_SESSION['contador']][2];
        $opcionB=$_SESSION['preguntas'][$_SESSION['contador']][3];
        $opcionC=$_SESSION['preguntas'][$_SESSION['contador']][4];
        $opcionD=$_SESSION['preguntas'][$_SESSION['contador']][5];
        $opcionCorrecta=$_SESSION['preguntas'][$_SESSION['contador']][7];#LUGAR DONDE ESTA LA CORRECTA en mezclador preguntas
        $tematica=$_SESSION['preguntas'][$_SESSION['contador']][0];//tematica             
        /*MEZCLAMOS LAS opciones*/
        $opciones=array();
        array_push($opciones,$opcionA,$opcionB,$opcionC,$opcionD);
        shuffle($opciones);
        //echo"opciones mezcladas</br>"; PARA VER SI LAS OPCIONES SE MEZCLABAN
            

            //SI EXISTE LA RESPUESTA QUE ES EL BOTON QUE PULSAMOS AL ELEGIR LA OPCION
            if (isset( $_POST['respuesta'])) {
                $respuesta = $_POST['respuesta'];//asigna por defecto u valor por de fecto de vacio
                
                 $correcta = $_POST['correcta']?? "";//asigna por defecto un valor de vacio

                 //$_SESSION['contadoTematicaD']??"";//al final no se ha utilizado por quen
                 
                 //PUNTUACION Y RACHAS

                 if ($respuesta == $correcta) { 
                     $_SESSION['contadorRacha']++; //Suma a la categoria la respuesta acertada 
                     
                     //la racha de puntos se activa cuando cumplimos la condicion
                     if ($_SESSION['contadorRacha']>=2) {
                         $_SESSION['puntos'] *= 2;//para que vaya sumando la cantidad anterior obtenida
                         echo"entra en el bucle 0";
                         
                        }
                        //para cuando el usuario haya acertado menos de una pregunta
                        if($_SESSION['contadorRacha']<2){
                            $_SESSION['puntos']+= 10;//le sumamos 10 
                        }
                        
                    }
                    //Si no coincide la respuesta con la correcta
                    if($respuesta!=$correcta){
                        $_SESSION['contadorRacha']=0;   //resetamos el contador
                        $_SESSION['contadorFallos']++;//Suma a la categoria la respuesta fallada                      
                    }
                }
            //FINAL DE LA PARTIDA(cuando finalice escribimos en el csv el usuario y la puntuacion)

            //condicion para que cuando llegue al limite nos envie a la pagina de inicio y sume 1000
            if ( $_SESSION['contador'] == $_SESSION['contadorTotal'] ) {
            $_SESSION['puntos']+=1000;//al final de la partida se le suma 1000 siempre 
            //metemos el usuario y la puntuacion dentro del csv al final de la partda una vez haya entrado en la condicion
            $users = [ $_SESSION['usuario'],$_SESSION['puntos'] ];        //metemos en el array los puntos y el usuario
            $meterCSV=fopen('usuarios.csv','a+');//abrimos el csv
            fputcsv($meterCSV,$users,';');//le decimos que meta en el csv y que use de separador ;
            fclose($meterCSV);  //cerramos cvs
        
            /**TE ENVIA DE NUEVO  AL INDEX*/
                header('Location:Index.php');           
            }
        
    }
?>
                <!--estructura html-->
            <div class="container-Titulo" >
        <div class="doradoV">
                  <div class="cajaVerde">T</div>
        </div>
         
        <div class="doradoVi">
                  <div class="cajaFucsia">R</div>
        </div>
        <div class="doradoA">
                  <div class="cajaAzul">I</div>
        </div>
        <div class="doradoN">
                  <div class="cajaNaranja">V</div>
        </div>                 
        <div class="doradoAC">
                  <div class="cajaAzulCurioso">I</div>
        </div> 
        <div class="doradoR">
                  <div class="cajaRoja">A</div>
        </div> 
         <div class="doradoB">
          <div class="cajaB">L</div>
        </div>
    </div>

    <div class="container">
        <h3>BIENVENIDO 🙂 <?=$_SESSION['usuario']?></h3>
        <h1>Pregunta <?=$_SESSION['contador']?></h1>
        <h2>CATEGORIA: <?=$tematica?></h2>
        <h5>RACHA DE ACERTADAS: <?=$_SESSION['contadorRacha']?></h5>
        <h5>FALLOS: <?=$_SESSION['contadorFallos']?></h5>
        <h5>PUNTOS: <?=$_SESSION['puntos']?></h5>
        
            <div class="imagenes">
                <img src=<?=$_SESSION['preguntas'][$_SESSION['contador']][6]?> width="500px" height="300px">
            </div>
            <div class="pregunta">
                <?= $_SESSION['preguntas'][$_SESSION['contador']][1]?>
            </div>
            <div class="respuestas"> 
            <form action="" method="post">
                <button value="<?=$opciones[0]?>" name="respuesta" onclick="submit"><?=$opciones[0]?></button>
                <button value="<?=$opciones[1]?>" name="respuesta" onclick="submit"><?=$opciones[1]?></button>
                <button value="<?=$opciones[2]?>" name="respuesta" onclick="submit"><?=$opciones[2]?></button>
                <button value="<?=$opciones[3]?>" name="respuesta" onclick="submit"><?=$opciones[3]?></button>
                <input type="hidden" name="correcta" value="<?=$opcionCorrecta?>">
            </form>
            <button type="button"  onclick="window.location='index.php'" value="Volver">volver</button>
            </div>
            <?php 
            $_SESSION['contador']++;//contador para que podamos pasar las preguntas
            
            //para que sume puntos    
            // $_SESSION['puntos']+=10;      

            //Se comprueba si llega el valor de la respuesta, si no por defecto es vacio
            //var_dump($_POST);
            //echo "</br>".$opcionCorrecta;
            
            
            //PARA LA TEMATICA DE DEPORTES(al final no lo hice por tematica porque  era muy largo sino)
            /*if ($tematica=="deportes") {
                $_SESSION['contadorTematicaD']++;
                //Si el jugador llega a las cinco repuestas acertadas gana la categoria y no mostrará mas preguntas de ella
                if ($_SESSION['contadorTematicaD']===5) {
                    $_SESSION['puntos']+=1000; 
                    $users = [ $_SESSION['usuario'],$_SESSION['puntos'] ];        
                     $meterCSV=fopen('usuarios.csv','a+');
                    fputcsv($meterCSV,$users,';');
                    fclose($meterCSV);  
        
                     //TE ENVIA DE NUEVO 
                //header('Location:Index.php'); 
                }
            }*/
            ?>
        </div>  
 <?php

   
     
?>

    </body>
</html>
