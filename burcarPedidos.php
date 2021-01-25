<?php 
	function buscarPedidos($categoria, $cnpj, $con, $conAG){
		$busca = "";
		
		if($categoria == "1"){
				//Perfil Cliente
				$buscaTransp = mysqli_query($con,"SELECT * FROM sistemas_ag.cad_transp_ag where cnpj_cli = '".$cnpj."'")or die("erro no select buscaTransp");
						
				$vinculo = mysqli_num_rows($buscaTransp);
					
				$when = " = '".$cnpj."'";
				$inner = " = '".$cnpj."'";
						   
				$verCont = mysqli_query($con,"select count(*) contLine, num_pedido from sistemas_ag.clientes_ag where num_pedido like '%.%' and num_pedido like '%-%' and palete != '--' and cnpj = '".$cnpj."'")or die("erro no select verCont");
				$resCont = mysqli_fetch_array($verCont);
							
			   //Consulta do pedido gerados pelo cliente
			   $sql = mysqli_query($con,"(SELECT 
												a.num_pedido as num_pedido,
												nota_fiscal as nota_fiscal,
												lote_serial as lote_serial,
												produto as produto,
														
												-- Pegar a quantidade disponivel
												case when qtd_disp = (select 
											    case when produto like '%KIT%' and qtd_disp < qtd_composto then 		  (sum(pedido)/qtd_disp) 
								  			    when sum(qtd_disp) = (qtd_composto) then 0
												else
												    coalesce(sum(pedido),0) end soma 
												    from sistemas_ag.clientes_ag where nota_fiscal = a.nota_fiscal and produto = a.produto and lote = a.lote)
												then  
													qtd_disp - qtd_disp
												else 
													qtd_disp - (select 
												case when produto like '%KIT%' and qtd_disp < qtd_composto then (sum(pedido)/qtd_disp) 
																			when sum(qtd_disp) = (qtd_composto) then qtd_disp
																			else
																			coalesce(sum(pedido),0) end soma
																		from sistemas_ag.clientes_ag where nota_fiscal = a.nota_fiscal 
																									 and produto = a.produto 
																									 and lote = a.lote) 
														end qtd_disp,
														
														lote as lote,
														unid_medida as unid_medida,
														
														-- Condição para pegar a quantidade pedida   
														case when a.num_pedido like '%-%' and a.num_pedido like '%.%' 
														and qtd_disp = ((SELECT sum(pedido) FROM sistemas_ag.clientes_ag where palete != '--' 
														and palete = a.palete and nota_fiscal = a.nota_fiscal and produto = a.produto 
														group by lote,nota_fiscal,produto))
														and palete <> '--' and  (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal, produto, num_pedido order by c desc limit 1)
														= count(a.num_pedido)   and (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal and num_pedido = a.num_pedido  group by nota_fiscal, produto) =  (select totalUZ from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal   group by nota_fiscal, produto order by totalUZ desc limit 1)
														or  
														qtd_disp = ((SELECT sum(pedido) FROM sistemas_ag.clientes_ag where palete != '--' 
														and palete = a.palete and nota_fiscal = a.nota_fiscal and produto = a.produto 
														group by lote,nota_fiscal,produto))
														and palete <> '--' and  (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal, produto, num_pedido order by c desc limit 1)
														= count(a.num_pedido)   and (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal and num_pedido = a.num_pedido  group by nota_fiscal, produto) =  (select totalUZ from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal   group by nota_fiscal, produto order by totalUZ desc limit 1)
														then
															sum(pedido)  - (select sum(pedido) from sistemas_ag.clientes_ag where case when totalUZ is null 
															then palete = '--' else 0 end and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal,produto,lote)
														else
															 sum(pedido)
														end as pedido,
														
														a.status as status,
														b.status as statusb,
														cnpj as cnpj,
														a.nome_cli as nome_cli,
														a.endereco as endereco,
														a.numero as numero,
														a.bairro as bairro,
														a.cep_cli as cep_cli,
														a.cidade as cidade,
														cod_id as cod_id,
														a.email_cli as email_cli,
														data as data,
														palete as palete,
														a.time_stamp as time_stamp,
														b.timestamp as timestamp,
														
														-- pegar quantidade de palete mais o tipo de cubagem
														case when palete = '--' and a.cubagem = '0' then 'QT *' 
														when a.cubagem = 0 and a.num_pedido not like '%-%' and a.num_pedido not like '%.%' then concat(cast(count(a.num_pedido) as char),' PP *') 
														when a.cubagem = 0 and a.num_pedido like '%-%' and a.num_pedido like '%.%' and a.palete != '--' then '".$resCont['contLine']." PP *'
														when (select count(*) from sistemas_ag.clientes_ag where palete <> '--' and
														palete = a.palete group by palete) > 1 
														then
														concat(cast(count(a.num_pedido) as char),' PP *') 
														else concat('QG: ',cast(count(a.num_pedido) as char),' | ',sum(a.cubagem)) end cubagem,
														
														b.cnpj_transp as cnpj_transp,
														case when 
														(select count(*) from sistemas_ag.clientes_ag where forma = 'TUDO' 
															and nota_fiscal = a.nota_fiscal
														) > 0  then 0 else (qtd_disp - max(qtd_composto))  end as sobra,
														totalUZ as totalUZ
													from
														sistemas_ag.clientes_ag a left join
														sistemas_ag.agendamento_ag b on a.num_pedido = b.num_pedido
													where 
														cnpj ".$when." and 
														(a.num_pedido like '%".$busca."%'
														or nota_fiscal like '%".$busca."%'
														or produto like '%".$busca."%'
														or lote_serial like '%".$busca."%')
														and a.status = '1' group by a.num_pedido,produto,lote_serial,lote,nota_fiscal) 
													union
													(SELECT 
														a.num_pedido,
														nota_fiscal,
														lote_serial,
														produto,
														
														-- Pegar a quantidade disponivel
														case when qtd_disp = (select sum(pedido) from sistemas_ag.clientes_ag where nota_fiscal = a.nota_fiscal and produto = a.produto and lote = a.lote)
														then  
															qtd_disp - qtd_disp
														else 
															qtd_disp - (select sum(pedido) from sistemas_ag.clientes_ag where nota_fiscal = a.nota_fiscal and produto = a.produto and lote = a.lote) 
														end qtd_disp,
														
														lote,
														unid_medida,
														
														-- Condição para pegar a quantidade pedida   
														case when a.num_pedido like '%-%' and a.num_pedido like '%.%' 
														and qtd_disp = ((SELECT sum(pedido) FROM sistemas_ag.clientes_ag where palete != '--' 
														and palete = a.palete and nota_fiscal = a.nota_fiscal and produto = a.produto 
														group by lote,nota_fiscal,produto))
														and palete <> '--' and  (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal, produto, num_pedido order by c desc limit 1)
														= count(a.num_pedido)   and (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal and num_pedido = a.num_pedido  group by nota_fiscal, produto) =  (select totalUZ from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal   group by nota_fiscal, produto order by totalUZ desc limit 1)
														or 
														qtd_disp = ((SELECT sum(pedido) FROM sistemas_ag.clientes_ag where palete != '--' 
														and palete = a.palete and nota_fiscal = a.nota_fiscal and produto = a.produto 
														group by lote,nota_fiscal,produto))
														and palete <> '--' and  (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal, produto, num_pedido order by c desc limit 1)
														= count(a.num_pedido)   and (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal and num_pedido = a.num_pedido  group by nota_fiscal, produto) =  (select totalUZ from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal   group by nota_fiscal, produto order by totalUZ desc limit 1)
														then
															sum(pedido)  - (select sum(pedido) from sistemas_ag.clientes_ag where case when totalUZ is null 
															then palete = '--' else 0 end and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal,produto,lote)
														else
															(select  sum(pedido) from sistemas_ag.clientes_ag where num_pedido = a.num_pedido and nota_fiscal = a.nota_fiscal and produto = a.produto and lote = a.lote group by lote )
														end as pedido,
														
														a.status,
														b.status,
														cnpj,
														a.nome_cli,
														a.endereco,
														a.numero,
														a.bairro,
														a.cep_cli,
														a.cidade,
														cod_id,
														a.email_cli,
														data,
														palete,
														a.time_stamp,
														b.timestamp,
														
														-- pegar quantidade de palete mais o tipo de cubagem
														case when palete = '--' and a.cubagem = '0' 
														and (SELECT count(*) FROM sistemas_ag.clientes_ag where num_pedido = a.num_pedido and length(palete) > 2) = 0
														then 
															'QT *' 
														when a.cubagem = 0 and a.num_pedido not like '%-%' and a.num_pedido not like '%.%' 
														then 
															concat(cast(count(a.num_pedido) as char),' PP *') 
														when a.cubagem = 0 and a.num_pedido like '%-%' and a.num_pedido like '%.%' and a.palete != '--' 
														then 
															'".$resCont['contLine']." PP *' 
														when (select count(*) from sistemas_ag.clientes_ag where palete <> '--' and
														palete = a.palete group by palete) > 1
														then
															concat(cast(count(a.num_pedido) as char),' PP *') 
														else concat('QG: ',cast(count(a.num_pedido) as char),' | ',sum(a.cubagem)) end,
														
														b.cnpj_transp,
														case when (select count(*) from sistemas_ag.clientes_ag where forma = 'TUDO' 
															and nota_fiscal = a.nota_fiscal
														) > 0  then 0 else (qtd_disp - max(qtd_composto))  end as sobra,
														totalUZ as totalUZ
													from
														sistemas_ag.clientes_ag a left join
														sistemas_ag.agendamento_ag b on a.num_pedido = b.num_pedido
													where 
														cnpj ".$when." and 
														(a.num_pedido like '%".$busca."%'
														or nota_fiscal like '%".$busca."%'
														or produto like '%".$busca."%'
														or lote_serial like '%".$busca."%')
														and a.status = '2' group by a.num_pedido,produto,lote_serial,lote,nota_fiscal)
														order by status asc, statusb asc, timestamp asc,  mid(num_pedido,7) asc, mid(num_pedido,1) asc, lote asc limit 200")or die("erro no select verifica pedido");			
			}else{
								//Perfil Transportadora
								$vinculo = "1";
								
										$truck = mysqli_query($con,"SELECT case when count(*) = 1 then group_concat('''',cnpj_cli,'''')
															   else group_concat('''',cnpj_cli,'''') end as cliente_id, 
																case when permissao is null then '0' else permissao end permissao
														 FROM sistemas_ag.cad_transp_ag where cnpj_transp = '".$cnpj."'")or die("erro no select truck");
							$request = mysqli_fetch_array($truck);
							
							$verifTransp = mysqli_query($con,"select case when group_concat('''',cnpj_cli,'''') is null then concat('''''') else group_concat('''',cnpj_cli,'''') end clientes, permissao from sistemas_ag.cad_transp_ag where cnpj_transp  = '".$cnpj."' and permissao = '1'")or die("erro no select verifTransp");
							
							$permitido = mysqli_fetch_array($verifTransp);
							
							//Verifico se a transportadora tem vinculo com algum cliente
							if($request['cliente_id']){
								$inner = " in (".$request['cliente_id'].") ";
								$when = " in (".$request['cliente_id'].") and (b.cnpj_transp in ('".$cnpj."','') or b.num_pedido is null) ";
							}else{
								$inner = " in ('') ";
								$when = " = ''";
							}
							
							
							$verCont = mysqli_query($con,"select count(*) contLine, num_pedido from sistemas_ag.clientes_ag where num_pedido like '%.%' and num_pedido like '%-%' and palete != '--' and cnpj ".$inner." ")or die("erro no select verCont");
							$resCont = mysqli_fetch_array($verCont);
							
							//Consulta do pedido gerados pelo cliente
							$sql = mysqli_query($con,"(SELECT 
														a.num_pedido as num_pedido,
														nota_fiscal as nota_fiscal,
														lote_serial as lote_serial,
														produto as produto,
														
														-- Pegar a quantidade disponivel
														case when qtd_disp = (select sum(pedido) from sistemas_ag.clientes_ag where nota_fiscal = a.nota_fiscal and produto = a.produto and lote = a.lote)
														then  
															qtd_disp - qtd_disp
														else 
															qtd_disp - (select sum(pedido) from sistemas_ag.clientes_ag where nota_fiscal = a.nota_fiscal and produto = a.produto and lote = a.lote) 
														end qtd_disp,
														
														lote as lote,
														unid_medida as unid_medida,

														-- Condição para pegar a quantidade pedida   
														case when a.num_pedido like '%-%' and a.num_pedido like '%.%' 
														and qtd_disp = ((SELECT sum(pedido) FROM sistemas_ag.clientes_ag where palete != '--' 
														and palete = a.palete and nota_fiscal = a.nota_fiscal and produto = a.produto 
														group by lote,nota_fiscal,produto))
														and palete <> '--' and  (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal, produto, num_pedido order by c desc limit 1)
														= count(a.num_pedido)   and (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal and num_pedido = a.num_pedido  group by nota_fiscal, produto) =  (select totalUZ from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal   group by nota_fiscal, produto order by totalUZ desc limit 1)
														or qtd_disp = ((SELECT sum(pedido) FROM sistemas_ag.clientes_ag where palete != '--' 
														and palete = a.palete and nota_fiscal = a.nota_fiscal and produto = a.produto 
														group by lote,nota_fiscal,produto)) and palete <> '--' and  (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal, produto, num_pedido order by c desc limit 1)
														= count(a.num_pedido)   and (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal and num_pedido = a.num_pedido  group by nota_fiscal, produto) =  (select totalUZ from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal   group by nota_fiscal, produto order by totalUZ desc limit 1)
														then
															sum(pedido)  - (select sum(pedido) from sistemas_ag.clientes_ag where case when totalUZ is null 
															then palete = '--' else 0 end and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal,produto,lote)
														else
															(select  sum(pedido) from sistemas_ag.clientes_ag where num_pedido = a.num_pedido and nota_fiscal = a.nota_fiscal and produto = a.produto and lote = a.lote group by lote)
														end as pedido,
									
									
														a.status as status,
														b.status as statusb,
														cnpj as cnpj,
														a.nome_cli as nome_cli,
														a.endereco as endereco,
														a.numero as numero,
														a.bairro as bairro,
														a.cep_cli as cep_cli,
														a.cidade as cidade,
														cod_id as cod_id,
														a.email_cli as email_cli,
														data as data,
														palete as palete,
														a.time_stamp as time_stamp,
														b.timestamp as timestamp,
														
														case when palete = '--' and a.cubagem = '0' 
														and (SELECT count(*) FROM sistemas_ag.clientes_ag where num_pedido = a.num_pedido and length(palete) > 2) = 0
														then 
															'QT *' 
														when a.cubagem = 0 and a.num_pedido not like '%-%' and a.num_pedido not like '%.%' 
														then 
															concat(cast(count(a.num_pedido) as char),' PP *') 
														when a.cubagem = 0 and a.num_pedido like '%-%' and a.num_pedido like '%.%' and a.palete != '--' 
														then 
															'".$resCont['contLine']." PP *'
														when (select count(*) from sistemas_ag.clientes_ag where palete <> '--' and
														palete = a.palete group by palete) > 1
														then
															concat(cast(count(a.num_pedido) as char),' PP *') 									
														else concat('QG: ',cast(count(a.num_pedido) as char),' | ',sum(a.cubagem)) end cubagem,
														
														case when b.cnpj_transp is null then '0' else b.cnpj_transp end as cnpj_transp
													from
														sistemas_ag.clientes_ag a left join
														sistemas_ag.agendamento_ag b on a.num_pedido = b.num_pedido
													where 
														cnpj ".$when." and 
														(a.num_pedido like '%".$busca."%'
														or nota_fiscal like '%".$busca."%'
														or produto like '%".$busca."%'
														or lote_serial like '%".$busca."%')
														and a.status = '2'  group by a.num_pedido,produto,lote_serial,lote,nota_fiscal) 
													union
													(SELECT 
														a.num_pedido,
														nota_fiscal,
														lote_serial,
														produto,
														
														-- Pegar a quantidade disponivel
														case when qtd_disp = (select sum(pedido) from sistemas_ag.clientes_ag where nota_fiscal = a.nota_fiscal and produto = a.produto and lote = a.lote)
														then  
															qtd_disp - qtd_disp
														else 
															qtd_disp - (select sum(pedido) from sistemas_ag.clientes_ag where nota_fiscal = a.nota_fiscal and produto = a.produto and lote = a.lote) 
														end qtd_disp,
														
														lote,
														unid_medida,
														
														-- Condição para pegar a quantidade pedida   
														case when a.num_pedido like '%-%' and a.num_pedido like '%.%' 
														and qtd_disp = ((SELECT sum(pedido) FROM sistemas_ag.clientes_ag where palete != '--' 
														and palete = a.palete and nota_fiscal = a.nota_fiscal and produto = a.produto 
														group by lote,nota_fiscal,produto))
														and palete <> '--' and  (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal, produto, num_pedido order by c desc limit 1)
														= count(a.num_pedido)   and (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal and num_pedido = a.num_pedido  group by nota_fiscal, produto) =  (select totalUZ from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal   group by nota_fiscal, produto order by totalUZ desc limit 1)
														or  
														qtd_disp = ((SELECT sum(pedido) FROM sistemas_ag.clientes_ag where palete != '--' 
														and palete = a.palete and nota_fiscal = a.nota_fiscal and produto = a.produto 
														group by lote,nota_fiscal,produto))
														and palete <> '--' and  (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal, produto, num_pedido order by c desc limit 1)
														= count(a.num_pedido)   and (select count(*) c from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal and num_pedido = a.num_pedido  group by nota_fiscal, produto) =  (select totalUZ from sistemas_ag.clientes_ag 
														where palete <> '--' and produto = a.produto and nota_fiscal = a.nota_fiscal   group by nota_fiscal, produto order by totalUZ desc limit 1)
														then
															sum(pedido)  - (select sum(pedido) from sistemas_ag.clientes_ag where case when totalUZ is null 
															then palete = '--' else 0 end and nota_fiscal = a.nota_fiscal and produto = a.produto group by nota_fiscal,produto,lote)
														else
															 sum(pedido)
														end as pedido,
													
														a.status,
														b.status,
														cnpj,
														a.nome_cli,
														a.endereco,
														a.numero,
														a.bairro,
														a.cep_cli,
														a.cidade,
														cod_id,
														a.email_cli,
														data,
														palete,
														a.time_stamp,
														b.timestamp,
														
														case when palete = '--' and a.cubagem = '0' then 'QT *' 
														when a.cubagem = 0 and a.num_pedido not like '%-%' and a.num_pedido not like '%.%' then concat(cast(count(a.num_pedido) as char),' PP *') 
														when a.cubagem = 0 and a.num_pedido like '%-%' and a.num_pedido like '%.%' and a.palete != '--' then '".$resCont['contLine']." PP *' 
														when (select count(*) from sistemas_ag.clientes_ag where palete <> '--' and
														palete = a.palete group by palete) > 1
														then
														concat(cast(count(a.num_pedido) as char),' PP *') 
														else concat('QG: ',cast(count(a.num_pedido) as char),' | ',sum(a.cubagem)) end,
														
														case when b.cnpj_transp is null then '0' else b.cnpj_transp end
													from
														sistemas_ag.clientes_ag a left join
														sistemas_ag.agendamento_ag b on a.num_pedido = b.num_pedido
													where 
														cnpj ".$when." and 
														(a.num_pedido like '%".$busca."%'
														or nota_fiscal like '%".$busca."%'
														or produto like '%".$busca."%'
														or lote_serial like '%".$busca."%')
														and a.status = '1'  group by a.num_pedido,produto,lote_serial,lote,nota_fiscal)
														order by status asc, statusb asc, timestamp asc,  mid(num_pedido,7) asc, mid(num_pedido,1) asc, lote asc limit 200")or die("erro no select verifica pedido");
						
							$tras = mysqli_num_rows($sql);

							if($tras > 0){
									//Aqui verifico as permissões do pedidos com agendamento
									$buscaPermissao1 = mysqli_query($con,"select 
																			a.num_pedido
																		from sistemas_ag.agendamento_ag a
																			where a.cnpj_cli in (".$request['cliente_id'].")
																				  and case when cnpj_transp = '' then a.cnpj_cli in (".$permitido['clientes'].") else a.cnpj_transp end
																				  and a.cnpj_transp in ('".$cnpj."','') 
																				  group by a.num_pedido
																				  order by length(a.num_pedido), a.num_pedido asc")or die("erro no select buscaPermissao1");
																				  
									$resPermissao1 = mysqli_num_rows($buscaPermissao1);
									if($resPermissao1 > 0){
										while($infPermissao1 = mysqli_fetch_array($buscaPermissao1)){
											$pedidoPermitido1[] = $infPermissao1['num_pedido'];
										}
									}else{
										$pedidoPermitido1[] = "";
									}
									
									//Aqui verifico as permissões do pedidos sem agendamento
									$buscaPermissao2 = mysqli_query($con,"SELECT 
																				b.num_pedido 
																			FROM sistemas_ag.cad_transp_ag a inner join sistemas_ag.clientes_ag b
																			on a.cnpj_cli = b.cnpj 
																			left join sistemas_ag.agendamento_ag c
																			on b.num_pedido = c.num_pedido
																			where a.cnpj_transp = '".$cnpj."' and permissao = '1' and c.cnpj_transp is null")or die("erro no select buscaPermissao2");
																			
									$resPermissao2 = mysqli_num_rows($buscaPermissao2);
									if($resPermissao2 > 0){
										while($infPermissao2 = mysqli_fetch_array($buscaPermissao2)){
											$pedidoPermitido2[] = $infPermissao2['num_pedido'];
										}
									}else{
										$pedidoPermitido2[] = "";
									}	
							}else{
								$pedidoPermitido1[] = "";
								$pedidoPermitido2[] = "";
							}
			}
					
					$check = mysqli_num_rows($sql);
					
					if($check > 0){
						$id = 0;
						while($result = mysqli_fetch_object($sql)){	
							$id = $id+1;
				
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
																	and iop.document in ('".$result->num_pedido."')
																	group by iop.document,io.id_in_out,time_out,time_release_in,af.stat,pf.stat,af.time_aen");
							

							$pesq->execute();	   
							$lines = $pesq->fetch();			
							$pesq->execute();
							$row = $pesq->fetch();
				
							//Aqui verifico tem tem mais de um pedido para o mesmo código
							$arr[] = $result->num_pedido;
							$teste = array_count_values($arr);
							foreach($teste as $value){
							}
				
				
							//Aqui verifico de o pedido já deu saida na GT100
							if($row['STATUS'] == "FINALIZADO"){
								echo "";
							}else{
								
								//Verifica se o veiculo foi checado pelo cliente
								$buscaVeiculo = mysqli_query($con,"select * from sistemas_ag.veiculos_ag where (id_veiculo = '".$result->num_pedido."' or num_pedido = '".$result->num_pedido."')")or die("erro no select busca veiculo");
								$linhasVeiculo = mysqli_num_rows($buscaVeiculo);
								$idVeiculo = mysqli_fetch_array($buscaVeiculo);
									
								$pos = strpos($result->num_pedido,"_");
								if($pos == ""){
									
									//Aqui recupero o item pai para pegar a quantidade total
									$itemsCompostos = mysqli_query($con,"SELECT composto FROM sistemas_ag.itens_composto where itens = '".$result->produto."' and nota = '".$result->nota_fiscal."'")or die("erro no select itemsComposto");
									$itemPai = mysqli_fetch_array($itemsCompostos);
						
									$docit = $conAG->query("select 
																doc.dochd_doc_prc_id,
																case when s.sfcab_avl_bal_qt is null then di.docit_qt  else s.sfcab_avl_bal_qt  end QTD, 
																doc.dochd_doc_id NF_ENTRADA, 
																doc.dochd_doc_id ITEM_PAI
															from sfcab s right join dochd doc
																 on s.sfcab_doc_prc_id = doc.dochd_doc_prc_id
																 inner join docit di
																 on doc.dochd_doc_prc_id = di.docit_doc_prc_id
															where doc.dochd_doc_id = '".$result->nota_fiscal."'
																 and di.docit_cd = '".trim($itemPai['composto'])."'
																 group by 
																 s.sfcab_avl_bal_qt, 
																 doc.dochd_doc_id, 
																 doc.dochd_doc_id,
																 di.docit_qt,
																 doc.dochd_doc_prc_id");
									$docit->execute();
									$qtdComposto = $docit->fetch();
									
									//Aqui pego a quantidade disponivel
									$itensCompostos = mysqli_query($con,"select 
																				".$qtdComposto['QTD']." - max(qtd_composto) disp
																				from sistemas_ag.clientes_ag where nota_fiscal = '".$result->nota_fiscal."'")or die("erro no select itensCompostos");
									
									$verifyKIT = strpos($result->produto,"KIT");
									$qtdCompostos = mysqli_fetch_array($itensCompostos);
									
									//Aqui eu pego a quantidade geral para trocar
									$totaisPedidos = mysqli_query($con,"select qtd_pedida REST from sistemas_ag.qtd_composto where num_pedido = '".$result->num_pedido."' and nota_fiscal = '".$result->nota_fiscal."'")or die("erro no select totaisPedidos");
									$numeroPedidos = mysqli_num_rows($totaisPedidos);
									if($numeroPedidos > 0){
										$resultsPedidos = mysqli_fetch_array($totaisPedidos);
										if($qtdCompostos['disp'] >= $resultsPedidos['REST']){
											$qtdParaTroca = $qtdCompostos['disp'] + $resultsPedidos['REST'];
										}else{
											$qtdParaTroca = $resultsPedidos['REST'] + $qtdCompostos['disp'];
										}
									}else{
										$qtdParaTroca = $qtdComposto['QTD'];
									}
									
									
									//Verifico se o item é composto
									if($verifyKIT){
										$qtdDisp = $qtdCompostos['disp'];
									}else{
										$qtdDisp = round($result->qtd_disp) <= 0 ? "0" : round($result->qtd_disp);
									}
									
									//Retorna para Cliente
									if($categoria == "1"){
																					
												//Valido se tem mais de um código para o mesmo número do pedido		
												if($value == 1){
													
												   $numPedido = $result->num_pedido." / ";					
													
												}else{
													$numPedido = "";
												}			
													
								
																
															$insere = mysqli_query($con,"insert into sistemas_ag.lista_gerado 
																								 (
																									num_pedido,
																									nota_fiscal,
																									lote_serial,
																									produto,
																									qtd_disp,
																									lote,
																									unid_medida,
																									pedido,
																									cubagem,
																									cnpj,
																									status, 
																									data,
																									palete
																								 )
																								 values
																								 (
																									'".$result->num_pedido."',
																									'".$result->nota_fiscal."',
																									'".$result->lote_serial."',
																									'".$result->produto."',
																									".$qtdDisp.",
																									'".$result->lote."',
																									'".$result->unid_medida."',
																									'".round($result->pedido, 2)."',
																									'".$result->cubagem."',
																									'".$cnpj."',
																									'".$result->status."',
																									'".$result->data."',
																									'".$result->palete."'
																								 )")or die(mysqli_error($con));
																	
									//Retorna para transportadora
									}else{
										
										
																
											if(!in_array($result->num_pedido,$pedidoPermitido1) && !in_array($result->num_pedido,$pedidoPermitido2)){
												echo "";
											}else{
														
												//Valido se tem mais de um código para o mesmo número do pedido
												if($value == 1){
													$numPedido = $result->num_pedido." / ";
												}else{
													$numPedido = "";
												}
												
													
													$insere = mysqli_query($con,"insert into sistemas_ag.lista_gerado 
																							 (
																								num_pedido,
																								nota_fiscal,
																								lote_serial,
																								produto,
																								qtd_disp,
																								lote,
																								unid_medida,
																								pedido,
																								cubagem,
																								cnpj,
																								status, 
																								data,
																								palete
																							 )
																							 values
																							 (
																								'".$result->num_pedido."',
																								'".$result->nota_fiscal."',
																								'".$result->lote_serial."',
																								'".$result->produto."',
																								".$qtdDisp.",
																								'".$result->lote."',
																								'".$result->unid_medida."',
																								'".round($result->pedido, 2)."',
																								'".$result->cubagem."',
																								'".$cnpj."',
																								'".$result->status."',
																								'".$result->data."',
																								'".$result->palete."'
																							 )")or die(mysqli_error($con));
										
											}
									}
								}else{
									echo "";
								}
							}// fim do else status finalizado Alcis
				
						}// fim do While
						
						if($categoria == "1"){
							$db_data = array();
							$queryPedidos = mysqli_query($con,"select  
															num_pedido,
															group_concat(DISTINCT '(',nota_fiscal,' - ', produto,' - ', lote,'\n', cubagem,' - ', unid_medida,' - ', pedido,')\n\n' ORDER BY lote SEPARATOR '') infoES,
															max(status) status,
															data
														from sistemas_ag.lista_gerado 
														where cnpj = '".$cnpj."'
														and status <> '3'											
														group by num_pedido");
						}else{
							$db_data = array();
							$queryPedidos = mysqli_query($con,"select  
															num_pedido,
															group_concat(DISTINCT '(',nota_fiscal,' - ', produto,' - ', lote,'\n', cubagem,' - ', unid_medida,' - ', pedido,')\n\n' ORDER BY lote SEPARATOR '') infoES,
															max(status) status,
															data
														from sistemas_ag.lista_gerado 
														where cnpj = '".$cnpj."'
														and status = '2'											
														group by num_pedido");
						}
						
									
						while($result = mysqli_fetch_array($queryPedidos)){
							$db_data[] = $result;
						}
						
						echo json_encode($db_data);
						
					}else{
						echo "0";
					}// fim do if do check		
	}
?>