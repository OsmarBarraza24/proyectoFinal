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
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/music.css">
    <link rel="stylesheet" href="css/navbar.css">
    <title>¡Escucha tu música!</title>
</head>
<body>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-nav">
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
          <a class="dropdown-item" href="updateuser.php">Editar perfil</a>
          <?php if($_SESSION["userPlan"] == "ADMINISTRADOR"){?>
          <a class="dropdown-item" href="adminadd.php">Opciones de administrador</a>
          <?php }?>
          <form action="music.php" method="post">
          <input class="logout" type="submit" name="logout" value="Cerrar sesión">
          </form>
        </div>
      </li>
    <p style="color:white; padding-top:16px;margin-left:10px;"> <?php echo $_SESSION["userNombreCompleto"]  ?></p>
      </ul>
      <ul class="nav navbar-nav navbar-center">
        <form class="form-inline my-2 my-lg-0" action="MusicSearch.php" method="get">
          <input class="form-control mr-sm-2 input-field" type="text" name = "busqueda" placeholder="Buscar" aria-label="Search">
            <input type="hidden" value = "2" name="Si">
        </form>
      </ul>
    </div>
  </nav>
   <div class="scrollbar" id="style-2">
      <div id="bottom">
        <div class="container-bot">
            <h6>TUS PLAYLIST</h6> 
            <ul>
              <?php while($playListDetail = mysql_fetch_assoc($resQueryGetPlaylist)){?>
                <li><a href="#"><?php echo $playListDetail["nombre"]?></a></li>
              <?php }?> 
              <li id ="AgregarPlaylist"><i class="fas fa-plus-circle"></i>Añadir playlist</li>
            </ul>       
        </div>
      </div>
   </div>
  </div>
    </div>
  </div>
  
<div class="music-container">
<?php 
  $queryGetPlaylistCreador = "SELECT usuario.id, usuario.nombre, usuario.apellidos, playlist.id, playlist.nombre FROM playlist 
  INNER JOIN usuario ON playlist.idUsuario = usuario.id WHERE idUsuario=25";

  $resQueryGetPlaylistCreador = mysql_query($queryGetPlaylistCreador, $conexionBd) or die ("No se pudo realizar el query del inner join de playlist con usuario");

  while($playlistData = mysql_fetch_array($resQueryGetPlaylistCreador)){
  
?>
<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="https://pngimage.net/wp-content/uploads/2018/06/notas-musicales-hd-png-2.png" alt="Card image cap">
  <div class="card-body">
    <a href=<?php echo'"audioplayer.php?playlist='.$playlistData[3].'"'?>><h5 style="color:#087CA7;" class="card-title"><?php echo $playlistData[4]?></h5></a>
    <p style="color:#087CA7" class="card-text"><?php echo $playlistData[1]." ".$playlistData[2]?></p>
  </div>
</div>

<?php }?>

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