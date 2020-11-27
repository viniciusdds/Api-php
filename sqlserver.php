<?php

$con = mysqli_connect("localhost","root","","loginbase")or die("Erro na conexão com o banco MySql");

$db_user_pass = 'wms_eadi';

$db_connect = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.20.220.32)(PORT=1522)) (CONNECT_DATA=(SID=ALCISSTB)))';
try {
	$connect = new PDO('oci:dbname='.$db_connect,$db_user_pass,$db_user_pass);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//echo "Conectado AD<br>";
	
} catch(PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
}
	
$inicio = "01/10/2020";	
$fim = "31/10/2020";	
	
$connection_string = 'DRIVER={SQL Server};SERVER=192.168.144.157;DATABASE=DADOSADV12';
$user = 'aurora';
$pass = 'aurora@!';
$conn = odbc_connect( $connection_string, $user, $pass ) or die('erro'); 
if($conn >0)
{

  $sql = "SELECT 
			  SV.ORIGEM 
			  ,SV.NFE
			  -- ,SV.[TIPO PRODUTO]
			  ,SV.COD_CLIENTE
			  ,SV.CNPJ_CLI 
			  ,SUBSTRING([TIPO SERVICO],1,2) SERVICO
			  ,SV.DSC_CLI
			  ,SV.CCUSTO
			  -- ,SV.PRODUTO
			  ,SV.[TIPO SERVICO] 
			  ,SUBSTRING([TIPO SERVICO],6,30) TIPO_SERV
			  ,SV.EMISSAO
			  ,SV.SAIDA
			  ,sum(SV.[VALOR ITEM]) VALOR_ITEM
			  ,(select sum([VALOR ITEM]) from VW_FAT_AURORA where [TIPO PRODUTO] like '%04%' AND ORIGEM in ('02 - FARM','01 - EADI','04 - MWMS') AND COD_CLIENTE = /*'000848'*/ SV.COD_CLIENTE and NFE = /*'137228'*/ SV.NFE and EMISSAO between '20201001' and '20201031') VLR_ARMAZ
			  ,(select sum([VALOR ITEM]) from VW_FAT_AURORA where CD_PRODUTO = 'SVAT000085' AND ORIGEM in ('02 - FARM','01 - EADI','04 - MWMS')  AND COD_CLIENTE = SV.COD_CLIENTE and NFE = SV.NFE  and EMISSAO between '20201001' and '20201031') SOBRE_RODAS
		  FROM
		  (SELECT  
				 [ORIGEM]
				,[PEDIDO VENDA]
				,[NFE]
				,[COD_CLIENTE]
				,[LOJA]
				,[CNPJ_CLI]
				,[DSC_CLI]
				,[EMISSAO]
				,[SAIDA]
				,[RPS]
				,[RPS SERIE]
				,[VALOR ITEM]
				,[OBSERVACAO]
				,[CCUSTO]
				,[CD_PRODUTO]
				,[PRODUTO]
				,[TIPO PRODUTO]
				,[FATURA ALCIS ESL]
				,[SISTEMA ORIGEM]
				
				,[ID TITULO]
				,[TIPO SERVICO]
			FROM [DADOSADV12].[dbo].[VW_FAT_AURORA]
			where ORIGEM in ('02 - FARM','01 - EADI','04 - MWMS')
					  and EMISSAO between '20201008' and '20201008'
					  -- and COD_CLIENTE = '000700'
					  -- and NFE = '137228'
					  ) SV
		  GROUP BY
						  SV.COD_CLIENTE 
						 ,SV.CNPJ_CLI 
						 ,SV.NFE
					     ,SV.ORIGEM
						 ,SV.DSC_CLI
						 ,SV.CCUSTO
						 ,SV.[TIPO SERVICO]
						--  ,SV.[TIPO PRODUTO]
						--  ,SV.PRODUTO
						 ,SV.EMISSAO
						 ,SV.SAIDA
			ORDER BY SUM(SV.[VALOR ITEM]) DESC";
			
	/*		
	$query=odbc_exec($conn, $sql);
    while($result = odbc_fetch_array($query)){
		$insert = mysqli_query($con,"")or die("erro no insert");
	}
	*/
	
  
	/*
	echo "<table border='1' width='100%'>
			<tr>
				<th>CENTRO DE CUSTO</th>
				<th>TIPO DE SERVIÇO</th>
				<th>COD. CLIENTE</th>
				<th>CNPJ CLI</th>
				<th>CLIENTE</th>
				<th>FATURADO CNPJ</th>
				<th>FATURADO PARA</th>
				<th>CNPJ COMISS</th>
				<th>COMISSARIA</th>
				<th>EXECUTIVO</th>
				<th>JANEIRO</th>
				<th>FEVEREIRO</th>
				<th>MARÇO</th>
				<th>ABRIL</th>
				<th>MAIO</th>
				<th>JUNHO</th>
				<th>JULHO</th>
				<th>AGOSTO</th>
				<th>SETEMBRO</th>
				<th>OUTUBRO</th>
				<th>NOVEMBRO</th>
				<th>DEZEMBRO</th>
			</tr>";   
  */
  
  //$arquivo = "COMISSOES DE FATURAMENTO.xls";
  
  /*
  $tabela = "<table border='1' width='100%'>";
		$tabela .= '<tr>';
			$tabela .= '<th>COD. CLIENTE</th>';
			$tabela .= '<th>CNPJ</th>';
			$tabela .= '<th>CLIENTE</th>';
			$tabela .= '<th>EXECUTIVO</th>';
			$tabela .= '<th>COD_COMIS</th>';
			$tabela .= '<th>COMISSARIA</th>';
			//$tabela .= '<th>LOTE</th>';
			$tabela .= '<th>DOCUMENTO</th>';
			$tabela .= '<th>VLR_ARMAZ</th>';
			$tabela .= '<th>SOBRE_RODAS</th>';
			$tabela .= '<th>NFE</th>';
			$tabela .= '<th>TOTAL NF</th>';
			$tabela .= '<th>DATA EMISSAO</th>';
		$tabela .= '</tr>';   
	*/
	
	echo "<table border='1' width='100%'>";
		echo '<tr>';
			echo '<th>COD. CLIENTE</th>';
			echo '<th>CNPJ</th>';
			echo '<th>CLIENTE</th>';
			echo '<th>EXECUTIVO</th>';
			echo '<th>COD_COMIS</th>';
			echo '<th>COMISSARIA</th>';
			echo '<th>LOTE</th>';
			echo '<th>DOCUMENTO</th>';
			echo '<th>VLR_ARMAZ</th>';
			echo '<th>SOBRE_RODAS</th>';
			echo '<th>NFE</th>';
			echo '<th>TOTAL NF</th>';
			echo '<th>DATA EMISSAO</th>';
		echo '</tr>';   
	
	$query2=odbc_exec($conn, $sql);
	
	$rows = odbc_num_rows($query2);
	echo $rows;

	
	$query=odbc_exec($conn, $sql);
    while($result = odbc_fetch_array($query) ) {
		
	  /*
	  $arr[] = $result['COD_CLIENTE'];
      $arr1 = array_count_values($arr);
	  foreach($arr1 as $code){
	  }	
	  */	

	  // 19 = IMPORTAÇÃO
      // 20 = EXPORTAÇÃO	  
		
	  //echo $code."<br>";
	  //echo $result['CCUSTO'];
      
	  
	  if(trim($result['CCUSTO']) != '3104'){
		  		//echo "<hr>AD<br>";
			//echo "<hr>".$result['CCUSTO']." AD<br>";
			
			
				if($result['SERVICO'] == '20'){
					$table = " invoice v, dde_reg r";
					$coluna = " v.nr_dde";
					$vinculo = " and v.charge = b.lote and v.nr_dde = r.nr_dde and v.lager = r.lager and r.despachante = p.id_dispatcher";
					$groupBy = "r.despachante, v.nr_dde,";
				}else{
					$table = " desmembr d";
					$coluna = "case when d.nr_di is null then d.nr_da else d.nr_di end";
					$vinculo = " and d.lote_ad = b.lote and d.lager = b.lager and d.id_dispatcher = p.id_dispatcher";
					$groupBy = "d.nr_di, d.nr_da,";
				}
			
				
		  
				$despachantes = $connect->query("select
												  	  b.lote LOTE, 
												  	  $coluna DOCUMENTO,
												  	  case when b.id_klient_bill is null then b.id_klient else b.id_klient_bill end ID_KLIENT,
													   (select 
															LISTAGG(t.REPRESENTATIVE, ', ') WITHIN GROUP(ORDER BY t.REPRESENTATIVE)  from 
															   (select 
																  distinct BL.REPRESENTATIVE REPRESENTATIVE, k.cod_cliente_protheus ID_D 
																from WMS_EADI.KLIENTEN KL, WMS_EADI.BILLING BL, klienten k
																   WHERE BL.ID_KLIENT = KL.ID_KLIENT
																	 AND KL.ID_KLIENT(+) = K.ID_KLIENT
																	 AND BL.STAT <> '80'
																) t
																   where t.ID_D = '".trim($result['COD_CLIENTE'])."' 
														  ) VENDEDOR,
													  p.id_dispatcher IDCOMISSARIA,
												  	  p.bez COMISSARIA
												  from bill_os_item i, klienten k, bill_os b, dispatcher p, $table
												  	where i.id_os = b.id_os
													  and nvl(b.id_klient_bill,b.id_klient) = k.id_klient
													  and k.cod_cliente_protheus = '".trim($result['COD_CLIENTE'])."'
													  and b.nr_nf = '".trim($result['NFE'])."'
													  and k.lager = b.lager
													  $vinculo
													  and trunc(b.date_emiss) between TO_DATE('08/10/2020', 'dd/MM/yyyy') and TO_DATE('08/10/2020', 'dd/MM/yyyy')
													group by
													  b.lote,
													  $groupBy	
													  p.id_dispatcher,
													  b.id_klient_bill,
													  b.id_klient,
													  p.bez");
			
					$despachantes->execute();
					$respWMS = $despachantes->fetch();	
			 
			/*	
				$tabela .=  "<tr>";
						$tabela .= "<td>".$respWMS['ID_KLIENT']."</td>";
						$tabela .= "<td>".$result['CNPJ_CLI']."</td>";
						$tabela .= "<td>".utf8_encode($result['DSC_CLI'])."</td>";
						$tabela .= "<td>".utf8_encode($respWMS['VENDEDOR'])."</td>";
						$tabela .= "<td>".utf8_encode($respWMS['IDCOMISSARIA'])."</td>";
						$tabela .= "<td>".utf8_encode($respWMS['COMISSARIA'])."</td>";  
						//$tabela .= "<td>".$respWMS['LOTE']."</td>";
						$tabela .= "<td>".$respWMS['DOCUMENTO']."</td>";
						$tabela .= "<td>".round($result['VLR_ARMAZ'],2)."</td>";
						
						
						$tabela .= "<td>".round($result['SOBRE_RODAS'], 2)."</td>";
						$tabela .= "<td>".trim($result['NFE'])."</td>";
						$tabela .= "<td>".round($result['VALOR_ITEM'],2)."</td>";
						$tabela .= "<td>".date_format(new DateTime($result['EMISSAO']),"d/m/Y")."</td>";
				$tabela .= "</tr>";
			*/
			
			$insert = mysqli_query($con,"insert into loginbase.comissao_fat (
												cod_wms,
												cod_protheus,
												cnpj,
												cliente,
												executivo,
												cod_comis,
												comissaria,
												documento,
												lote,
												vlr_armaz,
												sobre_rodas,
												nfe,
												total_nf,
												data_emiss,
												tipo_prod,
												produto,
												data_saida,
												tipo_servico,
												ccusto,
												origem
											) values (
												'".$respWMS['ID_KLIENT']."',
												'".$result['COD_CLIENTE']."',
												'".$result['CNPJ_CLI']."',
												'".utf8_encode($result['DSC_CLI'])."',
												'".utf8_encode($respWMS['VENDEDOR'])."',
												'".utf8_encode($respWMS['IDCOMISSARIA'])."',
												'".utf8_encode($respWMS['COMISSARIA'])."',
												'".$respWMS['DOCUMENTO']."',
												'".$respWMS['LOTE']."',
												'".round($result['VLR_ARMAZ'],2)."',
												'".round($result['SOBRE_RODAS'], 2)."',
												'".trim($result['NFE'])."',
												'".round($result['VALOR_ITEM'],2)."',
												'".date_format(new DateTime($result['EMISSAO']),"d/m/Y")."',
												'--',
												'--',
												'".date_format(new DateTime($result['SAIDA']),"d/m/Y")."',
												'".$result['TIPO_SERV']."',
												'".$result['CCUSTO']."',
												'".$result['ORIGEM']."'
										); ")or die("Erro no insert mysql");
			
			echo "<tr>";
						echo "<td>".$respWMS['ID_KLIENT']."</td>";
						echo "<td>".$result['CNPJ_CLI']."</td>";
					    echo "<td>".utf8_encode($result['DSC_CLI'])."</td>";
						echo "<td>".utf8_encode($respWMS['VENDEDOR'])."</td>";
						echo "<td>".utf8_encode($respWMS['IDCOMISSARIA'])."</td>";
						echo "<td>".utf8_encode($respWMS['COMISSARIA'])."</td>";  
						echo "<td>".$respWMS['LOTE']."</td>";
						echo "<td>".$respWMS['DOCUMENTO']."</td>";
						echo "<td>".round($result['VLR_ARMAZ'],2)."</td>";
						
						
						echo "<td>".round($result['SOBRE_RODAS'], 2)."</td>";
						echo "<td>".trim($result['NFE'])."</td>";
						echo "<td>".round($result['VALOR_ITEM'],2)."</td>";
						echo "<td>".date_format(new DateTime($result['EMISSAO']),"d/m/Y")."</td>";
				echo "</tr>";
		
	  }else{
		   echo "<hr>".$result['CCUSTO']." AG<br>";
		   //echo "<hr>AG<br>";
		
		  	/*
			$tabela .= "<tr>";
						$tabela .= "<td></td>";
						$tabela .= "<td>".$result['CNPJ_CLI']."</td>";
						$tabela .= "<td>".utf8_encode($result['DSC_CLI'])."</td>";
						$tabela .= "<td></td>";
						$tabela .= "<td></td>";
						$tabela .= "<td></td>";  
						//$tabela .= "<td></td>";
					    $tabela .= "<td></td>";
						$tabela .= "<td>".round($result['VLR_ARMAZ'],2)."</td>";
						
						
						$tabela .= "<td>".round($result['SOBRE_RODAS'], 2)."</td>";
						$tabela .= "<td>".$result['NFE']."</td>";
						$tabela .= "<td>".round($result['VALOR_ITEM'],2)."</td>";
						$tabela .= "<td>".date_format(new DateTime($result['EMISSAO']),"d/m/Y")."</td>";
				$tabela .= "</tr>";
			*/
	  } 
   	}
	
	echo "</table>";	
   
/*   
   $tabela .= "</table>";
   
   header ('Cache-Control: no-cache, must-revalidate');
   header ('Pragma: no-cache');
   header('Content-Type: application/x-msexcel');
   header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
   echo $tabela;
   
   $connect = null;
*/
   $connect = null;
   odbc_close($conn);
}
?>
