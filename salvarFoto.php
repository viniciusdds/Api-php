<?php
$con = mysqli_connect("localhost","root","","testes")or die("<h1>Falha na comunicação com banco</h1>");
$action = $_POST['action'];

if($action == "salvar"){
	$url = 'http://10.101.2.100:4747/cam/1/frame.jpg';

	$ch = curl_init($url);

	$fp = fopen("pasta1/".date("dmYHis").".jpg", 'wb');

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	$retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	fclose($fp);

	if($retCode == 200){
		
		$file = "pasta1/".date("dmYHis").".jpg";
		$ip = $_POST['ip'];
		$insert = mysqli_query($con,"insert into testes.snapshot (image,usuario) values ('".$file."','".$ip."')")or die("erro no insert ".mysqli_error($con));
		if($insert){
			$select1 = mysqli_query($con,"select id from testes.snapshot where usuario = '".$ip."' and image = '".$file."' order by id desc limit 1")or die("erro no select 1 ".mysqli_error($con));
			$result1 = mysqli_fetch_array($select1);
			echo $result1['id'];
		}
	}else{
		echo "Erro ao salvar";
	}
}

if($action == "buscar"){
	//print_r($_POST);
	
	$ip = $_POST['ip'];
	$id = $_POST['id'];
	$date = date('Y-m-d');
	
	$select2 = mysqli_query($con,"select image from testes.snapshot where usuario = '".$ip."' and date(data) = '".$date."' and id = ".$id."")or die("erro no select 2 ".mysqli_error($con));
	
	$rows = mysqli_num_rows($select2);
	
	if($rows > 0){
		$result2 = mysqli_fetch_array($select2);
		echo $result2['image'];
		
	}else{
		echo "0";
	}
}

if($action == "load"){
	//print_r($_POST);
	
	$ip = $_POST['ip'];
	$date = date('Y-m-d');
	
	$select3 = mysqli_query($con,"select image from testes.snapshot where usuario = '".$ip."' and date(data) = '".$date."' ")or die("erro no select ".mysqli_error($con));
	
	$rows = mysqli_num_rows($select3);
	
	if($rows > 0){
		while($result3 = mysqli_fetch_array($select3)){
			echo $result3['image'].";";
		}
	}else{
		echo "0";
	}
}

   