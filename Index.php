<html>
  <head>
    <title>Inicio</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- estilos -->
    <link rel="stylesheet" href="assets/css/style.css" />

  </head>
  <body>

    <div class="container-Titulo">
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
      <div class="ranking">
          <h5>TOP PLAYERS</h5>
          <?php
          session_start();
          /**
           * Comentario realizado con DocBlocks(formato de comentario)
           * @author sergio <zergiosanchezlopez@email.com>
           * @param  mixed $user[] donde guardamos los users y su puntuacionde la partida
           * @return mixed  donde devuelve el nombre y la puntuacion
           * 
           */


          //opercion similar a cuando leemos las preguntas del csv
          //en este caso son usuarios
          $users = [];
          //funcion para leer los usuario que habiamos escrito en el csv al haber finalizado la partida
          function fLeerUsuarios($users){
            $fichero = fopen("usuarios.csv", "r");
            if (!empty($fichero)) {//si el fichero no esta vacio que ejecute el bucle while
              //funcionamiento similar al feof que hemos utilizado antes
              
              while ($linea = fgetcsv($fichero, 0, ";")) {
                    $nombre = $linea[0];//le deciimos que en la linea en la posicion 0 estan los nombres
                    $puntos = (int)$linea[1];//le decimos que en la linea en la posicion 1 estan los puntos que ha obtenido
                    //Clave => nombre , Valor => puntos
                    $users[$nombre] = $puntos;
              }
            }
            return $users;
          }
           $users = fLeerUsuarios($users);
          /* Funcion que ordena descendente el array de usuarios por puntos */
          function fOrdenarUsuarios($users){
              arsort($users); //ordena por valor (puntos) manteniendo claves
              return $users;    
          }
          $users=fOrdenarUsuarios($users);          

          $index = 0; //Se sacan los 5 mejores jugadores (nombre -> puntos)
          foreach ($users as $key => $value) {
            if (4 < $index) {
              break;//PARA QUE SALGA
            }
            echo "<p>".($index+1) ."º "."{$key} {$value} puntos.</p>";
            $index++;//incrementamos el contador una vez imrpimamos por pantalla
          }
          ?>
      </div>
      <div class="botones">
          <form action="Editar.php" method="post">  
            <button type="submit" value="editar" id="edit">EDITAR</button>
          </form>
          <form action="login.html" method="post">
            <button type="submit" value="jugar" id="game"/>JUGAR</button>
          </form>
    </div>
  
</div>



   <?php

        unset($_SESSION['usuario']);
        unset($_SESSION['mezclarPreguntas']);
        unset($_SESSION['ContadorRacha']);
        unset($_SESSION['contadorFallos']);
        unset($_SESSION['puntos']);
        unset($_SESSION['contadorTematicaC']);


        
  ?>
  </body>
</html>
