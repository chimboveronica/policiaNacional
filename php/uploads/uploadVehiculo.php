<?php 
$target_path = "../../img/uploads/vehiculos/";
$target_path = $target_path . basename( $_FILES['imageFile']['name']); 
if(move_uploaded_file($_FILES['imageFile']['tmp_name'],$target_path)) {
	// echo "El archivo ". basename( $_FILES['imageFile']['name']). " ha sido subido";
	echo "{success:true, img:'".basename( $_FILES['imageFile']['name'])."'}";
} else{
	echo "{failure:true}";
}


//$target_path = "../../img/uploads/vehiculos/";
//$target_path = $target_path . basename( $_FILES['imageFile']['name']); 
//if(move_uploaded_file($_FILES['image']['tmp_name'],$target_path)) {
////	 echo "El archivo ". basename( $_FILES['image']['name']). " ha sido subido";
//	echo "{success:true, img:'".basename( $_FILES['image']['name'])."' }";
//} else{
//	echo "{failure:true}";
//}
//
//?>
