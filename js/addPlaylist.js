var lista = document.getElementById("AgregarPlaylist");
var bandera = false;
lista.addEventListener("click", addForm);
texto.addEventListener("focusout", quitForm);

function addForm(){
    if (!bandera) {
        lista.innerHTML = ['<form action = "music.php" method = "get"><input type="text" name="nombrePlaylist" class="inputPlaylist"></form>'].join();
        bandera = true;
        
    }
}

$(document).ready(function () {
    if (!$.browser.webkit) {
        $('.wrapper').html('<p>Sorry! Non webkit users. :(</p>');
    }
});
