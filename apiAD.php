<?php

	$action = $_REQUEST["action"];
	//$action = $_POST["acao"];
	
	$con = mysqli_connect("localhost","adminwebsorocaba","VmtefuQffnq6T6US","homologacao_ag");

	if(!$con){
		die("Falha na conexão: ".mysqli_error($con));
		return;
	}
	
	$init = 0;
	
	$userAG = "core_11_1"; 
	$passAG = "T3cn1c05p";
	
	//Aqui pego os dados do cliente na base da Alcis para inserir na tabela clienteAG do Mysql
	$tnsAG = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.20.220.32)(PORT=1522)) (CONNECT_DATA=(SID=ALCISSTB)))";
	//$tnsAG = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.20.220.42)(PORT=1521)) (CONNECT_DATA=(SID=ALCISAGHOMO)))";
	try {
		$conAG = new PDO('oci:dbname='.$tnsAG,$userAG,$passAG);
		$conAG->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Conectado AD<br>";
	} catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////  CADASTROS DE INSTRUÇÕES E ANEXOS //////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if($action == "instrucaoDTA"){
		
		$tb_dta = $_REQUEST['dta'];
		$tb_cnpj_cliente = $_REQUEST['cnpj'];
		$perfil = $_REQUEST['perfil'];
		$nome = $_REQUEST['nome'];
		$tb_cntr = strtoupper($_REQUEST['cntr']);
		$tb_movim = strtoupper($_REQUEST['movim']);
		$tb_espec = strtoupper($_REQUEST['espec']);
		
		if($tb_espec == 'SIM'){
			$tb_temp = strtoupper($_REQUEST['temp']);
		}else{
			$tb_temp = "";
		}
			
		$tb_email = strtoupper($_REQUEST['tb_email']);
		$cliente = strtoupper($_REQUEST['cliente']);
		$razao_comissaria = strtoupper($_REQUEST['razao']);
		$obs =  strtoupper($_REQUEST['obs']);
		$obs2 =  strtoupper($_REQUEST['obs2']);
		
		if($perfil == '4'){
			$comissaria = strtoupper($_REQUEST['comissaria']);
		}else{
			$comissaria = "";
		}
		
		$search = mysqli_query($con,"SELECT * FROM homologacao_ag.tb_instrucao WHERE tb_dta = '$tb_dta'")or die("Select 1: ".mysqli_error($con));
		if(mysqli_num_rows($search) > 0){
			echo "2";
		}else{
			
			$observacao = $obs2.' - '.$obs;
			$protocolo = date("dmyhi") . mt_rand();
			$protocolo2 = $protocolo;
			$insert = mysqli_query($con,"INSERT INTO homologacao_ag.tb_instrucao(tb_session, tb_dta, tb_cntr, tb_cliente, tb_cnpj_cliente,tb_movim, tb_espec, tb_temp, obs,tb_email,nome_comi,comissaria, control,tb_nivel_usuario,razao_comissaria) VALUES ('$nome','$tb_dta', '$tb_cntr','$cliente','$tb_cnpj_cliente','$tb_movim','$tb_espec','$tb_temp','$observacao','$tb_email','$nome','$comissaria','$protocolo','$perfil','$razao_comissaria')")or die("insert 1: ".mysqli_error($con));
			
			if($insert){
				$data = date('dmy', strtotime('now')-(date('I')*3600)); 
				$pasta_cliente = trim($cliente);
				$pasta_cliente = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT',$pasta_cliente));

			/*
				if(!is_dir('../../documentos_nf/'.$pasta_cliente.'/')){
					mkdir('../../documentos_nf/'.$pasta_cliente.'/');
				}
				
				if(!is_dir('../../documentos_nf/'.$pasta_cliente.'/'.$data.'/')){
					mkdir('../../documentos_nf/'.$pasta_cliente.'/'.$data.'/');
				}
			*/	
				
				$diretorio = "../../documentos_nf/$pasta_cliente/$data/";
				
				if(!is_dir($diretorio)){
					echo "3";
				}else{	
					echo "1";
				}
				
			}else{
				echo "0";
			}
			
		}
		
	}

?>