<?php 
session_start();
include("conexion/conexionBd.php");
if(isset($_GET["playlist"])){
    $queryObtenerPlaylistCancionAlbumArtista = "SELECT playlist.id, playlist.nombre, cancion.id, cancion.nombre
    FROM rel_cancion_playlist
    INNER JOIN cancion on rel_cancion_playlist.idCancion = cancion.id
    INNER JOIN playlist on rel_cancion_playlist.idPLaylist = playlist.id
    WHERE rel_cancion_playlist.idPlaylist =
    ". $_GET["playlist"];

    $resQueryObtenerPlaylistCancion = mysql_query($queryObtenerPlaylistCancionAlbumArtista, $conexionBd) or die ("Nelson brother");
    $dataPlaylistCancion = mysql_fetch_array($resQueryObtenerPlaylistCancion);
    
    $queryObtenerAlbum = "SELECT album.id, album.nombre
    FROM rel_cancion_album
    INNER JOIN album on rel_cancion_album.idAlbum = album.id
    WHERE rel_cancion_album.idCancion =
    ". $dataPlaylistCancion[2];
    $resQueryObtenerAlbum = mysql_query($queryObtenerAlbum, $conexionBd) or die ("Nel plomo");
    $dataAlbum = mysql_fetch_array($resQueryObtenerAlbum);

    $queryObtenerArtista = "SELECT artista.id, artista.nombre
    FROM album
    INNER JOIN artista on album.idArtista = artista.id
    WHERE album.id =
    ". $dataAlbum[0];

    $resQueryObtenerArtista = mysql_query($queryObtenerArtista, $conexionBd) or die ("Nelson mandela");


}else {
    header("Location:music.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width">
    <title>Reproductor</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Insert to your webpage before the </head> -->
    <script src="audioplayerengine/jquery.js"></script>
    <script src="audioplayerengine/amazingaudioplayer.js"></script>

    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="css/music.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="audioplayerengine/initaudioplayer-1.css">
    <script src="audioplayerengine/initaudioplayer-1.js"></script>
    
    <!-- End of head section HTML codes -->
    
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
<div style="margin-top:5rem;">
    
    <!-- Insert to your webpage where you want to display the audio player -->
    <div id="amazingaudioplayer-1" style="display:block;position:relative;width:100%;height:auto;margin:0px auto 0px;">
        <ul class="amazingaudioplayer-audios" style="display:none;">
            <li data-artist="" data-title="Love of Lesbian - Bajo el Volcán (Videoclip Oficial)" data-album="" data-info="" data-image="" data-duration="344">
                <div class="amazingaudioplayer-source" data-src="audios/BajoElVolcan.mp3" data-type="audio/mpeg"></div>
            </li>
        </ul>

    </div>
    <!-- End of body section HTML codes -->
   
</div>
</body>
</html>