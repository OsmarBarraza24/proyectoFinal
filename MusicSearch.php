<?php 
session_start();
include('conexion/conexionBd.php');

if(isset($_GET["busqueda"])){
  $busqueda = "%".mysql_real_escape_string(trim($_GET["busqueda"]))."%";

  $queryBuscarCancion = "SELECT id, nombre FROM cancion WHERE nombre LIKE '$busqueda'";

  $resQueryBuscarCancion = mysql_query($queryBuscarCancion, $conexionBd) or die ("No se realizó la busqueda");


  
}
if(isset($_GET["idPlaylist"])){
  $queryInsertRelPlaylist = sprintf("INSERT INTO rel_cancion_playlist (idCancion, idPlaylist) VALUES (%d, %d)",
    mysql_real_escape_string(trim($_GET["idCancion"])),
    mysql_real_escape_string(trim($_GET["idPlaylist"]))
  );

  $resQ = mysql_query($queryInsertRelPlaylist, $conexionBd) or die("Nelson");

  if($resQ){
    header("Location:music.php");
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
    crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/music.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Busqueda</title>
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
          <a class="dropdown-item" href="adminadd.php">Opciones de administrador</a>
          <form action="music.php" method="post">
          <input class="logout" type="submit" name="logout" value="Cerrar sesión">
          </form>
        </div>
      </li>
    <p style="color:white; padding-top:16px;margin-left:10px;"> <?php echo $_SESSION["userNombreCompleto"]  ?></p>
      </ul>
      <ul class="nav navbar-nav navbar-center">
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2 input-field" type="search" placeholder="Buscar" aria-label="Search">
        </form>
      </ul>
    </div>
  </nav>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-xs-12">
              <h2>Busqueda de canciones</h2>
          </div>
      </div>   
  </div>

  <div class="carajo">
  <ul>
    <?php 
    if(isset($_GET["busqueda"])){
    while($dataCancion = mysql_fetch_assoc($resQueryBuscarCancion)){?>
    <li>
      <?php 
      echo $dataCancion["nombre"];
 
      ?>
    </li>
    <div style="margin-left:80%;" class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" style="width:100px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Playlist
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <?php
         
         $queryObtenerPlaylist = "SELECT id, nombre FROM playlist WHERE idUsuario=". $_SESSION["idUsuario"];

         $resQueryObtenerPlaylist = mysql_query($queryObtenerPlaylist, $conexionBd) or die("No se pudieron obtener las playlist");
   
        while($playlistData = mysql_fetch_assoc($resQueryObtenerPlaylist)){
      ?>
    <a class="dropdown-item" href=<?php echo '"MusicSearch.php?idPlaylist='. $playlistData["id"] .'&idCancion='. $dataCancion["id"] .'"'?>><?php echo $playlistData["nombre"]?></a>
      <?php }?>
  </div>
  </div>
  
  <?php }} ?>
    </ul>
  </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>