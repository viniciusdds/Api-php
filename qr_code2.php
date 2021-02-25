<!DOCTYPE html>
<html xmls="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<title>QrCode PHP</title>
</head>

	<body>
		<h1>Criando QrCode no PHP</h1>
		<?php 
			$aux = 'qr_img/php/qr_img.php?';
			$aux .= 'd=http://10.101.10.22:8080/camera/AuroraEadi.apk&';
			//$aux .= 'd=http://10.101.10.22:8080/camera/WebView.apk&';
			$aux .= 'e=H&';
			$aux .= 's=2&';
			$aux .= 't=P&';
		?>
		<img src="<?php echo $aux; ?>";
	</body>
</html>