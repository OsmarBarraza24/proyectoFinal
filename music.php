<?php 
session_start();
include('conexion/conexionBd.php');

if(isset($_GET["nombrePlaylist"])){
  $queryInsertPlaylist = sprintf("INSERT INTO playlist (nombre, idUsuario) VALUES ('%s', '%d')",
  mysql_real_escape_string(trim($_GET["nombrePlaylist"])),
  mysql_real_escape_string(trim($_SESSION["idUsuario"]))
  );

  $resQueryInsertPlaylist = mysql_query($queryInsertPlaylist, $conexionBd) or die ("No se ejecutó el query en la base de datos");
  if($resQueryInsertPlaylist){
    header("Location:music.php");
  }
}

 $queryGetPlaylist = sprintf("SELECT id, nombre FROM playlist WHERE idUsuario =".$_SESSION["idUsuario"]);
 $resQueryGetPlaylist = mysql_query($queryGetPlaylist, $conexionBd) or die ("No se ejecutó el query en la base de datos");

if(isset($_POST["logout"])){
    session_destroy();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
    crossorigin="anonymous">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/music.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="audioplayerengine/initaudioplayer-1.css">
    <title>¡Escucha tu música!</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-nav">
    <a class="navbar-brand" href="#"><i class="fab fa-spotify fa-2x"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img style="float:left" class="img" src= <?php echo'"imagenes/'.$_SESSION["userFoto"].'"'?> alt=""> 
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <form action="music.php" method="post">
          <input type="submit" name="logout">
          </form>
        </div>
      </li>
    <div > </div>
    <p style="color:white; padding-top:16px;margin-left:10px;"> <?php echo $_SESSION["userNombreCompleto"]  ?></p>
      </ul>
      <ul class="nav navbar-nav navbar-center">
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2 input-field" type="search" placeholder="Buscar" aria-label="Search">
        </form>
      </ul>
    </div>
  </nav>
   <div class="scrollbar" id="style-2">
      <div id="bottom">
        <div class="container-bot">
          <h6 class="name">TU BIBLIOTECA</h6>
            <ul>
               <li><i class="fas fa-music"></i> Canciones favoritas</li>
              <li><i class="fas fa-male"></i> Artistas favoritos</li>
            </ul> 
            <h6>TUS PLAYLIST</h6> 
            <ul>
              <?php while($playListDetail = mysql_fetch_assoc($resQueryGetPlaylist)){?>
                <li><a href="#"><?php echo $playListDetail["nombre"]?></a></li>
              <?php }?> 
              <li id = "AgregarPlaylist"><i class="fas fa-plus-circle"></i>Añadir playlist</li>
            </ul>       
        </div>
      </div>
   </div>
  </div>
    </div>
  </div>


  <div class="footer">
      <div id="amazingaudioplayer-1" style="display:block;position:relative;width:80%;height:164px;margin:0px auto 0px;float:rigth">
          <ul class="amazingaudioplayer-audios" style="display:none;">
              <li data-artist="" data-title="Love of Lesbian - Contraespionaje (Lyric Video)" data-album="" data-info="" data-image="" data-duration="313">
                  <div class="amazingaudioplayer-source" data-src="audios/Contraespionaje.mp3" data-type="audio/mpeg" ></div>
              </li>
              <li data-artist="" data-title="Love of Lesbian - El poeta Halley (Lyric Video)" data-album="" data-info="" data-image="" data-duration="445">
                  <div class="amazingaudioplayer-source" data-src="audios/ElPoetaHalley.mp3" data-type="audio/mpeg" ></div>
              </li>
              <li data-artist="Love of lesbian" data-title="Planeador" data-album="Psiconautas" data-info="A" data-image="" data-duration="337">
                  <div class="amazingaudioplayer-source" data-src="audios/Planeador.mp3" data-type="audio/mpeg" ></div>
              </li>
          </ul>      
      </div>
</div>

</div>

<script src="audioplayerengine/jquery.js"></script>
    <script src="audioplayerengine/amazingaudioplayer.js"></script>
<script src="audioplayerengine/initaudioplayer-1.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="js/addPlaylist.js"></script>
</body>
</html>