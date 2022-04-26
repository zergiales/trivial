<html>
    <head>
            <title>Editar preguntas</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- estilos -->
    <link rel="stylesheet" href="assets/css/style-editar.css" />
</head>
<body>
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
    <div class="formulario">
        <form action="Editar.php" method="post">
         <p>¿De qué categoría va a ser?</p>
           <select name="categoria" id="categoria">
               <option value="vacio"></option>
               <option value="ciencias">Ciencias</option>
               <option value="historia">Historia</option>
               <option value="arte">Arte</option>
               <option value="deportes">Deportes</option>
           </select>
                <p>Pregunta:</p>
                <input type="text" name="pregunta" placeholder="inserte pregunta" minlength="1" id="pregunta"></br>
                <p>Respuestas:</p>
                <input type='text' name='respuesta0' placeholder="respuesta a" minlength="1" id="opcion"><br/>
                <input type='text' name='respuesta1'placeholder="respuesta b" minlength="1" id="opcion"><br/>
                <input type='text' name='respuesta2' placeholder="respuesta c" minlength="1" id="opcion"><br/>
                <input type='text' name='respuesta3' placeholder="respuesta d" minlength="1" id="opcion"><br/>
                    <p>Elija la respuesta correcta:</p>
                <div>
                    <input type="radio" name="validar" value="A" id="correcto">
                    <label for="A">A</label>
                    <input type="radio" name="validar" value="B" id="correcto">
                    <label for="B">B</label>
                    <input type="radio" name="validar" value="C" id="correcto">
                    <label for="C">C</label>
                    <input type="radio" name="validar" value="D" id="correcto">
                    <label for="D">D</label>    
                </div>    
                <p>Inserte el url de una imagen:</p>
                <input type="url" name="imagen" placeholder="url"></br>
        <div class="botones">
            <input type="submit" value="Guardar" name="Guardar" onclick="return fcomprobar()">
            <input type="reset" value="Limpiar" name="Limpiar" >
        </form>
        <form action="Index.php">
            <input type="submit"  value="Volver" name="Volver">
        </form>
        </div>
        <?php
    session_start();
             //cuando le demos a boton guardar, se te guarda todo en el array
            if (isset($_REQUEST['Guardar'])) {        
           
                
//ARRAY DONDE METEREMOS TODA LA INFORMACION
                $preguntadelformulario=array( $_REQUEST['categoria'],$_REQUEST['pregunta'],$_REQUEST['respuesta0'],$_REQUEST['respuesta1'],$_REQUEST['respuesta2'],$_REQUEST['respuesta3']);

                //condicion para que tenga una imagen por defecto si el usuario no inserta nada
                if ($_REQUEST['imagen']=="") {
                    $_REQUEST['imagen']="https://ep01.epimg.net/verne/imagenes/2020/04/18/articulo/1587206313_842027_1587214073_noticia_normal.jpg";
                    array_push($preguntadelformulario,$_REQUEST['imagen']);//le decimos que meta una por defecto en el caso que el usario noquiere metar ninguna
                }
                else {
                    array_push($preguntadelformulario,$_REQUEST['imagen']);//lo metemos en el array la que ha insertado el usuario
                }
                
                //en funcion de lo que el usuario decida , tendra una variable booleana $correcta (true=correcto, false=falso)
                
                switch ($_REQUEST['validar']) {//usamos un switch para que cuando el usuario diga que opcion es correcta entre en alguno de los siguiente casos
                    case 'A':
                            $_REQUEST['validar']=$_REQUEST['respuesta0'];//las guardamos  como tal,sin numeros,asi es mas facil a la hora se saber la correcta en el juego
                            array_push($preguntadelformulario,$_REQUEST['validar']); //lo añadimos en el array preguntas del formulario
                        break;//le decimos que no lea mas cuando se haya ejecutado las ordenades
                    case 'B':
                            $_REQUEST['validar']=$_REQUEST['respuesta1'];
                            array_push($preguntadelformulario,$_REQUEST['validar']);                         
                        break;
                    case 'C':
                            $_REQUEST['validar']=$_REQUEST['respuesta2'];
                            array_push($preguntadelformulario,$_REQUEST['validar']);                         
                        break;
                    case 'D':
                            $_REQUEST['validar']=$_REQUEST['respuesta3'];
                            array_push($preguntadelformulario,$_REQUEST['validar']);                         
                        break;
                                                                               
                    default:
        
                        break;
                }
                //ARCHIVO CSV

                $archivoleer=fopen('preguntas.csv','r');#abrimos el archivo en modo lectura
                $preguntas=[];
                while(!feof($archivoleer)){//hasta que no llegue al final der archoleer que no finalice el bucle
                    $preguntas[]=fgetcsv($archivoleer,0,';');//le decimos que obtenga una línea de un puntero al fichero  y la analiza en busca de campos CSV
                }//en cuanto a parametros ponemos 0 que es e estandar y le decimos que nos separe los elemntos por un delimitador ;
                fclose($archivoleer);//cierre del csv
                array_push($preguntas,$preguntadelformulario);
                $archivoescribir=fopen('preguntas.csv','w');
                foreach ($preguntas as $filas) {
                    @fputcsv($archivoescribir,$filas,";");#ignora errores con @
                }
                fclose($archivoescribir);

            }
        ?>
        </div>
        <script>
        //funcion de javaScript que  lo que haces es que si no rellenasalguno de los campos para crear la pregunta no te deja guardarla
        //ANOTACION:la de la imagen no la ponemos porque es opcional 
            function fcomprobar(){
                if (document.getElementById("categoria").value == "vacio" || document.getElementById("pregunta").value == "" || 
                document.getElementById("opcion").value == "" || document.getElementById("pregunta").value == "correcto" ) {
                 alert("faltan huecos por rellenar");
                 return false;   
                }
            }
        </script>
</body>
</html>