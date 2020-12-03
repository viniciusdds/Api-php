<?php
	$action = $_REQUEST["action"];
	//$action = $_POST["acao"];
	
	$con = mysqli_connect("localhost","root","","loginbase");

	if(!$con){
		die("Falha na conexão: ".mysqli_error($con));
		return;
	}
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////  ACESSO PARA A TELA DE LOGIN //////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if($action == "login"){ 
	
		$usuario = $_REQUEST['usuario'];
		$senha = md5($_REQUEST['senha']);
	
	    $db_data = array();
		
		$sql = mysqli_query($con,"select * from loginbase.new_usuarios_ag where tb_cpf = '".$usuario."' and tb_senha = '".$senha."'");
		$rows = mysqli_num_rows($sql);
		if($rows > 0){
			$db_data['resp'] = "1";
			while($result = mysqli_fetch_array($sql)){
				$db_data[] = $result;
			}
					
			echo json_encode($db_data);
		}else{
			$db_data['resp'] = "0";
			
			echo json_encode($db_data);
		}
		mysqli_close($con);
		return;
	}
	
	if($action == "cadastro"){
		
		$nome    = $_REQUEST['nome'];
		$empresa = $_REQUEST['empresa'];
		$cnpj    = $_REQUEST['cnpj'];
		$documento = $_REQUEST['documento'];
		$senha  = $_REQUEST['senha'];
		$password = md5($senha);
		$email  = $_REQUEST['email'];
		$perfil  = $_REQUEST['perfil'];
		
		$sql = mysqli_query($con,"select * from loginbase.new_usuarios_ag where tb_cpf = '".$documento."'");
		$rows = mysqli_num_rows($sql);
		if($rows == 0){
			$insert = mysqli_query($con,"insert into loginbase.new_usuarios_ag 
													 (
														tb_cnpj,
														tb_empresa,
														tb_nome,
														tb_cpf,
														tb_senha,
														tb_email,
														tb_nivel_usuario,
														senha_decrypt,
														tb_ativado
													 )
													 values
													 (
														'".$cnpj."',
														'".$empresa."',
														'".$nome."',
														'".$documento."',
														'".$password."',
														'".$email."',
														'".$perfil."',
														'".$senha."',
														'0'
													 )");
			
			if($insert){
				//inserido com sucesso
				echo "1";
			}else{
				//erro ao inserir
				echo "0";
			}
		}else{
			//usuário já cadastrado
			echo "2";
		}
		
	}
	
	if($action == "recuperar"){
		//Função para gerar senha
		function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
			$lmin = 'abcdef';
			$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$num = '1234567890';
			$simb = '!@';
			$retorno = '';
			$caracteres = '';
			$caracteres .= $lmin;
			if ($maiusculas) $caracteres .= $lmai;
			if ($numeros) $caracteres .= $num;
			if ($simbolos) $caracteres .= $simb;
			$len = strlen($caracteres);
			for ($n = 1; $n <= $tamanho; $n++) {
			$rand = mt_rand(1, $len);
			$retorno .= $caracteres[$rand-1];
			}
			return $retorno;
		}
		
		$login = $_REQUEST['usuario'];
		$email = $_REQUEST['email'];
		
		$senha = geraSenha(5, true, false);
		$senhacrip = md5($senha);
		
		$alterar  = mysqli_query($con,"UPDATE loginbase.new_usuarios_ag SET tb_senha='".$senhacrip."', senha_decrypt='".$senha."' WHERE tb_cpf = '".$login."'");
		
		if($alterar){
				date_default_timezone_set('America/Sao_Paulo');
				$ip = getenv("REMOTE_ADDR");
				$to = $email;
				$destino = $email; // Informe o destinatário
				$emitente = 'cadastro@eadiaurora.com.br'; // Informe o Emitente
				
				$mensagem = '<h5><strong>LOGIN:</strong> '. $login ."</b><br /></h5>";
				"<b>".$mensagem .='<strong>NOVA SENHA:</strong> '. $senha ."<br /><br />";

				"<b>".$mensagem .= '<h5><strong>SUA SENHA FOI REDEFINIDA CONFORME SOLICITAÇÃO</strong> '."</b><br /></h5>";
				"<b>".$mensagem .= '<img src="http://www.eadiaurora.com.br/assinatura.jpg" width="479" height="128" alt=""/>';
				"<b>".$mensagem .= "<hr>";

				//$retorno = EnviaEmail($destino, $emitente, $mensagem, $to); // Passa os parâmetros 
	 

				//Função para disparar o e-mail com a senha nova
				//function EnviaEmail($para, $from, $mensagem, $to){
					 
					require("phpMailer/class.phpmailer.php"); 
					$mail = new PHPMailer(); 
					$mail->IsSMTP();
					$mail->Host = "smtp.eadiaurora.com.br"; //host utilizado para o envio do email
					$mail->Port = 587; //porta a ser utilizada
					$mail->SMTPAuth = true; 
					$mail->Username = "cadastro@eadiaurora.com.br"; //email de envio
					$mail->Password= "!@root@!"; //senha do email
					$mail->From = $emitente; 
					$mail->FromName = "Redefinição de Senha"; 
					$mail->AddAddress ($to); //
					$mail->AddBcc('deivid.santos@eadiaurora.com.br'); // Copia
					//$mail->AddBcc('caroline.silva@eadiaurora.com.br'); // Copia
					//$mail->AddBcc('vinicius.santos@eadiaurora.com.br'); // Copia
					$mail->WordWrap = 50; 
					$mail->IsHTML(true);
					$mail->Subject = "Redefinição de Senha"; 
					$mail->Body = "<html><body>".$mensagem."</body></html>"; 
					$retorno = $mail->Send();
					if($retorno){
						echo 'E-mail enviado com sucesso!';
						header("Content-Type: text/html; charset=ISO-8859-1");
					}else{
						echo 'Erro ao enviar e-mail: '.$mail->ErrorInfo;
					}
					
				//}
		}else{
			echo "0";
		}		
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////  ACESSO PARA AS TELAS DE PROCESSOS AG /////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	if($action == "consultarCNPJ"){
		$cpf = $_REQUEST['cpf'];
		$perfil = $_REQUEST['perfil'];
		
		$db_data = array();
		$sql = mysqli_query($con,"select  
									 tb_cnpj,
									 mid(tb_empresa,1,20) tb_empresa,
									 tb_nome,
									 tb_cpf,
									 tb_email,
									 tb_nivel_usuario
								  from loginbase.new_usuarios_ag where tb_cpf = '".$cpf."' and tb_nivel_usuario = '".$perfil."' and tb_ativado = '1'");
		
		$rows = mysqli_num_rows($sql);
		if($rows > 1){			
			//$db_data['resp'] = "1";
			while($result = mysqli_fetch_array($sql)){
				$db_data[] = $result;			
			}
			echo json_encode($db_data);
			
		}else{
			$db_data['resp'] = "0";
			echo json_encode($db_data);
		}
	}
	
	if($action == "cadastroTransp"){
		$cnpjCli = $_REQUEST['cnpjCli'];		
		$cliente = $_REQUEST['cliente'];		
		$cnpjTrans = $_REQUEST['cnpjTrans'];		
		$razaoSocial = $_REQUEST['razaoSocial'];		
		$tipo = $_REQUEST['tipo'];

		$verificaPerfil = mysqli_query($con,"select * from loginbase.new_usuarios_ag where tb_cnpj = '".$cnpjTrans."' and case when ('".$cnpjCli."' = '".$cnpjTrans."' and tb_nivel_usuario = '1') then tb_nivel_usuario = '2' else tb_nivel_usuario = '1' end");
		$rowsPerfil = mysqli_num_rows($verificaPerfil);
		if($rowsPerfil == 0){
			$sql = mysqli_query($con,"select * from sistemas_ag.cad_transp_ag where cnpj_cli = '".$cnpjCli."' and cnpj_transp = '".$cnpjTrans."'");
			$rows = mysqli_num_rows($sql);
			if($rows > 0){
				//JÁ CADASTRADO
				echo "2";
			}else{
				$insert = mysqli_query($con,"insert into sistemas_ag.cad_transp_ag
										(cnpj_cli,cnpj_transp,razao_social,nome_cli,tipo)
										   values
										('".trim($cnpjCli)."','".trim($cnpjTrans)."','".$razaoSocial."','".$cliente."','".$tipo."')
									  ");
									  
				if($insert){
					//CADASTRADO COM SUCESSO
					echo "1";
				}else{
					//ERRO AO INSERIR
					echo "0";
				}
			}
			
		}else{
			// ESSE CNPJ ESTÁ CADASTRADO COM PERFIL DE CLIENTE
			echo "3";
		}			
	}
	
	//Consulta as transportadoras cadastradas
	if($action == "consultarTransp"){
		$cnpj = $_REQUEST['cnpj'];
		
		$db_data = array();
		$sql = mysqli_query($con,"select 
		                            cnpj_cli, 
									cnpj_transp, 
									mid(razao_social,1,20) razao_social, 
									nome_cli, 
									permissao 
								  from
								    sistemas_ag.cad_transp_ag 
								  where cnpj_cli = '".$cnpj."'
								  order by time_stamp desc");
			
		$rows = mysqli_num_rows($sql);			

		if($rows > 0){			
			while($result = mysqli_fetch_array($sql)){
				$db_data[] = $result;
			}
			echo json_encode($db_data);
		}else{
			echo "0";
		}
	}
	
	//Flag de permissão de agendamento para transportadoras
	if($action == "permissao"){
		$cnpjTrans = $_REQUEST['cnpjTrans'];
		$cnpjCli = $_REQUEST['cnpjCli'];
		$permission = $_REQUEST['permission'];
		
		$update = mysqli_query($con,"UPDATE `sistemas_ag`.`cad_transp_ag` SET `permissao` = '".$permissao."' WHERE (`cnpj_cli` = '".$cnpjCli."') and (`cnpj_transp` = '".$cnpjTrans."')");
		
		if($update){
			echo "1";
		}else{
			echo "0";
		}
	}
		
?>
