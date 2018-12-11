var lista = document.getElementById("AgregarPlaylist");

lista.addEventListener("change", addForm());

function addForm(){
    lista.innerHTML = ['<form action = "music.php" method = "post"><input type="text" name="nombrePalylist"></form>'].join();
}