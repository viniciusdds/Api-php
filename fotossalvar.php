<?php
/*
    function base64_to_jpeg( $base64_string, $output_file ) {
        $ifp = fopen( $output_file, "wb" ); 
        fwrite( $ifp, base64_decode( $base64_string) ); 
        fclose( $ifp ); 
        return( $output_file ); 
    }       
    $imagem = str_replace('data:image/png;base64,','',$_POST['imagem']);        
    base64_to_jpeg($imagem, "pasta1/foto1.jpg");        
    echo json_encode(array('imagem' => 1));
	
	define('UPLOAD_DIR', 'images/');
	$img = $_POST['imagem'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';
	$success = file_put_contents($file, $data);
	print $success ? $file : 'Unable to save the file.';
*/

$data = $_POST["image"];
list($type, $data) = explode(';',$data);
list($base, $data) = explode(',',$data);
$data = base64_decode($data);
file_put_contents('images/image.png', $data);

//$url = 'http://10.101.2.100:8080/photo.jpg';
//$img = 'pasta1/foto.png';
//file_put_contents($img, file_get_contents($url));

//$ch = curl_init('https://image.freepik.com/fotos-gratis/hrc-tigre-siberiano-2-jpg_21253111.jpg');
/*
$ch = curl_init('http://10.101.2.100:8080/photo.jpg');
$ch1 = fwrite( $fp, base64_decode($ch));
$fp = fopen('images/foto.jpg', 'wb');  
 
curl_setopt($ch1, CURLOPT_FILE, $fp);
curl_setopt($ch1, CURLOPT_HEADER, 0);
curl_exec($ch1);
curl_close($ch1);
fclose($fp);
*/