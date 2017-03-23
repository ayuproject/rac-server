<?php
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		exit();
	}
	$nama = $_POST['nama'];
	$deskripsi = $_POST['deskripsi'];
	$img_des = $_POST['img_app_des'];

	echo "nama : ". $nama ."<br>";
	echo "Deskripsi : ". $deskripsi ."<br>";
	for ($i = 0; $i < sizeof($img_des); ++$i) {
		echo "img_des ". $i .": ". $img_des[$i] ."<br>";	
	}
?>