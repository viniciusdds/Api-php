<?php
	$action = $_REQUEST["action"];
	//$action = $_POST["acao"];
	
	$con = mysqli_connect("localhost","root","","loginbase");

	if(!$con){
		die("Falha na conexão: ".mysqli_error($con));
		return;
	}
	
	$userAG = "core_11_1"; 
	$passAG = "T3cn1c05p";
	
	//Aqui pego os dados do cliente na base da Alcis para inserir na tabela clienteAG do Mysql
	$tnsAG = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.20.220.43)(PORT=1521)) (CONNECT_DATA=(SID=alcisagprd)))";
	try {
		$conAG = new PDO('oci:dbname='.$tnsAG,$userAG,$passAG);
		$conAG->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Conectado AG<br>";
	} catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
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
		
		$sql = mysqli_query($con,"select 	
									 tb_data,
									 tb_cnpj,
									 mid(tb_empresa,1,20) tb_empresa,
									 tb_nome,
									 tb_cpf,
									 tb_senha,
									 tb_email,
									 tb_ativado,
									 tb_nivel_usuario,
									 logado,
									 tb_solicitacao
								  from loginbase.new_usuarios_ag where tb_cpf = '".$usuario."' and tb_senha = '".$senha."'");
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
								
								if(substr($cub['CUBAGEM'],0,1) == ","){
									$cubagem = "0".$cub['CUBAGEM'];
								}else{
									$cubagem = $cub['CUBAGEM'];
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
			$insert = false;
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
	
	//Aqui faz o cadastro dos pedidos
	if($action == "cadastrarPedido"){
		$nota_fiscal = $_REQUEST['nota_fiscal'];
		$lote_serial = $_REQUEST['lote_serial'];
		$produto = $_REQUEST['produto'];
		$qtd_disp = $_REQUEST['qtd_disp'];
		$lote = $_REQUEST['lote'];
		$unidade = $_REQUEST['unidade'];
		$cnpj = $_REQUEST['cnpj'];
		$cubagem = $_REQUEST['cubagem'];
		$palete = $_REQUEST['palete'];
		$auth = $_REQUEST['auth'];
		$empresa = $_REQUEST['empresa'];
		
		
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
		
		
		$alias = str_replace(" ","",$empresa);
		$name = substr($alias,0,6);
	
		$insert = mysqli_query($con,"insert into sistemas_ag.num_pedido (id,prefixo) values (1,'$name') on duplicate key update id = id + 1");
		
		if($insert){
			$sql = mysqli_query($con,"select id, prefixo from sistemas_ag.num_pedido where prefixo = '".$name."' order by id desc limit 1");
			$valores = mysqli_fetch_array($sql);
			$id = $valores['id'];
			$prefix = $valores['prefixo'];
			
			$num_pedido = $prefix.$id;
			//echo $client_id." - ".$nota_fiscal." - ".$lote_serial." - ".$produto." - ".$qtd_disp." - ".$lote." - ".$unidade." - ".$cnpj." - ".$cubagem." - ".$palete." - ".$email_cli." - ".$end_cli." - ".$numero_cli." - ".$bairro_cli." - ".$tel_cli." - ".$cep_cli." - ".$cidade_cli;
			
		$auth = $_REQUEST['auth'];
		$empresa = $_REQUEST['empresa'];;
			
			
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
			
				if($cadastrar){
					$limpar = mysqli_query($con,"delete from sistemas_ag.lista_pedidos_ag");
					$removerDunble = mysqli_query($con,"delete a from sistemas_ag.clientes_ag a, sistemas_ag.clientes_ag b where a.counter < b.counter and a.palete = b.palete and a.nota_fiscal = '".$nota_fiscal."'");
					echo "1";
				}else{
					echo mysqli_error($con);
				}
			
		}else{
			echo "2";
		}
		
		
	}
	
		
?>
