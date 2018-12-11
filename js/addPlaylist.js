var lista = document.getElementById("AgregarPlaylist");
var texto = document.getElementById("txtAdd");
var bandera = false;
lista.addEventListener("click", addForm);
texto.addEventListener("lostpointercapture", quitForm);

function addForm(){
    if (!bandera) {
        lista.innerHTML = ['<form action = "music.php" method = "get"><input type="text" name="nombrePlaylist" class="inputPlaylist"></form>'].join();
        lista.innerHTML = ['<form action = "music.php" method = "post"><input type="text" name="nombrePlaylist" class="inputPlaylist" id = "txtAdd"></form>'].join();
        bandera = true;
        
    }
}

$(document).ready(function () {
    if (!$.browser.webkit) {
        $('.wrapper').html('<p>Sorry! Non webkit users. :(</p>');
    }
});
function quitForm(){
    lista.innerHTML = ['<i class="fas fa-plus-circle"></i>Añadir playlist'].join();
    bandera = false;
}
