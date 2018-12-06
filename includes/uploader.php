<?php 
$target_path = "";
if($_POST['tipo'] == "imagenes"){
$target_path = "imagenes/";
}else{
    header("Location:index.php");
}
$msg = " ";
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

$uploadedfileload=true;

$uploadedfile_size=$_FILES['uploadedfile']['size'];
$uploadedFileType = $_FILES['uploadedfile']['type'];

echo $_FILES["uploadedfile"]["name"]. "<br>" . $uploadedFileType;


if ($uploadedfile_size>1000000){

$msg = $msg . "El archivo es mayor que 1MB, debes reduzcirlo antes de subirlo<BR>";

$uploadedfileload=false;

}

if (!($uploadedFileType == "image/jpeg" OR $uploadedFileType =="image/gif")){
    $msg = $msg . " Tu archivo tiene que ser JPG o GIF. Otros archivos no son permitidos<BR>";
    
    $uploadedfileload=false;
}


$file_name=$_FILES["uploadedfile"]["name"];

$add="uploads/$file_name";

if($uploadedfileload){

if(move_uploaded_file ($_FILES["uploadedfile"]["tmp_name"], $add)){
echo " Ha sido subido satisfactoriamente";
}

}else{
    echo $msg;
}

?>