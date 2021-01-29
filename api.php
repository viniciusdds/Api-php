<?php
	$action = $_REQUEST["action"];
	//$action = $_POST["acao"];
	
	$con = mysqli_connect("localhost","root","","loginbase");

	if(!$con){
		die("Falha na conexão: ".mysqli_error($con));
		return;
	}
	
	$init = 0;
	
	$userAG = "core_11_1"; 
	$passAG = "T3cn1c05p";
	
	//Aqui pego os dados do cliente na base da Alcis para inserir na tabela clienteAG do Mysql
	$tnsAG = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.20.220.43)(PORT=1521)) (CONNECT_DATA=(SID=alcisagprd)))";
	//$tnsAG = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.20.220.42)(PORT=1521)) (CONNECT_DATA=(SID=ALCISAGHOMO)))";
	try {
		$conAG = new PDO('oci:dbname='.$tnsAG,$userAG,$passAG);
		$conAG->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Conectado AG<br>";
	} catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}
	
	
	include("burcarPedidos.php");
	
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
		
		$sql = mysqli_query($con,"select 
                                    count(*) linhas, 		
									tb_data,
									tb_cnpj,
									mid(tb_empresa,1,20) tb_empresa,
									mid(tb_nome,1, 20) tb_nome,
									tb_cpf,
									tb_senha,
									tb_email,
									tb_ativado,
									tb_nivel_usuario,
									logado,
									tb_solicitacao
								  from loginbase.new_usuarios_ag where tb_cpf = '".$usuario."' and tb_senha = '".$senha."'
								  group by tb_cpf");
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
		
		$nome    = strtoupper($_REQUEST['nome']);
		$empresa = strtoupper($_REQUEST['empresa']);
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
					$mail->Username = "intranet_service@eadiaurora.com.br"; //email de envio
					$mail->Password= "!@Root@!"; //senha do email
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
						echo '1';
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
			echo "0";
		}
	}
	
	if($action == "cadastroTransp"){
		$cnpjCli = $_REQUEST['cnpjCli'];		
		$cliente = strtoupper($_REQUEST['cliente']);		
		$cnpjTrans = $_REQUEST['cnpjTrans'];		
		$razaoSocial = strtoupper($_REQUEST['razaoSocial']);		
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
										('".trim($cnpjCli)."','".trim($cnpjTrans)."','".strtoupper($razaoSocial)."','".strtoupper($cliente)."','".$tipo."')
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
		$flag = $_REQUEST['flag'];
		
		$update = mysqli_query($con,"UPDATE `sistemas_ag`.`cad_transp_ag` SET `permissao` = '".$flag."' WHERE (`cnpj_cli` = '".$cnpjCli."') and (`cnpj_transp` = '".$cnpjTrans."')");
		
		if($update){
			echo "1";
		}else{
			echo "0";
		}
	}
	
	//Remove a transportadora cadastrada
	if($action == "removerTransp"){
		$cnpjCli = $_REQUEST['cnpjCli'];
		$cnpjTransp = $_REQUEST['cnpjTransp'];
		
		$delete = mysqli_query($con,"DELETE FROM `sistemas_ag`.`cad_transp_ag` WHERE (`cnpj_cli` = '".$cnpjCli."') and (`cnpj_transp` = '".$cnpjTransp."')");
		
		if($delete){
			echo "1";
		}else{
			echo "0";
		}
	}
	
	//Altera a senha
	if($action == "alteraSenha"){
		$email = $_REQUEST['email'];
		$cpf = $_REQUEST['cpf'];
		$senha = $_REQUEST['senha'];
		$password = md5($senha);
		
		$update = mysqli_query($con, "UPDATE loginbase.new_usuarios_ag SET tb_senha = '".$password."', senha_decrypt = '".$senha."' WHERE  tb_cpf = '".$cpf."'");
		
		if($update){
			echo "1";
		}else{
			echo "0";
		}
	}
	
	//Adiciona CNPJ no cadastro
	if($action == "addCnpj"){
		$cnpj = $_REQUEST['cnpj'];
		$cpf = $_REQUEST['cpf'];
		$nome = strtoupper($_REQUEST['nome']);
		$empresa = strtoupper($_REQUEST['empresa']);
		$email = $_REQUEST['email'];
		$perfil = $_REQUEST['perfil'];
		
		$origin = array('/','.','-');
		$destiny = array('','','');
		
		//Verifica se já tem cadastro com outro perfil
		$verifyPER = mysqli_query($con,"select * from loginbase.new_usuarios_ag where tb_cnpj = '".str_replace($origin,$destiny,$cnpj)."' and tb_nivel_usuario != '".$perfil."'");
		
		//Verifica se já tem cadastro 		
		$verifyCPF = mysqli_query($con,"select * from loginbase.new_usuarios_ag where tb_cnpj = '".str_replace($origin,$destiny,$cnpj)."' and tb_cpf = '".$cpf."'");
		
		$rowsPER = mysqli_num_rows($verifyPER);
		$rowsCPF = mysqli_num_rows($verifyCPF);
		
		if($rowsCPF == 0 && $rowsPER == 0){
			$sql = "INSERT INTO loginbase.new_usuarios_ag 
				(
					tb_cnpj,
					tb_empresa,
					tb_nome,
					tb_cpf,
					tb_nivel_usuario,
					tb_email,
					tb_senha,
					senha_decrypt,
					tb_ativado,
					adicionado
				) 
				SELECT 
					'".str_replace($origin,$destiny,$cnpj)."', 
					'".$empresa."', 
					'".$nome."', 
					'".$cpf."', 
                    '".$perfil."',
					'".$email."', 
					tb_senha, 
					senha_decrypt,
					'0',
					'Y'
				FROM loginbase.new_usuarios_ag 
				where tb_cpf = '".$cpf."' 
				and tb_nivel_usuario = '".$perfil."'
				on duplicate key update tb_cnpj = '".str_replace($origin,$destiny,$cnpj)."', tb_empresa = '".$empresa."',
				tb_nivel_usuario = '".$perfil."'";
				
				$insert = mysqli_query($con, $sql);
				if($insert){
					//CADASTRADO COM SUCESSO
					echo "1";
				}else{
					//ERRO AO INSERIR
					echo "0";
				}
		}else{
			if($rowsPER > 0){
				//JÁ CADASTRADO	
				echo "2";
			}else{
				echo "3";
			}
		}	
	}
	
	//Consulta os pedidos da LS200
	if($action == "pesquisaPedido"){
		$busca = $_REQUEST['busca'];
		$cnpj = $_REQUEST['cnpj'];
		
		$pesq = $conAG->query("select 
								dados.NOTA_FISCAL,
								dados.LOTE_SERIAL,
								dados.PRODUTO,
								dados.QTD,
								dados.LOTE,
								dados.MEDIDA,
								dados.UZ
							from 
							  (select 
							  trunc(q.mng_frei + q.MNG_RES_AUF) QTD, 
							  q.id_artikel PRODUTO, 
							  q.nr_lieferschein NOTA_FISCAL,
							  q.charge LOTE_SERIAL,
							  q.TRENN_1 LOTE,
							  q.NR_LE_1 UZ,
							  p.prddf_mun MEDIDA
							  from quanten q, PRDDF p, entow e 
							  WHERE q.id_artikel = p.prddf_id
							  and q.id_klient = e.entow_id
							  and q.id_artikel not like '%KIT%'
							  and (q.nr_lieferschein like '%$busca%'
							  or q.id_artikel like '%$busca%'
							  or q.TRENN_1 like '%$busca%')
							  and e.entow_cll_cnpj = ".$cnpj."
							  and rownum <= 1000
							  group by 
							  q.id_artikel, 
							  q.nr_lieferschein,
							  q.charge,
							  q.TRENN_1,
							  q.NR_LE_1,
							  p.prddf_mun,
							  q.mng_frei,
							  q.MNG_RES_AUF
							  order by q.nr_lieferschein, q.id_artikel) dados");
							  
		$id = 0;	
		$pesq->execute();
		$rows = $pesq->fetch();
	
		if($rows > 0){
					$pesq->execute();							
					while($row = $pesq->fetch()){
						$id = $id+1;
						
						//Consulta para pegar a cubagem
						$condition = $conAG->query("select distinct a.vol CUBAGEM from ARTVPE a where a.typ_le != 'PP' and a.id_artikel = '".trim($row['PRODUTO'])."'");
						$condition->execute();
						$cub = $condition->fetch();
						
						//Pega o valor total
						$qtotal = $conAG->query("select 
													 trunc(sum(q.mng_frei) + sum(q.MNG_RES_AUF)) TOTAL, 
													 q.id_artikel PRODUTO, 
													 q.nr_lieferschein NOTA_FISCAL,
													 q.charge LOTE_SERIAL,
													 q.TRENN_1 LOTE,
													 p.prddf_mun MEDIDA
												from quanten q, PRDDF p 
												  WHERE q.id_artikel = p.prddf_id
												  and q.nr_lieferschein like '%".trim($row['NOTA_FISCAL'])."%'
												  and q.id_artikel like '%".trim($row['PRODUTO'])."%'
												  and q.charge like '%".trim($row['LOTE_SERIAL'])."%'
												  group by id_artikel,q.nr_lieferschein,q.charge,q.TRENN_1,p.prddf_mun order by q.nr_lieferschein");
						
						$qtotal->execute();
						$total = $qtotal->fetch();	
						
						
						
						$verificaUZ = mysqli_query($con,"select palete, pedido from sistemas_ag.clientes_ag where palete = '".trim($row['UZ'])."'")or die("erro no select verifica UZ");
						$linhasUZ = mysqli_num_rows($verificaUZ);
						$pedidoUZ = mysqli_fetch_array($verificaUZ);
							
						//Verifico se já foi quebrado a quantidade que estava em palete
						if($linhasUZ > 0){
							$clausula = " and a.palete = '".trim($row['UZ'])."' ";	
						}else{
							$clausula = " and  a.palete = '--' "; 
						}
						$groupBy = "group by a.palete";
							
						//Verifica se tem algum registro no banco
							$teste = mysqli_query($con,"select 
															sum(pedido) as pedidos,
															qtd_disp disp,
															pedido,
															qtd_disp - sum(pedido) sobra,
															palete,
															troca,
															case when qtd_diff is not null then
															
															case when sum(qtd_diff) > sum(pedido) 
																then 
																	(sum(qtd_diff)-sum(pedido))
																when  sum(qtd_diff) < sum(pedido) 
																then 
																	(sum(pedido)-sum(qtd_diff)) 
																else 
																	(select qtd_diff from sistemas_ag.clientes_ag where nota_fiscal = a.nota_fiscal and produto = a.produto and lote = a.lote and qtd_diff is not null order by time_stamp desc limit 1)
																end
															else
																0
															end qtd_diff,
															
															
															case when palete = '".$row['UZ']."' then	
																case when pedido < ".$row['QTD']." and palete = '".$row['UZ']."'
																then
																	1
																else
																	0
																end
															else
																0
															end testando,
															qtd_por_uz,
															count(*) as linhas
														from sistemas_ag.clientes_ag a 
															where
															nota_fiscal = '".trim($row['NOTA_FISCAL'])."' and lote_serial = '".trim($row['LOTE_SERIAL'])."' 
															and a.produto = '".trim($row['PRODUTO'])."' and a.lote = '".trim($row['LOTE'])."' ".$clausula."
															")or die("erro no select coleta cliente mysql q total");
							
							
							$rows = mysqli_num_rows($teste);
							$acumulados = mysqli_query($con,"select 
																sum(pedido) total,
																count(*) cont,
																(select qtd_diff from sistemas_ag.clientes_ag where nota_fiscal = a.nota_fiscal and produto = a.produto and lote = a.lote order by time_stamp desc limit 1) diff
															  from sistemas_ag.clientes_ag a
																where nota_fiscal = '".$row['NOTA_FISCAL']."'
																and produto = '".$row['PRODUTO']."'
																and lote = '".$row['LOTE']."'
																and pedido != qtd_por_uz")or die("erro no select acumulados");
							$acumulado = mysqli_fetch_array($acumulados);
							
							$EstoqueUZ = mysqli_query($con,"select palete from sistemas_ag.clientes_ag where nota_fiscal = '".$row['NOTA_FISCAL']."' and produto = '".$row['PRODUTO']."' and lote = '".$row['LOTE']."' and pedido = qtd_por_uz")or die("erro no select EstoqueUZ");
							
																
							$rows = mysqli_num_rows($teste);
							if($rows > 0){
								$valor = mysqli_fetch_array($teste);
								extract($valor);
									 
								if(!$pedidos){
									$pedidos = 0;
									$estoque = 0;
									$palete = 0;
								}
								
								$test = array();								
								while($countUZ = mysqli_fetch_array($EstoqueUZ)){
									$test[] = $countUZ['palete'];
								}
								
								if($cub['CUBAGEM']){
									if(substr($cub['CUBAGEM'],0,1) == ","){
										$cubagem = "0".$cub['CUBAGEM'];
									}else{
										$cubagem = $cub['CUBAGEM'];
									}
								}else{
									$cubagem = 0;
								}
								
								if(!in_array($row['UZ'],$test)){
									$arr[] = $row['NOTA_FISCAL'];
									$teste = array_count_values($arr);
									foreach($teste as $v1){
									}	
												
												
									if($v1 == 1){
										$estoque = $row['QTD'] - $acumulado['total'];
									}else{		
										if($estoque < 0){
											$estoque = $row['QTD'] + $estoque;
										}else{	
											$estoque = $row['QTD'];
										}										
									}
									
									//echo "".trim($row['NOTA_FISCAL'])." - ".trim($row['LOTE_SERIAL'])." - ".trim($row['PRODUTO'])." - ".round($estoque)." - ".trim($row['LOTE'])." - ".utf8_encode(trim($row['MEDIDA']))." - ".$cnpj." - ".trim($row['UZ'])." - ".$cubagem." - ".trim($total['TOTAL'])." <br>";


									if($estoque > 0){
										$insert = mysqli_query($con,"insert into sistemas_ag.lista_pedidos_ag 
																 (
																	nota_fiscal,
																	lote_serial,
																	produto,
																	qtd_disp,
																	lote,
																	unid_medida,
																	cnpj,
																	palete,
																	cubagem,
																	qtd_total,
																	qtd_uz
																 )
																 values
																 (
																	'".trim($row['NOTA_FISCAL'])."',
																	'".trim($row['LOTE_SERIAL'])."',
																	'".trim($row['PRODUTO'])."',
																	 ".round($estoque).",
																	'".trim($row['LOTE'])."',
																	'".utf8_encode(trim($row['MEDIDA']))."',
																	'".$cnpj."',
																	'".trim($row['UZ'])."',
																	".str_replace(",",".",$cubagem).",
																	".trim($total['TOTAL']).",
																	".$row['QTD']."
																 ) on duplicate key update 
																	  nota_fiscal = '".trim($row['NOTA_FISCAL'])."',
																	  lote_serial = '".trim($row['LOTE_SERIAL'])."',
																	  produto = '".trim($row['PRODUTO'])."',
																	  qtd_disp = ".round($estoque).",
																	  lote = '".trim($row['LOTE'])."',
																	  unid_medida = '".utf8_encode(trim($row['MEDIDA']))."',
																	  cubagem = ".str_replace(",",".",$cubagem)."")or die(mysqli_error($con));						
									}										
								}
							}
														
					    } // fim do while
		}else{
			$insert = "";
		}
		
		if(isset($insert)){
			$db_data = array();
			$myInfo = mysqli_query($con,"SELECT * FROM sistemas_ag.lista_pedidos_ag where cnpj = '".$cnpj."' and (nota_fiscal like '%$busca%' or produto like '%$busca%' or lote like '%$busca%')");
			while($response = mysqli_fetch_array($myInfo)){
				$db_data[] = $response;
			}
			echo json_encode($db_data);
		}else{
			echo "0";
		}
	}
	
	//Aqui gero o pedido
	if($action == "gerarPedido"){
		$empresa = $_REQUEST['empresa'];
		
		$alias = str_replace(" ","",$empresa);
		$name = substr($alias,0,6);
	
		$insert = mysqli_query($con,"insert into sistemas_ag.num_pedido (id,prefixo) values (1,'$name') on duplicate key update id = id + 1");
		
		if($insert){
			$sql = mysqli_query($con,"select id, prefixo from sistemas_ag.num_pedido where prefixo = '".$name."' order by id desc limit 1");
			$valores = mysqli_fetch_array($sql);
			$id = $valores['id'];
			$prefix = $valores['prefixo'];
			
			$num_pedido = $prefix.$id;
			echo $num_pedido;
		}else{
			echo "0";
		}
	}
	
	//Aqui faz o cadastro dos pedidos por paletes
	if($action == "cadastrarPedido"){
		$init = $init + 1;
		$nota_fiscal = $_REQUEST['nota_fiscal'];
		$lote_serial = $_REQUEST['lote_serial'];
		$produto = $_REQUEST['produto'];
		$qtd_disp = $_REQUEST['qtd_disp'];
		$lote = $_REQUEST['lote'];
		$unidade = $_REQUEST['unidade'];
		$cnpj = $_REQUEST['cnpj'];
		$cubagem = $qtd_disp * str_replace(",",".",$_REQUEST['cubagem']);
		$palete = $_REQUEST['palete'];
		$auth = $_REQUEST['auth'];
		$empresa = $_REQUEST['empresa'];
		$num_pedido = $_REQUEST['num_pedido'];
		
		
		$stid = $conAG->query("select  
								distinct k.entow_id ID_CLIENTE,
								c.entdf_dsc NAME,
								k.entow_ent_id CNPJ,
								ad.entdfb_str END,
								ad.entdfb_nb NUMERO,
								ad.entdfb_zip CEP,
								ad.entdfb_dst BAIRRO,
								t.entdfc_tel1 TEL,
								ad.entdfb_city_nm CIDADE,
								t.entdfc_email1 EMAIL
							from entow k, entdfb ad, ENTDF c, entdfc t
							where k.entow_ent_id = ad.entdfb_ent_id
							and k.entow_ent_id = t.entdfc_ent_id
							and k.entow_ent_id = c.entdf_id 
							and k.entow_ent_id = '".$cnpj."'");

	
		$stid->execute();			
		$row = $stid->fetch();
		$client_id = $row['ID_CLIENTE'];
		$email_cli = $row['EMAIL'];
		$end_cli = $row['END'];
		$numero_cli = $row['NUMERO'];
		$bairro_cli = $row['BAIRRO'];
		$tel_cli = $row['TEL'];
		$cep_cli = $row['CEP'];
		$cidade_cli = $row['CIDADE'];
		$auth = $_REQUEST['auth'];
		$empresa = $_REQUEST['empresa'];;
			
				
		//echo $client_id." - ".$nota_fiscal." - ".$lote_serial." - ".$produto." - ".$qtd_disp." - ".$lote." - ".$unidade." - ".$cnpj." - ".$cubagem." - ".$palete." - ".$email_cli." - ".$end_cli." - ".$numero_cli." - ".$bairro_cli." - ".$tel_cli." - ".$cep_cli." - ".$cidade_cli." - ".$num_pedido;
			
			
			    // tabela principal
				$cadastrar = mysqli_query($con,"insert into `sistemas_ag`.`clientes_ag` 
																(
																	`num_pedido`,
																	`nota_fiscal`,
																	`lote_serial`,
																	`produto`,
																	`qtd_disp`,
																	`lote`,
																	`unid_medida`,
																	`pedido`,
																	`nome_cli`,
																	`cnpj`,
																	`endereco`,
																	`numero`,
																	`bairro`,
																	`cep_cli`,
																	`cidade`,
																	`cod_id`,
																	`email_cli`,
																	`tel_cli`,
																	`palete`,
																	`cubagem`,
																	`auth`,
																	`qtd_por_uz`
																) 
																values 
																(
																	'".$num_pedido."',
																	'".$nota_fiscal."',
																	'".$lote_serial."',
																	'".$produto."',
																	 ".$qtd_disp.",
																	'".$lote."',
																	'".$unidade."',
																	".$qtd_disp.",
																	'".$empresa."',
																	'".$cnpj."',
																	'".$end_cli."',
																	'".$numero_cli."',
																	'".$bairro_cli."',
																	'".$cep_cli."',
																	'".$cidade_cli."',
																	".$client_id.",
																	'".$email_cli."',
																	'".$tel_cli."',
																	'".$palete."',
																	".$cubagem.",
																	".$auth.",
																	".$qtd_disp."
																)");
						
                // tabela de histórico						
				$cadastrar2 = mysqli_query($con,"insert into `sistemas_ag`.`clientes_ag_hist` 
																(
																	`num_pedido`,
																	`nota_fiscal`,
																	`lote_serial`,
																	`produto`,
																	`qtd_disp`,
																	`lote`,
																	`unid_medida`,
																	`pedido`,
																	`nome_cli`,
																	`cnpj`,
																	`endereco`,
																	`numero`,
																	`bairro`,
																	`cep_cli`,
																	`cidade`,
																	`cod_id`,
																	`email_cli`,
																	`tel_cli`,
																	`palete`,
																	`cubagem`,
																	`auth`,
																	`qtd_por_uz`
																) 
																values 
																(
																	'".$num_pedido."',
																	'".$nota_fiscal."',
																	'".$lote_serial."',
																	'".$produto."',
																	 ".$qtd_disp.",
																	'".$lote."',
																	'".$unidade."',
																	".$qtd_disp.",
																	'".$empresa."',
																	'".$cnpj."',
																	'".$end_cli."',
																	'".$numero_cli."',
																	'".$bairro_cli."',
																	'".$cep_cli."',
																	'".$cidade_cli."',
																	".$client_id.",
																	'".$email_cli."',
																	'".$tel_cli."',
																	'".$palete."',
																	".$cubagem.",
																	".$auth.",
																	".$qtd_disp."
																)");
			
				if($cadastrar && $cadastrar2){
					$limpar = mysqli_query($con,"delete from sistemas_ag.lista_pedidos_ag");
					$removerDunble = mysqli_query($con,"delete a from sistemas_ag.clientes_ag a, sistemas_ag.clientes_ag b where a.counter < b.counter and a.palete = b.palete and a.nota_fiscal = '".$nota_fiscal."'");
					echo "1";
				}else{
					echo mysqli_error($con);
				}
		
	}
	
	//Pesquisa itens por quantidade
	if($action == "pesquisaSaldo"){
		$busca = $_REQUEST['busca'];
		$cnpj = $_REQUEST['cnpj'];
		
		$pesq = $conAG->query("select 
									dados.NOTA_FISCAL,
									dados.LOTE_SERIAL,
									dados.PRODUTO,
									dados.QTD,
									dados.LOTE,
									dados.MEDIDA
								from 
								(select 
								  trunc(sum(q.mng_frei) + sum(q.MNG_RES_AUF)) QTD, 
								  q.id_artikel PRODUTO, 
								  q.nr_lieferschein NOTA_FISCAL,
								  q.charge LOTE_SERIAL,
								  q.TRENN_1 LOTE,
								  p.prddf_mun MEDIDA
								from quanten q, PRDDF p, entow e 
								WHERE q.id_artikel = p.prddf_id
								and q.id_klient = e.entow_id
								and (q.nr_lieferschein like '%$busca%'
								or q.id_artikel like '%$busca%'
								or q.TRENN_1 like '%$busca%')
								and e.entow_cll_cnpj = ".$cnpj."
								and rownum <= 1000
								group by q.id_artikel,q.nr_lieferschein,q.charge,q.TRENN_1,p.prddf_mun order by q.nr_lieferschein) dados");
								
		
		$id = 0;
		while ($row = $pesq->fetch()) {	
			$id = $id+1;
			
			$condition = $conAG->query("select distinct a.vol CUBAGEM from ARTVPE a where a.typ_le != 'PP' and a.id_artikel = '".trim($row['PRODUTO'])."'");
			$condition->execute();
			$cub = $condition->fetch();
			
			//Verifica o estoque por quantidade
			$teste = mysqli_query($con,"select 
											sum(pedido) as pedidos,
											max(qtd_composto) qtd_composto
										from sistemas_ag.clientes_ag a 
											where
											 nota_fiscal = '".trim($row['NOTA_FISCAL'])."' and lote_serial = '".trim($row['LOTE_SERIAL'])."' 
											 and a.produto = '".trim($row['PRODUTO'])."' and a.lote = '".trim($row['LOTE'])."' 
											 and (a.palete like '%%' or a.palete = '--') 
											group by nota_fiscal,lote_serial,a.produto")or die("erro no select coleta cliente mysql");
			$rows = mysqli_num_rows($teste);
			
			$composto = $conAG->query("select c.id_artifath COMPOSTO  from comp_prod c where c.id_artifrag = '".trim($row['PRODUTO'])."' group by c.id_artifath");	
			$composto->execute();
			$results = $composto->fetch();			
			
			
			$item = $conAG->query("select c.id_artifrag ITEM, c.mng_best_org QTD  from comp_prod c where c.id_artifath = '".trim($results['COMPOSTO'])."'");
			$item->execute();
			$qt_kit = $item->fetch();
				
			if($rows > 0){
				$valor = mysqli_fetch_array($teste);
				extract($valor);
				
				$total_disp = $row['QTD'] * $qt_kit['QTD'];
				
				if($qt_kit['QTD'] > 1){
					if($total_disp == $pedidos){
						
						$estoque = 0;
					}else{
						$reprod = round($pedidos/$qt_kit['QTD']);
						$estoque = ($row['QTD'] - $reprod);
					}
				}else{
					$estoque = ($row['QTD'] - $pedidos);
				}
					
			}else{
				$estoque = $row['QTD'];
			}
			
			
			$arr1[] = $row['NOTA_FISCAL'];
			$not1 = array_count_values($arr1);
			foreach($not1 as $n1){
			}
			
			$arr2[] = $row['PRODUTO'];
			$not2 = array_count_values(array_unique($arr2));
			foreach($not2 as $n2){
			}
			
			$arr3[] = $row['LOTE'];
			$not3 = array_count_values($arr3);
			foreach($not3 as $n3){
			}
			
			if(round($estoque) <= 0){
					echo "";	
			}else{
				$aviso = 1;
				$composto->execute();
				$teste = $composto->fetchAll();
				$lines = count($teste);
					
				if($lines > 0){
					$composto->execute();
					$result = $composto->fetch();
					
					if($n1 == 1 && $n2 == 1 && $n3 == 1){
						$items = $conAG->query("select c.id_artifrag ITEM, c.mng_best_org QTD  from comp_prod c where c.id_artifath = '".trim($result['COMPOSTO'])."'");
						$items->execute();
						$teste2 = $items->fetchAll();
						$linhas = count($teste2);
						$items->execute();
						
						$cont = 0;
						while ($kit = $items->fetch()) {	
							$cont = $cont + 1;
							
							$guardar_item = mysqli_query($con,"insert into sistemas_ag.itens_composto (composto,itens,nota,serial,lote,qtd,unidade,id,palete,cubagem) 
																	values 
																	('".trim($result['COMPOSTO'])."','".trim($kit['ITEM'])."','".trim($row['NOTA_FISCAL'])."','".trim($row['LOTE_SERIAL'])."','".trim($row['LOTE'])."',".trim($row['QTD']).",'".utf8_encode(trim($row['MEDIDA']))."','".$id."','--','".$cub['CUBAGEM']."')
																	on duplicate key update nota = '".trim($row['NOTA_FISCAL'])."', serial = '".trim($row['LOTE_SERIAL'])."', qtd = ".trim($row['QTD']).", unidade = '".utf8_encode(trim($row['MEDIDA']))."', cubagem='".$cub['CUBAGEM']."'");
						}	
						
						$verificaEstoque = mysqli_query($con,"select 
																max(qtd_composto) QTD 
															  from sistemas_ag.clientes_ag where nota_fiscal = '".trim($row['NOTA_FISCAL'])."' order by time_stamp desc limit 1")or die("erro no select verificaEstoque");
						
						$compostoEstoque = mysqli_fetch_array($verificaEstoque);						
							
						if($compostoEstoque['QTD']){
							$qtd_composto = $compostoEstoque['QTD'];
						}else{
							$qtd_composto = 0;
						}
						
						//echo trim($result['COMPOSTO'])."<br>";
						$docit = $conAG->query("select 
													   doc.dochd_doc_prc_id,
													   case when s.sfcab_avl_bal_qt is null then di.docit_qt - $qtd_composto else s.sfcab_avl_bal_qt - $qtd_composto  end QTD, 
													   doc.dochd_doc_id NF_ENTRADA, 
													   doc.dochd_doc_id ITEM_PAI
													from sfcab s right join dochd doc
													on s.sfcab_doc_prc_id = doc.dochd_doc_prc_id
													inner join docit di
													on doc.dochd_doc_prc_id = di.docit_doc_prc_id
													where doc.dochd_doc_id = '".$row['NOTA_FISCAL']."'
													and di.docit_cd = '".trim($result['COMPOSTO'])."'
													group by 
													s.sfcab_avl_bal_qt, 
													doc.dochd_doc_id, 
													doc.dochd_doc_id,
													di.docit_qt,
													doc.dochd_doc_prc_id");
						$docit->execute();
						$qtdComposto = $docit->fetch();
						
						if($qtdComposto['QTD'] <= 0){
							echo "";
						}else{
								//Recurepar os componentes do composto
								$items = $conAG->query("select c.id_artifrag ITEM, c.einh_mng_org MEDIDA, c.mng_best_org QTD  from comp_prod c where c.id_artifath = '".trim($result['COMPOSTO'])."'");
								$items->execute();
								
								$i = 0;
								while($kit = $items->fetch()) {	
									$i = $i + 1;
									
									if(isset($cub['CUBAGEM'])){
										$cubagem = str_replace(",",".",$cub['CUBAGEM']);
									}else{
										$cubagem = '0';
									}
									
									//echo trim($row['NOTA_FISCAL'])." - ".trim($row['LOTE_SERIAL'])." - ".trim($result['COMPOSTO'])." - ".trim($row['LOTE'])." - ".utf8_encode(trim($row['MEDIDA']))." - ".$cnpj." - ".str_replace(",",".",intval($cub['CUBAGEM']))." - ".$qtdComposto['QTD'];
									
									//Insert de composto
							
									$insertC = mysqli_query($con,"INSERT INTO `sistemas_ag`.`lista_composto_ag` 
																(
																	`nota_fiscal`,
																	`lote_serial`,
																	`composto`,
																	`lote`,
																	`unidade_medida`,
																	`cnpj`,
																	`cubagem`,
																	`qtd_total`
																) 
																VALUES 
																(
																	'".trim($row['NOTA_FISCAL'])."',
																	'".trim($row['LOTE_SERIAL'])."',
																	'".trim($result['COMPOSTO'])."',
																	'".trim($row['LOTE'])."',
																	'".utf8_encode(trim($row['MEDIDA']))."',
																	'".$cnpj."',
																	".$cubagem.",
																	".$qtdComposto['QTD']."
																) on duplicate key update 
																	  nota_fiscal = '".trim($row['NOTA_FISCAL'])."',
																	  lote_serial = '".trim($row['LOTE_SERIAL'])."',
																	  composto = '".trim($result['COMPOSTO'])."',
																	  qtd_total = ".$qtdComposto['QTD'].",
																	  lote = '".trim($row['LOTE'])."',
																	  unidade_medida = '".utf8_encode(trim($row['MEDIDA']))."',
																	  cubagem = ".$cubagem."")or die(mysqli_error($con));
					
								}
							}
						}
				}else{
					if(isset($cub['CUBAGEM'])){
						$cubagem = str_replace(",",".",$cub['CUBAGEM']);
					}else{
						$cubagem = '0';
					}
					
					//echo trim($row['NOTA_FISCAL'])." - ".trim($row['LOTE_SERIAL'])." - ".trim($row['PRODUTO'])." - ".trim($row['LOTE'])." - ".utf8_encode(trim($row['MEDIDA']))." - ".$cnpj." - ".$cubagem." - ".round($estoque)."<br>";
					
						//Insert de quantidade
						$insertU = mysqli_query($con,"INSERT INTO `sistemas_ag`.`lista_qtd_ag` 
																(
																	`nota_fiscal`,
																	`lote_serial`,
																	`produto`,
																	`lote`,
																	`unid_medida`,
																	`cnpj`,
																	`cubagem`,
																	`qtd_total`
																) 
																VALUES 
																(
																	'".trim($row['NOTA_FISCAL'])."',
																	'".trim($row['LOTE_SERIAL'])."',
																	'".trim($row['PRODUTO'])."',
																	'".trim($row['LOTE'])."',
																	'".utf8_encode(trim($row['MEDIDA']))."',
																	'".$cnpj."',
																	".$cubagem.",
																	".round($estoque)."
																) on duplicate key update 
																	  nota_fiscal = '".trim($row['NOTA_FISCAL'])."',
																	  lote_serial = '".trim($row['LOTE_SERIAL'])."',
																	  produto = '".trim($row['PRODUTO'])."',
																	  qtd_total = ".round($estoque).",
																	  lote = '".trim($row['LOTE'])."',
																	  unid_medida = '".utf8_encode(trim($row['MEDIDA']))."',
																	  cubagem = ".$cubagem."")or die("ERROR 2 ".mysqli_error($con));
							
				}
			}
		} // Fim do While principal
		
		if(isset($insertU) || isset($insertC)){
			$db_data = array();
			$myInfo = mysqli_query($con,"select * from sistemas_ag.lista_qtd_ag
													   where cnpj = '".$cnpj."' 
													   and (nota_fiscal like '%$busca%' or produto like '%$busca%' or lote like '%$busca%')
													union all
										 select * from sistemas_ag.lista_composto_ag
													   where cnpj = '".$cnpj."' 
													   and (nota_fiscal like '%$busca%' or composto like '%$busca%' or lote like '%$busca%')");
			
			while($response = mysqli_fetch_array($myInfo)){
				$db_data[] = $response;
			}
			echo json_encode($db_data);
		}else{
			echo "0";
		}
	}
	
	//Cadastra o pedido por quantidade
	if($action == "cadastrarSaldo"){
		$nota_fiscal = $_REQUEST['nota_fiscal'];
		$lote_serial = $_REQUEST['lote_serial'];
		$produto = $_REQUEST['produto'];
		$qtd_total = $_REQUEST['qtd_total'];
		$lote = $_REQUEST['lote'];
		$unidade = $_REQUEST['unidade'];
		$cnpj = $_REQUEST['cnpj'];
		$forma = $_REQUEST['forma'];
		$auth = $_REQUEST['auth'];
		$pedido = $_REQUEST['pedido'];
		$cubagem = $pedido * str_replace(",",".",$_REQUEST['cubagem']);
		$empresa = $_REQUEST['empresa'];
		$num_pedido = $_REQUEST['num_pedido'];
			
		$stid = $conAG->query("select  
								distinct k.entow_id ID_CLIENTE,
								c.entdf_dsc NAME,
								k.entow_ent_id CNPJ,
								ad.entdfb_str END,
								ad.entdfb_nb NUMERO,
								ad.entdfb_zip CEP,
								ad.entdfb_dst BAIRRO,
								t.entdfc_tel1 TEL,
								ad.entdfb_city_nm CIDADE,
								t.entdfc_email1 EMAIL
							from entow k, entdfb ad, ENTDF c, entdfc t
							where k.entow_ent_id = ad.entdfb_ent_id
							and k.entow_ent_id = t.entdfc_ent_id
							and k.entow_ent_id = c.entdf_id 
							and k.entow_ent_id = '".$cnpj."'");

	
		$stid->execute();			
		$row = $stid->fetch();
		$client_id = $row['ID_CLIENTE'];
		$email_cli = $row['EMAIL'];
		$end_cli = $row['END'];
		$numero_cli = $row['NUMERO'];
		$bairro_cli = $row['BAIRRO'];
		$tel_cli = $row['TEL'];
		$cep_cli = $row['CEP'];
		$cidade_cli = $row['CIDADE'];
		
			
			if($forma == "COMP"){
				$items = $conAG->query("select c.id_artifrag ITEM, c.einh_mng_org MEDIDA, c.mng_best_org QTD  from comp_prod c where c.id_artifath = '".$produto."'");
				$items->execute();
				$i = 0;
				while($kit = $items->fetch()) {	
					$i = $i + 1;
					
					//Verifico se já foi feito um pedido composto para mesma nota e produto
					$busca_qtdComp = mysqli_query($con,"select max(qtd_composto) QTD from sistemas_ag.clientes_ag where nota_fiscal = '$nota_fiscal' and produto = '".$kit['ITEM']."' group by nota_fiscal")or die("erro no busca_qtdComp");
					$rows_qtdComp = mysqli_num_rows($busca_qtdComp);
										
					$loteAdd = $conAG->query("select q.trenn_1 LOTE from quanten q where q.nr_lieferschein = '".$nota_fiscal."' and q.id_artikel = '".$kit['ITEM']."'");
					$loteAdd->execute();
					$loteComp = $loteAdd->fetch();
						
					if($kit['QTD'] > 1){
						$qtd_real = $pedido * $kit['QTD'];
					}else{
						$qtd_real = $pedido;
					}

					if($rows_qtdComp > 0){
						$resultComposto = mysqli_fetch_array($busca_qtdComp);
						$result_qtdComp = $resultComposto['QTD'] + $qtd_real;
					}else{
						$result_qtdComp = $qtd_real;
					}
					
					//Vou coletar as quantidades pedidas e acumuladas dos itens compostos
					$coletaQTD = mysqli_query($con,"INSERT INTO
										`sistemas_ag`.`qtd_composto`(num_pedido,nota_fiscal,qtd_pedida,qtd_acumulada) VALUES ('$num_pedido','".$nota_fiscal."',".$qtd_real.",".$result_qtdComp.") 
										")or die("erro no insert coletaQTD");
										
					//Vai inserir as informações do pedido feito no banco da tabela de histórico
					$insert = mysqli_query($con,"insert into sistemas_ag.clientes_ag_hist (num_pedido,nota_fiscal,lote_serial,produto,qtd_disp,lote,unid_medida,pedido,nome_cli,cnpj,endereco,numero,bairro,cep_cli,cidade,cod_id,tel_cli,email_cli,palete,cubagem,auth,qtd_diff,qtd_composto,forma)
					values
					('$num_pedido','$nota_fiscal','$lote_serial','".$kit['ITEM']."','$qtd_total','".$loteComp['LOTE']."','$unidade','$qtd_real','$empresa','$cnpj','$end_cli','$numero_cli','$bairro_cli','$cep_cli','$cidade_cli','$client_id','$tel_cli','$email_cli','--','$cubagem','$auth','$qtd_real','$result_qtdComp','$forma') ON DUPLICATE KEY UPDATE pedido = pedido + '$qtd_real', qtd_disp = qtd_disp");		

						
					//Vai inserir as informações do pedido feito no banco
					$insert = mysqli_query($con,"insert into sistemas_ag.clientes_ag (num_pedido,nota_fiscal,lote_serial,produto,qtd_disp,lote,unid_medida,pedido,nome_cli,cnpj,endereco,numero,bairro,cep_cli,cidade,cod_id,tel_cli,email_cli,palete,cubagem,auth,qtd_diff,qtd_composto,forma)
					values
					('$num_pedido','$nota_fiscal','$lote_serial','".$kit['ITEM']."','$qtd_total','".$loteComp['LOTE']."','$unidade','$qtd_real','$empresa','$cnpj','$end_cli','$numero_cli','$bairro_cli','$cep_cli','$cidade_cli','$client_id','$tel_cli','$email_cli','--','$cubagem','$auth','$qtd_real','$result_qtdComp','$forma') ON DUPLICATE KEY UPDATE pedido = pedido + '$qtd_real', qtd_disp = qtd_disp");
										
				}
			}else{
				$result_qtdComp = 0;
				
				//Vai inserir as informações do pedido feito no banco da tabela de histórico
				$insert = mysqli_query($con,"insert into sistemas_ag.clientes_ag_hist (num_pedido,nota_fiscal,lote_serial,produto,qtd_disp,lote,unid_medida,pedido,nome_cli,cnpj,endereco,numero,bairro,cep_cli,cidade,cod_id,tel_cli,email_cli,palete,cubagem,auth,qtd_diff,qtd_composto,forma)
				values
				('$num_pedido','$nota_fiscal','$lote_serial','$produto','$qtd_total','$lote','$unidade','$pedido','$empresa','$cnpj','$end_cli','$numero_cli','$bairro_cli','$cep_cli','$cidade_cli','$client_id','$tel_cli','$email_cli','--','$cubagem','$auth','$pedido','$result_qtdComp','$forma') ON DUPLICATE KEY UPDATE pedido = pedido + '$pedido', qtd_disp = qtd_disp");		

					
				//Vai inserir as informações do pedido feito no banco
				$insert = mysqli_query($con,"insert into sistemas_ag.clientes_ag (num_pedido,nota_fiscal,lote_serial,produto,qtd_disp,lote,unid_medida,pedido,nome_cli,cnpj,endereco,numero,bairro,cep_cli,cidade,cod_id,tel_cli,email_cli,palete,cubagem,auth,qtd_diff,qtd_composto,forma)
				values
				('$num_pedido','$nota_fiscal','$lote_serial','$produto','$qtd_total','$lote','$unidade','$pedido','$empresa','$cnpj','$end_cli','$numero_cli','$bairro_cli','$cep_cli','$cidade_cli','$client_id','$tel_cli','$email_cli','--','$cubagem','$auth','$pedido','$result_qtdComp','$forma') ON DUPLICATE KEY UPDATE pedido = pedido + '$pedido', qtd_disp = qtd_disp");	
			}
			
					
			
			//Verifica se a inserção foi feita com sucesso
			if($insert){
				$limpar1 = mysqli_query($con,"delete from sistemas_ag.lista_composto_ag");
				$limpar2 = mysqli_query($con,"delete from sistemas_ag.lista_qtd_ag");
				echo "1";
			}else{
				echo "0";
			}
	}
	
	//Aqui eu consulto os pedidos gerados
	if($action == "buscarPedidos"){			
		$categoria = $_REQUEST['nivel'];
		$cnpj = $_REQUEST['cnpj'];
						
		buscarPedidos($categoria, $cnpj, $con, $conAG);	
	}

	//Aqui eu consulto os itens no pedido especifico para lista de edição de quantidade
	if($action == "consultaInfo"){
		$num_pedido = $_REQUEST['num_pedido'];
		
		$db_data = array();
		$sql = mysqli_query($con,"select 
								  	nota_fiscal,
									produto,
									lote,
									qtd_disp,
									pedido,
									cubagem,
									palete
								  from sistemas_ag.lista_gerado where num_pedido = '".$num_pedido."' 
								  group by lote,nota_fiscal,produto");
								  
		while($result = mysqli_fetch_array($sql)){
			$db_data[] = $result;
		}
		
		echo json_encode($db_data);
	}

	//Aqui eu edito a quantidade do pedido
	if($action == "editarQtd"){
		$num_pedido = $_REQUEST['num_pedido'];
		$nota_fiscal = $_REQUEST['nota_fiscal'];
		$produto = $_REQUEST['produto'];
		$lote = $_REQUEST['lote'];
		$qtd_disp = $_REQUEST['qtd_disp'];
		$qtd_nova = $_REQUEST['qtd_nova'];
		$pedido = $_REQUEST['pedido'];
		$cubagem = $_REQUEST['cubagem'];
		$palete = $_REQUEST['palete'];
		
	
		
		$pos = strpos($produto,"KIT");
		
		if($pos){
			
			$pesqQTD = $conAG->query("select 
										q.trenn_1 LOTE,
										c.id_artifrag ITEM, 
										c.mng_best_org QTD
									from comp_prod c, quanten q
									where q.id_klient = c.id_klientfa
									and q.id_artikel = c.id_artifrag
									and q.nr_lieferschein = '".$nota_fiscal."' 
									group by c.id_artifrag, c.mng_best_org, q.trenn_1");
				
				
			$pesqQTD->execute();
			
			while($returnQTD = $pesqQTD->fetch()){
				
					
				$qtdEditada = ((int)$returnQTD['QTD'] * (int)$qtd_nova);
				$pesqCUB = $conAG->query("select REPLACE(round(a.vol,3), ',' ,'.') CUBAGEM from artvpe a where a.id_artikel = '".$returnQTD['ITEM']."' and a.vol is not null");
				$pesqCUB->execute();
				$returnCUB = $pesqCUB->fetch();
				
				$valCubagem = ((float)$returnCUB['CUBAGEM'] * (float)$qtdEditada);
				
				//$editarQtdPedido = mysqli_query($con,"UPDATE `sistemas_ag`.`qtd_composto` SET qtd_pedida = '".$qtd_pedido."' WHERE num_pedido = '".$num_pedido."'")or die("erro no update editarQtdPedido");
				
				$editar = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag` SET `pedido`= '".$qtdEditada."', palete = '--', troca='V', cubagem='".round($valCubagem,3)."'  WHERE `num_pedido`='".$num_pedido."' and nota_fiscal = '".$nota_fiscal."' and produto = '".$returnQTD['ITEM']."' and lote = '".$returnQTD['LOTE']."'")or die("erro no update de edicao 1");
				
				$editar2 = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag_hist` SET `pedido`= '".$qtdEditada."', `palete` = '--', `troca`='V', `cubagem`='".$valCubagem."' WHERE `num_pedido`='".$num_pedido."' and nota_fiscal = '".$nota_fiscal."' and produto = '".$returnQTD['ITEM']."' and lote = '".$returnQTD['LOTE']."'")or die("erro no update de edicao 3");
			}
			
			
			//Verifica se no pedido tem item composto
			$buscaNF = mysqli_query($con,"select nota_fiscal NF from sistemas_ag.qtd_composto where num_pedido = '".$num_pedido."' group by nota_fiscal")or die("erro do sqlQtdRest");

			$rowsNF = mysqli_num_rows($buscaNF);
			
			if($rowsNF > 0){
				
				//Verifico se já foi feito um pedido composto para mesma nota e produto
				$busca_qtdComp = mysqli_query($con,"select 
													count(distinct num_pedido) pedidos
												from sistemas_ag.clientes_ag where nota_fiscal = '".$nota_fiscal."' and qtd_composto <= (
													select qtd_composto from (select max(qtd_composto) qtd_composto from sistemas_ag.clientes_ag) as tb1)")or die("erro no busca_qtdComp");
													
				$resultComposto = mysqli_fetch_array($busca_qtdComp);
				
				
				while($ReturnNF = mysqli_fetch_array($buscaNF)){
					$nf_fiscal = $ReturnNF['NF'];
					//echo "NF encaminhada: ".$nota." NV: ".$nf_fiscal."\n";
					
			
					//Aqui verifico qual quantidade composta esta sendo deletada
					$sqlQTD = mysqli_query($con,"SELECT 
												qtd_pedida,
												qtd_acumulada,
												maximo,
												sum(soma) total
											FROM 
											(SELECT 
												qtd_pedida qtd_pedida, 
												qtd_acumulada qtd_acumulada
											FROM sistemas_ag.qtd_composto a
											where a.num_pedido = '".$num_pedido."'
											 and a.nota_fiscal = '".$nf_fiscal."'
											 group by a.num_pedido) as tb1,
											 (select 
												max(qtd_composto) maximo
											from sistemas_ag.clientes_ag
												where nota_fiscal = '".$nf_fiscal."'
											) as tb2,
											(select 
														 qtd_pedida soma
												  from sistemas_ag.qtd_composto
												  where nota_fiscal = '".$nf_fiscal."' group by num_pedido) as tb3")or die("erro no select sqlQTD");
					
					$resultQTD = mysqli_fetch_array($sqlQTD);						
					if($resultQTD['total'] != ""){
						
						$sobraQTD = ((int)$resultQTD['total'] - (int)$resultQTD['qtd_pedida']);
						if($nota_fiscal == $nf_fiscal){
							$valorAtual = ((int)$qtd_nova + (int)$sobraQTD);
						}else{
							$valorAtual = (int)$resultQTD['total'];
						}
						//echo "Sobra: ".$sobraQTD." ValorAtual: ".$valorAtual." QtdPedido: ".$qtd_pedido." ".$resultQTD['total']." ".$resultQTD['qtd_pedida']."\n";
						
						if($resultComposto['pedidos'] == 1){
							$editar3 = mysqli_query($con,"UPDATE sistemas_ag.clientes_ag SET `qtd_composto`= $qtd_nova, `time_stamp` = now() WHERE `nota_fiscal`= '".$nf_fiscal."' AND qtd_composto = (SELECT 
							qtd_composto FROM (SELECT MAX(qtd_composto) qtd_composto FROM sistemas_ag.clientes_ag
							WHERE nota_fiscal = '".$nf_fiscal."') AS tb1)")or die("erro no update de edicao 2 base 1");
							
							$editar4 = mysqli_query($con,"UPDATE sistemas_ag.clientes_ag_hist SET `qtd_composto`= $qtd_nova, `time_stamp` = now() WHERE `nota_fiscal`= '".$nf_fiscal."' AND qtd_composto = (SELECT 
							qtd_composto FROM (SELECT MAX(qtd_composto) qtd_composto FROM sistemas_ag.clientes_ag_hist
							WHERE nota_fiscal = '".$nf_fiscal."') AS tb1)")or die("erro no update de edicao 2 hist 1");
						}else{	
							$editar3 = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag` SET `qtd_composto` = ".$valorAtual.", `time_stamp` = now(), `qtd_disp`= '$sobraQTD' WHERE (`nota_fiscal` = '".$nota_fiscal."') and qtd_composto = (select qtd_composto from (select max(qtd_composto) qtd_composto from sistemas_ag.clientes_ag where nota_fiscal = '".$nf_fiscal."') as tb1)")or die("erro no update de edicao 2 base 2");
							
							$editar4 = mysqli_query($con,"UPDATE sistemas_ag.clientes_ag_hist SET `qtd_composto`=  ".$valorAtual.", `time_stamp` = now(), `qtd_disp`= '$sobraQTD' WHERE `nota_fiscal`= '".$nf_fiscal."' AND qtd_composto = (SELECT qtd_composto FROM (SELECT MAX(qtd_composto) qtd_composto FROM sistemas_ag.clientes_ag_hist
							WHERE nota_fiscal = '".$nf_fiscal."') AS tb1)")or die("erro no update de edicao 2 hist 2");
						}
						
						
						
						if($editar3 && $editar4){
							$editarQtdComposto = mysqli_query($con,"UPDATE `sistemas_ag`.`qtd_composto` SET `qtd_acumulada` = ".$valorAtual.", qtd_pedida = '".$qtd_nova."' WHERE `num_pedido` = '".$num_pedido."' and nota_fiscal = '".$nota_fiscal."'")or die("erro no update editarQtdComposto");
						}
					}
				}
			}
			
		}else{
			$qtdEditada = $qtd_nova;
			
			if(strpos($cubagem,"PP") == true){
				$cub = 0;
			}elseif(strpos($cubagem,"QT") == true){
				$cub = 0;
			}else{
				$cub = (((int)$cubagem/(int)$pedido) * (int)$qtd_nova);
			}
		}

		
		
		$consult = mysqli_query($con,"select count(*) cont, troca from sistemas_ag.clientes_ag where num_pedido = '".$num_pedido."' and nota_fiscal = '".$nota_fiscal."' and produto = '".$produto."' and lote = '".$lote."'  group by num_pedido,nota_fiscal,lote,produto")or die("erro no select consult");
		$resp = mysqli_fetch_array($consult);
		
		if($resp['cont'] > 1){
			$timer1 = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag` SET `time_stamp`=now(), troca='V' WHERE `num_pedido`='".$num_pedido."' and palete='".$palete."'")or die("erro no update de timer1");
			$timer2 = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag_hist` SET `time_stamp`=now(), troca='V' WHERE `num_pedido`='".$num_pedido."' and palete='".$palete."'")or die("erro no update de timer2");
			
			if($resp['troca'] == "V"){
				$limpar1 = mysqli_query($con,"delete a from sistemas_ag.clientes_ag a, sistemas_ag.clientes_ag b where a.num_pedido = '".$num_pedido."' and a.num_pedido = b.num_pedido and a.counter < b.counter and a.nota_fiscal = b.nota_fiscal and a.produto = b.produto and a.lote = b.lote")or die("erro no delete limpar1");
				$limpar2 = mysqli_query($con,"delete a from sistemas_ag.clientes_ag_hist  a, sistemas_ag.clientes_ag_hist b where a.num_pedido = '".$num_pedido."' and a.num_pedido = b.num_pedido and a.counter < b.counter and a.nota_fiscal = b.nota_fiscal and a.produto = b.produto and a.lote = b.lote")or die("erro no delete limpar2");
			}else{	
				$limpar1 = mysqli_query($con,"delete a from sistemas_ag.clientes_ag a, sistemas_ag.clientes_ag b where a.num_pedido = '".$num_pedido."' and a.num_pedido = b.num_pedido and a.counter < b.counter and a.nota_fiscal = b.nota_fiscal and a.produto = b.produto and a.lote = b.lote")or die("erro no delete limpar1");
				$limpar2 = mysqli_query($con,"delete a from sistemas_ag.clientes_ag_hist a, sistemas_ag.clientes_ag_hist b where a.num_pedido = '".$num_pedido."' and a.num_pedido = b.num_pedido and a.counter < b.counter and a.nota_fiscal = b.nota_fiscal and a.produto = b.produto and a.lote = b.lote")or die("erro no delete limpar2");
			}
			
		}else{
			$timer1 = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag` SET `time_stamp`=now() WHERE `num_pedido`='".$num_pedido."'")or die("erro no update de timer1");
		}
		
		if($pos){
			
		}else{
			$editar = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag` SET `pedido`= '".$qtdEditada."', palete = '--', troca='V', cubagem='".$cub."' WHERE `num_pedido`='".$num_pedido."' and nota_fiscal = '".$nota_fiscal."' and produto = '".$produto."' and lote = '".$lote."'")or die("erro no update de edicao");
		
		
			$editar2 = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag_hist` SET `pedido`= '".$qtdEditada."', palete = '--', troca='V', cubagem='".$cub."', qtd_composto='".$qtd_nova."' WHERE `num_pedido`='".$num_pedido."' and nota_fiscal = '".$nota_fiscal."' and produto = '".$produto."' and lote = '".$lote."'")or die("erro no update de edicao");
		}
		
		
		if($editar && $editar2){
			$limpar = mysqli_query($con,"DELETE FROM `sistemas_ag`.`lista_gerado`");
			echo "1";
		}else{
			echo "0";
		}	
	}

	//Aqui eu limpo a lista de itens
    if($action == "limparLista"){
		
		$limpar = mysqli_query($con,"DELETE FROM `sistemas_ag`.`lista_gerado`");
		if($limpar){
			echo "1";
		}else{
			echo "0";
		}
	}

    //Aqui vou remover o pedido gerados
    if($action == "removerPedido"){
		$pedido = $_REQUEST['num_pedido'];
		
		//Verifica se no pedido tem item composto
		$buscaNF = mysqli_query($con,"select nota_fiscal NF from sistemas_ag.qtd_composto where num_pedido = '".$pedido."' group by nota_fiscal")or die("erro do sqlQtdRest");

		$rowsNF = mysqli_num_rows($buscaNF);
			
			if($rowsNF > 0){
				$in = 0;
				while($ReturnNF = mysqli_fetch_array($buscaNF)){
					$in = $in + 1;
					$nf_fiscal2 = $ReturnNF['NF'];
					
					//Aqui verifico qual quantidade composta esta sendo deletada
					$sqlQTD = mysqli_query($con,"SELECT 
												qtd_pedida,
												qtd_acumulada,
												maximo,
												sum(soma) total
											FROM 
											(SELECT 
												qtd_pedida qtd_pedida, 
												qtd_acumulada qtd_acumulada
											FROM sistemas_ag.qtd_composto a
											where a.num_pedido = '".$pedido."'
											 group by a.num_pedido) as tb1,
											 (select 
												max(qtd_composto) maximo
											from sistemas_ag.clientes_ag
												where nota_fiscal = '".$nf_fiscal2."'
											) as tb2,
											(select 
												qtd_pedida soma
											from sistemas_ag.qtd_composto
											where nota_fiscal = '".$nf_fiscal2."' group by num_pedido) as tb3")or die("erro no select sqlQTD");
											
					$rowsQTD = mysqli_num_rows($sqlQTD);					
										
					if($rowsQTD > 0){
						
						$remover = mysqli_query($con,"DELETE FROM `sistemas_ag`.`clientes_ag` WHERE `num_pedido` = '".$pedido."' and nota_fiscal = '".$nf_fiscal2."'")or die("erro no delete remover pedido do cliente ag");
							
						$resultQTD = mysqli_fetch_array($sqlQTD);
						$valorAtual =  ((int)$resultQTD['total'] - (int)$resultQTD['qtd_pedida']);	
								
						$atuaQTD = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag` SET `qtd_composto` = ".$valorAtual." WHERE (`nota_fiscal` = '".$nf_fiscal2."') and qtd_composto <= (select qtd_composto from (select max(qtd_composto) qtd_composto from sistemas_ag.clientes_ag where nota_fiscal = '".$nf_fiscal2."') as tb1)")or die("erro no update atuaQTD");
								
						$atuaQTD2 = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag_hist` SET `qtd_composto` = ".$valorAtual." WHERE (`nota_fiscal` = '".$nf_fiscal2."') and qtd_composto <= (select qtd_composto from (select max(qtd_composto) qtd_composto from sistemas_ag.clientes_ag_hist where nota_fiscal = '".$nf_fiscal2."') as tb1)")or die("erro no update atuaQTD");
								
						if($atuaQTD && $atuaQTD2){
							$removerQtdComposto = mysqli_query($con,"DELETE FROM `sistemas_ag`.`qtd_composto` WHERE `num_pedido` = '".$pedido."' and nota_fiscal = '".$nf_fiscal2."'")or die("erro no delete remover qtd composta");
						}
					}
				}
			}
		
		$remover = mysqli_query($con,"DELETE FROM `sistemas_ag`.`clientes_ag` WHERE `num_pedido` = '".$pedido."'")or die("erro no delete remover pedido do cliente ag");

		$removerQtdComposto = mysqli_query($con,"DELETE FROM `sistemas_ag`.`qtd_composto` WHERE `num_pedido` = '".$pedido."'")or die("erro no delete remover qtd composta");
										
		$removerAgenda = mysqli_query($con,"DELETE FROM `sistemas_ag`.`agendamento_ag` WHERE `num_pedido` = '".$pedido."'")or die("erro no delete agenda ag remover");
		
		$removerAgendaHist = mysqli_query($con,"DELETE FROM `sistemas_ag`.`agendamento_hist` WHERE `num_pedido` = '".$pedido."'")or die("erro no delete agenda hist remover");
		
		$removerColeta = mysqli_query($con,"DELETE FROM `sistemas_ag`.`coleta_ag` WHERE `num_pedido` = '".$pedido."'")or die("erro no delete coleta ag remover");
		
		$removerColetaHist = mysqli_query($con,"DELETE FROM `sistemas_ag`.`coleta_ag_hist` WHERE `num_pedido` = '".$pedido."'")or die("erro no delete coleta hist remover");
		
		$removerColetaStatus = mysqli_query($con,"DELETE FROM `sistemas_ag`.`coleta_status` WHERE `num_pedido` = '".$pedido."'")or die("erro no delete coleta status remover");
			
		$removerOrdem = mysqli_query($con,"DELETE FROM `sistemas_ag`.`coleta_status` WHERE `num_pedido` = '".$pedido."'")or die("erro no delete ordem coleta remover");
		
		$verificaVeiculo = mysqli_query($con,"SELECT num_pedido, tipo FROM `sistemas_ag`.`veiculos_ag` where (id_veiculo = '".$pedido."' or num_pedido = '".$pedido."')")or die("erro no select verificar veiculo");
		$qtdVeiculos = mysqli_num_rows($verificaVeiculo);
		if($qtdVeiculos === 0){
			$removerHist = mysqli_query($con,"DELETE FROM `sistemas_ag`.`clientes_ag_hist` WHERE `num_pedido` = '".$pedido."'")or die("erro no delete remover hist 1");
		}else{
			$codVeiculo = mysqli_fetch_array($verificaVeiculo);
			$id_veiculo = $codVeiculo['num_pedido'];
			$tp_veiculo = $codVeiculo['tipo'];
			$removerHist = mysqli_query($con,"DELETE FROM `sistemas_ag`.`clientes_ag_hist` WHERE `num_pedido` = '".$id_veiculo."'")or die("erro no delete remover hist 2");
			
			if($tp_veiculo === "PED"){
				$removerCodUnit = mysqli_query($con,"DELETE FROM `sistemas_ag`.`codigo_unico` WHERE codigo = '".substr($pedido,8)."'")or die("erro no select removerCodUnit");
			}
		}
		
		$removerVeiculo = mysqli_query($con,"DELETE FROM `sistemas_ag`.`veiculos_ag` WHERE (id_veiculo = '".$pedido."' or num_pedido = '".$pedido."')")or die("erro no delete remover veiculo");
			
		
		if($remover && $removerHist && $removerAgenda && $removerAgendaHist && $removerColeta && $removerColetaHist && $removerColetaStatus && $removerVeiculo && $removerOrdem){
			$limpar = mysqli_query($con,"truncate sistemas_ag.lista_gerado")or die(mysqli_error($con));	
			echo "1";
		}else{
			echo "0";
		}	
	}	
	
	//Aqui eu altero o status para liberado
	if($action == "liberarStatus"){
		$num_pedido = $_REQUEST['num_pedido'];
		
		//Tabela de Histórico
		$update = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag_hist` SET `status`='2' WHERE `num_pedido`='".$num_pedido."'")or die("erro no update de status");
		
		//Tabela Principal
		$update = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag` SET `status`='2' WHERE `num_pedido`='".$num_pedido."'")or die("erro no update de status");
		
		if($update){
			echo "1";
		}else{
			echo "0";
		}
	}
	
	//Aqui busco os pedidos que possa ser unificados
	if($action == "buscarVeiculos"){
		$nivel = $_REQUEST['perfil'];
        $cnpj = $_REQUEST['cnpj'];
		$db_data = array();

		$sql = mysqli_query($con,"SELECT 
    						 distinct a.num_pedido
						   FROM
    						 sistemas_ag.clientes_ag a
        						LEFT JOIN
    						 sistemas_ag.veiculos_ag b ON a.num_pedido = b.num_pedido
    						 where a.status = '2' 
							 and a.num_pedido not like '%.%' 
                             and a.num_pedido not like '%-%'
							 and a.cnpj = '".$cnpj."' and b.num_pedido is null")or die(mysqli_error($con));		
		while($result = mysqli_fetch_array($sql)){
			$db_data[] = $result;
		}
		echo json_encode($db_data);							 
	}
	
	//Aqui adiciono os pedidos que vai ser unificados
	if($action == "unirPedidos"){
			$origin = array("[","]");
			$destiny = array("","");
			
			$cnpj = $_REQUEST['cnpj'];
			$perfil = $_REQUEST['perfil'];
			$num_pedido = str_replace($origin,$destiny,$_REQUEST['num_pedido']);
			
			if($perfil == '1'){
				$client = $cnpj;
			}else{
				$buscaCli = mysqli_query($con,"select distinct cnpj from sistemas_ag.clientes_ag where num_pedido = '".$num_pedido."'")or die(mysqli_error($con));
				$returnCli = mysqli_fetch_array($buscaCli);
				$client = $returnCli['cnpj'];
			}
			
			$codigoUnico = substr(uniqid(rand()), 0, 4);
			
			//Aqui verifico se o código acima já foi usado
			$verificaCodigo = mysqli_query($con,"select codigo from sistemas_ag.codigo_unico where codigo = '".$codigoUnico."'")or die("erro no select codigo unico");
			
			//Aqui verifico o retorno da query acima
			$resultCodigo = mysqli_num_rows($verificaCodigo);
			if($resultCodigo > 0){
				$novoCodigo = substr(uniqid(rand()), 0, 4);
				$numbers = $novoCodigo;
			}else{
				$insertCodigo = mysqli_query($con,"insert into sistemas_ag.codigo_unico (codigo) values ('".$codigoUnico."')")or die("erro no insert codigo unico");
				$numbers = $codigoUnico;
			}
			
			$prefix = substr($num_pedido,0,6);
			$veiculo_id = $prefix.".U".$numbers;
			
			$qtdVirgula = substr_count($num_pedido,",");
			if($qtdVirgula > 0){
				$pedido = explode(",",$num_pedido);
				
				for($i=0; $i <= $qtdVirgula; $i++){
					
					//echo $pedido[$i]."<br>";
					
					
					$insert = mysqli_query($con,"insert into sistemas_ag.veiculos_ag (cnpj,num_pedido,qtd_veiculos,id_veiculo,tipo,cliente) values ('".$cnpj."','".trim($pedido[$i])."',1,'".$veiculo_id."','PED','".$client."')")or die(mysqli_error($con));
					//Pega o id_veiculo para unificar os pedidos a um veículo
					$pegaId = mysqli_query($con,"select id_veiculo from sistemas_ag.veiculos_ag where num_pedido = '".trim($pedido[$i])."'")or die("erro no select pegaId");
					$rowId = mysqli_num_rows($pegaId);
					if($rowId > 0){
						$returnId = mysqli_fetch_array($pegaId);
						$id_veiculo = $returnId['id_veiculo'];
						$pegaPedido = mysqli_query($con,"select num_pedido from sistemas_ag.veiculos_ag where id_veiculo = '".$id_veiculo."'")or die(mysqli_error($con));
						while($returnPedido = mysqli_fetch_array($pegaPedido)){
							$updatePedido = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag` SET `num_pedido`='".$id_veiculo."', time_stamp=now() WHERE num_pedido = '".$returnPedido['num_pedido']."';")or die("erro no updatePedido");
						}
					}
					
					
				}		
			}else{
				$pedido = $num_pedido;
				
				$insert = mysqli_query($con,"insert into sistemas_ag.veiculos_ag (cnpj,num_pedido,qtd_veiculos,id_veiculo,tipo,cliente) values ('".$cnpj."','".$pedido."',1,'".$veiculo_id."','PED','".$client."')")or die(mysqli_error($con));
				$pegaId = mysqli_query($con,"select id_veiculo from sistemas_ag.veiculos_ag where num_pedido = '".$pedido."'")or die("erro no select pegaId");
				$rowId = mysqli_num_rows($pegaId);
				if($rowId > 0){
					$returnId = mysqli_fetch_array($pegaId);
					$id_veiculo = $returnId['id_veiculo'];
					$pegaPedido = mysqli_query($con,"select num_pedido from sistemas_ag.veiculos_ag where id_veiculo = '".$id_veiculo."'")or die(mysqli_error($con));
					while($returnPedido = mysqli_fetch_array($pegaPedido)){
						$updatePedido = mysqli_query($con,"UPDATE `sistemas_ag`.`clientes_ag` SET `num_pedido`='".$id_veiculo."', time_stamp=now() WHERE num_pedido = '".$returnPedido['num_pedido']."';")or die("erro no updatePedido");
					}
				}
			}
				
			if($insert){	
				$limpar = mysqli_query($con,"truncate sistemas_ag.lista_gerado")or die(mysqli_error($con));	
				//buscarPedidos($perfil, $cnpj, $con, $conAG);
				echo "1";
			}else{
				echo "0";
			}
		}
		
		//Aqui eu segmento os pedidos
		if($action == "separarPedido"){
				$cnpj = $_REQUEST['cnpj'];
				$dataSecurity = date('ymdHis');
				$quantity = $_REQUEST['quantity'];
				$perfil = $_REQUEST['perfil'];
				$num_pedido = $_REQUEST['num_pedido'];
				
				if($perfil == '2'){
					$busClient = mysqli_query($con, "SELECT 
    													cnpj_cli
													FROM
    													sistemas_ag.cad_transp_ag a
    													inner join
    													sistemas_ag.clientes_ag b
    													on a.cnpj_cli = b.cnpj
													WHERE
												cnpj_transp = '".$cnpj."'
												and b.num_pedido = '".$num_pedido."'
												group by cnpj_cli")or die(mysqli_error($con));
					
					$resClient = mysqli_fetch_array($busClient);					
					$client = $resClient['cnpj_cli'];
				}else{
					$client = $cnpj;
				}
				
				
				
				$query = mysqli_query($con,"select num_pedido,  mid(num_pedido,1,4) prefix from sistemas_ag.veiculos_ag where cnpj = '".$cnpj."' and (id_veiculo is null or id_veiculo = '' or id_veiculo = '--') and (tipo = 'VEI' or tipo is null or tipo = '') limit 1")or die("erro no select query busca pedido2");
				$result = mysqli_fetch_array($query);
				$rows = mysqli_num_rows($query);
				
				
				if($rows > 0){
				
		
					for($i=1;$i<=$quantity;$i++){
						$pedido_id = $result['num_pedido']."-".$i;
						$veiculo_id = $result['prefix'].$dataSecurity;
						$inserir = mysqli_query($con,"insert into sistemas_ag.veiculos_ag (cnpj,num_pedido,qtd_veiculos,id_veiculo,tipo) values ('".$cnpj."','".$pedido_id."',1,'".$veiculo_id."','VEI') on duplicate key update cnpj='".$cnpj."', num_pedido='".$pedido_id."', qtd_veiculos=1, id_veiculo = '".$veiculo_id."'")or die("erro no insert do cadastro do id veiculo2");
						if($inserir){	
							//Carrega o estoque com o novo pedido
							$carregaEstoque = mysqli_query($con,"INSERT INTO sistemas_ag.clientes_ag (num_pedido,nota_fiscal,lote_serial,produto,qtd_disp,lote,unid_medida,pedido,nome_cli,cnpj,endereco,numero,bairro,cep_cli,cidade,cod_id,email_cli,tel_cli,status,palete,cubagem,auth,qtd_composto,forma)
							SELECT '".$pedido_id."',nota_fiscal,lote_serial,produto,qtd_disp,lote,unid_medida,pedido/".$quantity.",nome_cli,cnpj,endereco,numero,bairro,cep_cli,cidade,cod_id,email_cli,tel_cli,status,palete,cubagem/".$quantity.",auth,qtd_composto,forma FROM sistemas_ag.clientes_ag_hist where num_pedido = '".$result['num_pedido']."'")or die("erro no select carregaEstoque");
						}
					}
					$remove = mysqli_query($con,"delete from sistemas_ag.veiculos_ag where num_pedido = '".$result['num_pedido']."'")or die("erro no delete remove pedido unico");
					$remove = mysqli_query($con,"delete from sistemas_ag.clientes_ag where num_pedido = '".$result['num_pedido']."'")or die("erro no delete remove pedido unico");
					if($inserir){
						// "ADICIONADO COM SUCESSO";
						echo "1";
					}else{
						// "ERRO AO VINCULAR";
						echo "0";
					}
				}else{
					$insert_status = mysqli_query($con,"insert into sistemas_ag.veiculos_ag (cnpj,num_pedido,qtd_veiculos,cliente) values ('".$cnpj."','".$num_pedido."',1,'".$client."')")or die("erro no insert veiculo");
					
					if($insert_status){
						for($i=1;$i<=$quantity;$i++){
							$pedido_id = $num_pedido."-".$i;
							$veiculo_id = substr($num_pedido,0,4).$dataSecurity;
							$inserir = mysqli_query($con,"insert into sistemas_ag.veiculos_ag (cnpj,num_pedido,qtd_veiculos,id_veiculo,tipo,cliente) values ('".$cnpj."','".$pedido_id."',1,'".$veiculo_id."','VEI','".$client."') on duplicate key update cnpj='".$cnpj."', num_pedido='".$pedido_id."', qtd_veiculos=1, id_veiculo = '".$veiculo_id."'")or die("erro no insert do cadastro do id veiculo2");
							if($inserir){	
								//Carrega o estoque com o novo pedido
								$carregaEstoque = mysqli_query($con,"INSERT INTO sistemas_ag.clientes_ag (num_pedido,nota_fiscal,lote_serial,produto,qtd_disp,lote,unid_medida,pedido,nome_cli,cnpj,endereco,numero,bairro,cep_cli,cidade,cod_id,email_cli,tel_cli,status,palete,cubagem,auth,qtd_composto,forma)
								SELECT '".$pedido_id."',nota_fiscal,lote_serial,produto,qtd_disp,lote,unid_medida,pedido/".$quantity.",nome_cli,cnpj,endereco,numero,bairro,cep_cli,cidade,cod_id,email_cli,tel_cli,status,palete,cubagem/".$quantity.",auth,qtd_composto,forma FROM sistemas_ag.clientes_ag_hist where num_pedido = '".$num_pedido."'")or die("erro no select carregaEstoque");
							}
						}
						$remove = mysqli_query($con,"delete from sistemas_ag.veiculos_ag where num_pedido = '".$num_pedido."'")or die("erro no delete remove pedido unico");
						$remove = mysqli_query($con,"delete from sistemas_ag.clientes_ag where num_pedido = '".$num_pedido."'")or die("erro no delete remove pedido unico");
						$limpa = mysqli_query($con,"truncate sistemas_ag.lista_gerado")or die(mysqli_error($con));
						if($inserir){
							// "ADICIONADO COM SUCESSO";
							echo "1";
						}else{
							// "ERRO AO VINCULAR";
							echo "0";
						}	
					}
				}
		}
		
		//Verifica se a data e hora já tem 6 ou mais veiculos
		if($action == "ChecaDataHora"){
			$date = $_REQUEST['date'];
			
			$sql = mysqli_query($con,"SELECT
    									count(*) linhas,
										mid(a.data,1,10) data,
										trim(mid(a.data,11)) hora,
    									case when hora is null then '0' else hora end Indisponivel
									 FROM sistemas_ag.agendamento_ag a
 										  left join
 										  sistemas_ag.data_block b
 									  on trim(mid(a.data,11,3)) = b.hora and a.data = b.data
									  where mid(a.data,1,10) = '".$date."'
									  group by a.data")or die(mysqli_error($con));
									  
			
				$db_data = array();
				while($result = mysqli_fetch_array($sql)){
					$db_data[] = $result;
				}
				
				echo json_encode($db_data);	
		}
		
		//Retorna a lista de transportadoras do cliente		
		if($action == "listTransp"){
			
			$cnpjCli = $_REQUEST['cnpjCli'];
			
			$sql = mysqli_query($con,"SELECT 
										cnpj_transp,
										razao_social
									  FROM
										sistemas_ag.cad_transp_ag
									  WHERE
										cnpj_cli = '".$cnpjCli."'
										")or die(mysqli_error($con));
			
			$db_data = array();
			while($result = mysqli_fetch_array($sql)){
				$db_data[] = $result;
			}
				
			echo json_encode($db_data);	
		}

		//Função para cadastrar o agendamento
		if($action == "agendamento"){
			
			$pedidos = $_REQUEST['num_pedido'];
			$data = $_REQUEST['data']; //data
			$hora = $_REQUEST['hora']; //hora
			$cnpj = $_REQUEST['cnpjCli'];
			$cliente = $_REQUEST['cliente'];
			$clientes = $_REQUEST['cliente'];
			$perfil = $_REQUEST['perfil'];
			
			$valores = $data." ".$hora;
			
			$cnpj_transp = isset($_REQUEST['cnpjTransp']) ? $_REQUEST['cnpjTransp'] : "";
			$nome_transp = isset($_REQUEST['transp']) ? $_REQUEST['transp'] : "";
			
			$ajudante = $_REQUEST['ajudante'];
			
			$stid = $conAG->query("select  
			 					distinct k.entow_id ID_CLIENTE,
								c.entdf_dsc NAME,
								k.entow_ent_id CNPJ,
								ad.entdfb_str END,
								ad.entdfb_nb NUMERO,
								ad.entdfb_zip CEP,
								ad.entdfb_dst BAIRRO,
								t.entdfc_tel1 TEL,
								ad.entdfb_city_nm CIDADE,
								t.entdfc_email1 EMAIL
							from entow k, entdfb ad, ENTDF c, entdfc t
							where k.entow_ent_id = ad.entdfb_ent_id
							and k.entow_ent_id = t.entdfc_ent_id
							and k.entow_ent_id = c.entdf_id 
							and k.entow_ent_id = '".$cnpj."'");

	
			$stid->execute();			
			$row = $stid->fetch();
			$endereco = $row['END'];
			$numero = $row['NUMERO'];
			$bairro = $row['BAIRRO'];
			$cep_cli = $row['CEP'];
			$cidade = $row['CIDADE'];
			$cod_cli = $row['ID_CLIENTE'];
			$email_cli = $row['EMAIL'];
			$tel_cli = $row['TEL'];
			
			//$endereco = 'ROD SENADOR JOSE ERMIRIO DE MORAES';
			//$numero = '10.2';
			//$bairro = 'IPORANGA';
			//$cep_cli = '18087125';
			//$cidade = 'Sorocaba';
			//$cod_cli = '329';
			//$email_cli = 'COMERCIAL@EADIAURORA.COM.BR';
			//$tel_cli = '15 32354800';			
			
				
			//Verifica se está flegado sem processo
			$pegaId2 = mysqli_query($con,"select id_veiculo, num_pedido, tipo, cliente from sistemas_ag.veiculos_ag where (num_pedido = '".$pedidos."' or id_veiculo = '".$pedidos."')")or die("erro no select pegaId");
			$returnId2 = mysqli_fetch_assoc($pegaId2);
			if($returnId2['id_veiculo'] == "--"){
				$limpaVeiculo = mysqli_query($con,"DELETE FROM `sistemas_ag`.`veiculos_ag` WHERE `num_pedido` = '".$pedidos."'")or die("erro a delete limpaVeiculo");
			}	
			
			//Pega o id_veiculo para unificar os pedidos a um veículo
			$pegaId = mysqli_query($con,"select id_veiculo, num_pedido, tipo, cliente from sistemas_ag.veiculos_ag where (num_pedido = '".$pedidos."' or id_veiculo = '".$pedidos."')")or die("erro no select pegaId");
			$rowId = mysqli_num_rows($pegaId);
			
			if($rowId > 0){
				//$blt = "Y";
				
				$arr1 = array();
				$arr2 = array();
				$returnId = mysqli_fetch_array($pegaId);
				
					if($returnId['tipo'] == 'PED'){
						while($returnIds = mysqli_fetch_array($pegaId)){
							$arr1[] = $returnIds['id_veiculo'];
							$arr2[] = $returnIds['cliente'];
							$qtd_pedida = 1;
						}
						$num_pedido = $returnId['id_veiculo'];
						$cliente = $returnId['cliente'];
						$qtd_pedida = 1;
					}else{
						$num_pedido = $returnId['num_pedido'];
						$cliente = $returnId['cliente'];
						$qv = explode("-",$num_pedido);
						$rn = $qv[0];
						
						$pesqQtd = mysqli_query($con,"select case when sum(qtd_veiculos) is null then 0 else sum(qtd_veiculos) end soma from sistemas_ag.veiculos_ag where num_pedido like '%".$num_pedido."%'")or die("erro no select pesqQtd");
						$qtd_ped = mysqli_fetch_array($pesqQtd);
						$qtd_pedida = $qtd_ped['soma'];
					}
					
				
				
				$pegaQtd = mysqli_query($con,"select sum(qtd_veiculos) qtd_veiculo from sistemas_ag.veiculos_ag where (id_veiculo = '".$num_pedido."' or num_pedido = '".$num_pedido."')")or die("erro no select pegaQtd");
				$returnQtd = mysqli_fetch_array($pegaQtd);
				$qtd_veiculo = intval($returnQtd['qtd_veiculo']);
				
			}else{	
				//$blt = "N";
				$returnId = mysqli_fetch_array($pegaId);
				$num_pedido = $_REQUEST['num_pedido'];
				$qtd_veiculo = 1;
				$qtd_pedida = 1;
			}
				

			$select = mysqli_query($con,"select * from sistemas_ag.coleta_ag where num_pedido = '".$num_pedido."' and cnpj_transp = '".$cnpj_transp."'")or die("erro no select verifica coleta existe");
			$busca_end = mysqli_query($con,"select 
											end_transp,
											numero_transp,
											bairro_transp,
											cid_transp,
											uf_transp,
											cep_transp,
											nome_motor,
											cpf_motor,
											documento_motor,
											cnh_motor,
											data_validade,
											placa,
											pl_carreta,
											pl_bitrem,
											pl_container,
											tel_transp,
											email_transp
										from sistemas_ag.coleta_ag 
										where cnpj_transp = '".$cnpj_transp."' and num_pedido = '".$num_pedido."'")or die("erro no select verifica endereço existe");
			$rows = mysqli_num_rows($select);
			if($cnpj_transp){
				$dados = mysqli_fetch_object($busca_end);
				if($rows > 0){
					$update = mysqli_query($con,"UPDATE `sistemas_ag`.`coleta_ag` SET 
					cnpj_cli='".$cnpj."', 
					cnpj_transp='".$cnpj_transp."', 
					nome_cli='".$cliente."', 
					nome_transp='".$nome_transp."', 
					data_agenda='".$valores."', 
					time_stamp=now(), 
					end_transp='".$dados->end_transp."', 
					numero_transp='".$dados->numero_transp."',
					bairro_transp='".$dados->bairro_transp."', 
					cid_transp='".$dados->cid_transp."', 
					uf_transp='".$dados->uf_transp."',
					cep_transp='".$dados->cep_transp."', 
					nome_motor='".$dados->nome_motor."', 
					cpf_motor='".$dados->cpf_motor."',
					documento_motor='".$dados->documento_motor."', 
					cnh_motor='".$dados->cnh_motor."', 
					data_validade='".$dados->data_validade."',
					placa='".$dados->placa."', 
					pl_carreta='".$dados->pl_carreta."', 
					pl_bitrem='".$dados->pl_bitrem."', 
					pl_container='".$dados->pl_container."',
					tel_transp='".$dados->tel_transp."', 
					email_transp='".$dados->tel_transp."'
					WHERE `num_pedido`='".$num_pedido."';")or die("erro no update verifica coleta existe");
				}
			}
			
			
			$consultAgenda = mysqli_query($con,"select (count(*) + ".$qtd_pedida.") total from sistemas_ag.agendamento_ag where data = '".$valores."'")or die("erro no select consultAgenda");
			$returnAgenda = mysqli_fetch_array($consultAgenda);
			
			$consultPermissao = mysqli_query($con,"select case when permissao is null then '0' else permissao end permissao from sistemas_ag.cad_transp_ag where cnpj_cli = '".$cnpj."' and cnpj_transp = '".$cnpj_transp."'")or die("erro no select consultPermissao");
			$returnPermissao = mysqli_fetch_array($consultPermissao);
			
			if($returnAgenda['total'] <= 6){
				
				if($returnId['tipo'] == 'VEI'){
					//$y = "VEI";
					
					$num = explode("-",$returnId['num_pedido']);
					$nped = $num[0];
					$pegaSub = mysqli_query($con,"select num_pedido from sistemas_ag.veiculos_ag where num_pedido like '%".$returnId['num_pedido']."%'")or die("erro no select pegaSub");
					
					while($resultSub = mysqli_fetch_array($pegaSub)){
						$agendar = mysqli_query($con,"insert into sistemas_ag.agendamento_ag 	(num_pedido,data,cnpj_cli,nome_cli,endereco,numero,bairro,cep_cli,cidade,cod_cli,cnpj_transp,transportadora,email_cli,qtd_veiculos,ajudante,status)
						values
						('".$resultSub['num_pedido']."','$valores','$cnpj','$clientes','$endereco','$numero','$bairro','$cep_cli','$cidade',$cod_cli,'$cnpj_transp','$nome_transp','$email_cli',".$qtd_veiculo.",'".$ajudante."','0');")or die("error no insert do agendamento 2");
					}
				}elseif($returnId['tipo'] == 'PED'){
						//$y = "PED";
						$agendar = mysqli_query($con,"insert into sistemas_ag.agendamento_ag (num_pedido,data,cnpj_cli,nome_cli,endereco,numero,bairro,cep_cli,cidade,cod_cli,cnpj_transp,transportadora,email_cli,qtd_veiculos,ajudante,status)
						select 
							'$num_pedido',
							'$valores',
							 trim(cliente),
							 nome_cli,
							 endereco,
							 numero,
							 bairro,
							 cep_cli,
							 cidade,
							 cod_id,
							'$cnpj_transp',
							'$nome_transp',
							email_cli,
							".$qtd_veiculo.",
							'$ajudante',
							'0' 
						from sistemas_ag.veiculos_ag a inner join sistemas_ag.clientes_ag_hist b
							on a.num_pedido = b.num_pedido where id_veiculo = '".$num_pedido."' 
							group by cliente,id_veiculo")or die("error no insert do agendamento 3 ".mysqli_error($con));
						
					
				}else{
					
					//echo $endereco."<br>";
					//$y = "NULL";
					$agendar = mysqli_query($con,"insert into sistemas_ag.agendamento_ag (num_pedido,data,cnpj_cli,nome_cli,endereco,numero,bairro,cep_cli,cidade,cod_cli,cnpj_transp,transportadora,email_cli,qtd_veiculos,ajudante,status)
					values
					('$pedidos','$valores','$cnpj','$clientes','$endereco','$numero','$bairro','$cep_cli','$cidade',$cod_cli,'$cnpj_transp','$nome_transp','$email_cli',".$qtd_veiculo.",'$ajudante','0');")or die("error no insert do agendamento 4 ".mysqli_error($con));
					
				}
				
				if($agendar){
					sendEmail($num_pedido, "r");
					//echo "1";
				}else{
					echo "0";
				}
				
			}else{
				echo "2";
			}
			
			$conAG = null;
			mysqli_close($con);
		}
		
		
		//Aqui consulto os pedidos que foram agendados
		if($action == "visualizarAgend"){		
			$dataAtual = date('d-m-Y H:i');
			$cnpj = $_REQUEST['cnpj'];
			$category = $_REQUEST['perfil'];
			
			//Aqui verifica a categoria do usuario se é cliente 1 ou transportadora 2
			if($category !== "1"){
				$transp = $cnpj;
				
				
				
				$busca = mysqli_query($con,"select 
												group_concat('''',cnpj_cli,'''') as cnpj_cli, 
												case when permissao is null then '0' else group_concat(permissao) end permissao  
											from sistemas_ag.cad_transp_ag where cnpj_transp = '01777936000196'")or die(mysqli_error($con));
				$rows = mysqli_num_rows($busca);
				if($rows > 0){
					$cnpj_cli = mysqli_fetch_array($busca);
					if($cnpj_cli[0]){
						$cnpj = $cnpj_cli[0];
					}else{
						$cnpj = "SN";
					}
					$permissao = $cnpj_cli[1];
				}
			}else{
				$busca = mysqli_query($con,"select 
												group_concat('''',cnpj_transp,'''') as cnpj_transp, 
												case when permissao is null then '0' else permissao end permissao
											from sistemas_ag.cad_transp_ag where cnpj_cli = '".$cnpj."' ")or die("erro no select busca cliente");
				$rows = mysqli_num_rows($busca);
				if($rows > 0){
					$cnpj_cli = mysqli_fetch_array($busca);
					$transp = $cnpj_cli[0];
					$permissao = $cnpj_cli[1];
				}
			}
			
			//Aqui verifico se o usuário tem mais de um cnpj
			$pos = strpos($cnpj,"'");
			if($pos){
				$busca = "'".$cnpj."'";
			}else{
				$busca = $cnpj;
			}
			
			
			
			//Aqui verifico se o usuário tem mais de uma transportadora
			$tpos = strpos($transp,"'");
			if($tpos){
				$transp = "'".$transp."'";
			}else{
				$transp = $transp;
			}
			
			if($category == "1"){
				$whenAllow = "";
			}else{
				$whenAllow = " and permissao = '1' ";
			}
			
			if($transp){
	
				if($category == "1"){
					$perfil = " b.cnpj_cli ";
					$sql = mysqli_query($con,"select 
													num_pedido,
													data,
													cnpj_cli,
													nome_cli,
													cnpj_transp
												  from sistemas_ag.agendamento_ag where cnpj_cli in (".$busca.") order by length(num_pedido), num_pedido asc")or die("<b style='color: white;'>erro do select de consultar agendamento</b>");
				}else{
					$perfil = " b.cnpj_transp ";
					$verifTransp = "select 
							case when cnpj_cli is null then concat('''''') else group_concat('''',cnpj_cli,'''') end clientes, 
							case when permissao is null then '' else permissao end permissao  
						from sistemas_ag.cad_transp_ag where cnpj_transp  = ".$transp." and permissao = '1'";
		
					$statusPermitido = mysqli_query($con,$verifTransp)or die("erro no select verifTransp");
		
					$permitido = mysqli_fetch_array($statusPermitido);
					$permitidoRows = mysqli_num_rows($statusPermitido);
		
		
					if($permitido['clientes']){
						$per = $permitido['clientes'];
					}else{
						$per = "''";
					}
		
						$sql = mysqli_query($con,"select 
										a.num_pedido,
										a.data,
										a.cnpj_cli,
										a.nome_cli,
										a.cnpj_transp
									from sistemas_ag.agendamento_ag a
										where a.cnpj_cli in (".$busca.") 
											  and case when cnpj_transp = '' then a.cnpj_cli in (".$per.") else a.cnpj_transp end
											  and a.cnpj_transp in (".$transp.",'') 
											  group by a.num_pedido
											  order by length(a.num_pedido), a.num_pedido asc")or die("<b>erro do select de consultar agendamento 3</b>");				
		
				}
		
				$rows = mysqli_num_rows($sql);
	
			}else{
				$perfil = " b.cnpj_cli ";
				$sql = mysqli_query($con,"select 
										num_pedido,
										data,
										cnpj_cli,
										nome_cli,
										cnpj_transp
									  from sistemas_ag.agendamento_ag where cnpj_cli in (".$busca.") order by length(num_pedido), num_pedido asc")or die("<b style='color: white;'>erro do select de consultar agendamento</b>");
				$rows = mysqli_num_rows($sql);
		
			}

	
		if($rows > 0){	
				$id = 0;		  
				while($result = mysqli_fetch_array($sql)){
					extract($result);
					$id = $id + 1;
					
					$diff = strtotime($data) - strtotime($dataAtual);
					$horas = round(($diff/60/60));
					
					$timeLocked = mysqli_query($con,"SELECT 
															a.tempo 
														FROM sistemas_ag.time_clientes a 
															 inner join sistemas_ag.cad_transp_ag b
															 on a.cnpj = $perfil
														where b.cnpj_cli in (".$busca.") 
															  and b.cnpj_transp in (".$transp.")
															  and a.rules = 'BLOC' group by a.cnpj")or die("erro no select timeLocked");
					
					$tempoRes = mysqli_fetch_array($timeLocked);
					$subIn = intval($tempoRes['tempo']);
					if($subIn == 0){
						$sub = 6;
					}else{
						$sub = intval($tempoRes['tempo']);
					}
					
					$pesq = $conAG->query("select 
												iop.document NOTA_FISCAL,
												io.id_in_out CESV,
												TO_CHAR(time_out, 'DD/MM/YYYY HH24:MI') DATA, 
												TO_CHAR(time_release_in, 'DD/MM/YYYY HH24:MI') CHEGADA,
												  case 
													when af.stat = '35' and pf.stat = '41' and max(pf.stat) = '41' then 'EM SEPARACAO'
													when af.stat = '54' and pf.stat = '41' and max(pf.stat) = '41' then 'EM SEPARACAO' 
													when af.stat = '54' and pf.stat = '90' and max(pf.stat) = '90' then 'EM SEPARACAO'
													when af.stat = '35' and pf.stat = '50' and max(pf.stat) = '50' then 'EM SEPARACAO'
													when af.stat = '55' and max(pf.stat) = '90' then 'OP SEPARADO' 
													when af.stat = '74' and pf.stat = '90' and max(pf.stat) = '90' then 'EM CONFERENCIA' 
													when af.stat = '74' and pf.stat = '90' and max(pf.stat) = '97' then 'EM SEPARAÇÃO' 
													when max(pf.stat) = '97' and pf.stat = '97' and af.stat = '84' then 'PP CONFERIDO'
													when af.stat = '75' and pf.stat = '97' and max(pf.stat) = '97' then 'PP CONFERIDO'
													when max(pf.stat) = '97' and pf.stat = '97' and af.stat = '95' and trunc(sysdate) <=  af.time_aen then 'MATERIAL CARREGADO'
													when max(pf.stat) = '97' and pf.stat = '97' and af.stat = '95' and trunc(sysdate) > af.time_aen then 'FINALIZADO'
													else 'AGUARDANDO SEPARACAO' end STATUS    
												from in_out io inner join in_out_pos iop 
												     on io.id_in_out = iop.id_in_out
													 left join pickauf pf
													 on replace(replace(replace(pf.nr_auf, chr(10), ''), chr(13), ''), chr(9), '') = replace(replace(replace(iop.document, chr(10), ''), chr(13), ''), chr(9), '')
													 left join auftraege af
													 on replace(replace(replace(pf.nr_auf, chr(10), ''), chr(13), ''), chr(9), '') = replace(replace(replace(af.nr_auf, chr(10), ''), chr(13), ''), chr(9), '')
												  where  io.stat <> 80 
														/*and time_out is not null*/
														and iop.document is not null
														and iop.document in ('".$num_pedido."')
														group by iop.document,io.id_in_out,time_out,time_release_in,af.stat,pf.stat,af.time_aen");
				

				$pesq->execute();
				$lines = $pesq->fetch();
				$pesq->execute();
				$row = $pesq->fetch();	
						
					if($row['STATUS'] == "FINALIZADO"){
						if($rows == 1){
							echo "test";
							$insertDados = "";
						}
					}else{
						
						$pos = strpos($num_pedido,"_");
			
							if($pos == ""){
								
								$insertDados = mysqli_query($con,"insert into sistemas_ag.lista_agendados 
     														(
																num_pedido, 
																data_agend, 
																cnpj_cli, 
																nome_cli, 
																sub, 
																horas
															)
     														values
     														(
																'".$num_pedido."',
																'".$data."',
																'".$cnpj_cli."',
																'".$nome_cli."',
																".$sub.",
																".$horas."
															)")or die(mysqli_query($con));
								
				

							}else{
								$insertDados = "";
							}
					
					}
				}
				
				if($insertDados != ""){
					$selectDados = mysqli_query($con,"SELECT 
													  	num_pedido,
														data_agend,
														cnpj_cli,
														nome_cli,
														sub,
														horas
													  FROM sistemas_ag.lista_agendados
													  where cnpj_cli in (".$busca.")
													  group by num_pedido")or die(mysqli_error($con));
													  
					$db_data = array();
						while($result = mysqli_fetch_array($selectDados)){
							$db_data[] = $result;
						}
							
					echo json_encode($db_data);	
				}
		}else{
			echo "0";
		}		
	}
	
	//Aqui eu edito a data do agendamento
	if($action == "editarAgend"){
			$dt_agenda = $_REQUEST['data'];
			$hr_agenda = $_REQUEST['hora'];
			$data_hora = $dt_agenda." ".$hr_agenda;
			$pedidos = $_REQUEST['num_pedido'];
			$pos = strpos($pedidos,"-");
			if($pos !== false){
				$ped = explode("-",$pedidos);
				$pedido = $ped[0];
			}else{
				$pedido = $pedidos;
			}
			
			$pegaId = mysqli_query($con,"select id_veiculo, num_pedido, tipo from sistemas_ag.veiculos_ag where num_pedido = '".$pedidos."' ")or die("erro no select pegaId");
			$rowId = mysqli_num_rows($pegaId);
			if($rowId > 0){
				$returnId = mysqli_fetch_array($pegaId);
				if($returnId['tipo'] == 'PED'){
					$qtd_pedida = 1;
				}else{
					$pesqQtd = mysqli_query($con,"select sum(qtd_veiculos) soma from sistemas_ag.veiculos_ag where num_pedido like '%".$pedidos."%'")or die("erro no select pesqQtd");
					$qtd_ped = mysqli_fetch_array($pesqQtd);
					$qtd_pedida = $qtd_ped['soma'];
				}
			}else{
				$qtd_pedida = 1;
			}
			
			$consultAgenda = mysqli_query($con,"select count(*) + ".$qtd_pedida." total from sistemas_ag.agendamento_ag where data = '".$data_hora."'")or die("erro no select consultAgenda");
			$returnAgenda = mysqli_fetch_array($consultAgenda);
			
			
			if($returnAgenda['total'] <= 6){
				//altera data e hora do agendamento 
			
			$historico = mysqli_query($con,"UPDATE `sistemas_ag`.`agendamento_hist` SET `data`='".$data_hora."', time_stamp = now() WHERE `num_pedido` like '%".$pedidos."%'")or die("erro no update do historico do agendamento");
			
				 //altera data e hora do agendamento
				 $update = mysqli_query($con,"UPDATE `sistemas_ag`.`agendamento_ag` SET `data`='".$data_hora."', timestamp = now() WHERE `num_pedido` like '%".$pedidos."%'")or die("error no update data e hora agendamento");  
				
				if($update){ 
				    $limpar = mysqli_query($con,"truncate sistemas_ag.lista_agendados")or die(mysqli_error($con));
					sendEmail($pedidos, "e");
					//echo "1"; 
				}else{ 
					echo "0"; 
				}
			}else{
				echo "2";
			}
	}
	
	//Aqui eu cancelo o agendamento
	if($action == "cancelaAgend"){	
		$pedidos = $_REQUEST['num_pedido'];
		$cliente = $_REQUEST['nomeCli'];
		$data = $_REQUEST['dataAgend'];
		$cnpj = $_REQUEST['cnpjCli'];
		$pos = strpos($pedidos,"-");
		if($pos !== false){
			$ped = explode("-",$pedidos);
			$pedido = $ped[0];
		}else{
			$pedido = $pedidos;
		}
		
		$deletar = mysqli_query($con,"delete from sistemas_ag.agendamento_ag where num_pedido like '%".$pedidos."%'")or die("erro do delete");
		
		
		if($deletar){
			$limpar = mysqli_query($con,"truncate sistemas_ag.lista_agendados")or die(mysqli_error($con));
			sendEmail($pedidos, "c");
			//echo "1";
		}else{
			echo "0";
		}	
	}
	
	//Consulta CNPJ da transportadora para ordem de coleta
	if($action == "cnpjColeta"){
		$cnpj = $_REQUEST['cnpj'];
		
		$sql = "select nome, cep, rua, numero, bairro, cidade, uf, tipo from sistemas_ag.cad_transp_ag a inner join sistemas_ag.transportadora_ag b on cnpj = cnpj_transp where cnpj_transp = '{$cnpj}' group by cnpj_transp";
		$query = mysqli_query($con,$sql);
		$db_data = array();
		while($dados = mysqli_fetch_array($query)){
			$db_data[] = $dados;
		}
		
		echo json_encode($db_data);
	}
	
?>
