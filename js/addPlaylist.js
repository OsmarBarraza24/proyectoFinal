var lista = document.getElementById("AgregarPlaylist");
var bandera = false;
lista.addEventListener("click", addForm);

function addForm(){
    if (!bandera) {
        lista.innerHTML = ['<form action = "music.php" method = "post"><input type="text" name="nombrePalylist" class="inputPlaylist"></form>'].join();
        bandera = true;
        
    }
}