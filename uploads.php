<?php 
error_reporting(E_ERROR | E_PARSE);
//include 'connection.php';

$username = "localhost";
$password = "";

$con = mysqli_connect("localhost", "root", "", "testes")or die("ERROR AO CONECTAR AO BANCO");

//Response object structure
$response = new stdClass;
$response->status = null;
$response->message = null;

//Uploading File
$cliente = $_POST['cliente'];
$cnpj = $_POST['cnpj'];
$dta = $_POST['dta'];

$destination_dir = "$cliente - $cnpj/$dta/";

if(!file_exists($destination_dir)){
     mkdir($destination_dir, 0777, true);
}



//////////////////PRIMEIRO DOCUMENTO EXTRATO DTA//////////////////
if (!empty($_FILES)) {
    
    if(!empty($_FILES["file1"]["name"])){
        $base_filename1 = basename($_FILES["file1"]["name"]);
        $nome_arquivo_md5 = 'EXTRATO DTA';
        $nome_arquivo_md5 = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT',$nome_arquivo_md5));
        $temp1 = explode(".", $base_filename1);
        
        //$nome_final = $destination_dir . $nome_arquivo_md5 . '.' . end($temp1);
        $target_file1 = $destination_dir . $nome_arquivo_md5 . '.' . end($temp1);
        //$target_file1 = str_replace('//','/',$destination_dir) . $nome_final;
        
        if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file1) ){
            $path1 = $target_file1;
            $update1 = "tb_extrato = '$path1',";
            $response->status = false;
            $response->message = "Arquivo 1 exportado com sucesso!";
        }else{
            $update1 = "tb_extrato = tb_extrato,";
            $response->status = false;
            $response->message = "Falha ao salvar o arquivo 1 na pasta!";
        }
    }else{
        $update1 = "tb_extrato = tb_extrato,";
    }


    //////////////////SEGUNDO DOCUMENTO CONHECIMENTO TRANSPORTE//////////////////
    if(!empty($_FILES["file2"]["name"])){
        $base_filename2 = basename($_FILES["file2"]["name"]);
        $nome_arquivo_md5 = 'CONHECIMENTO TRANSPORTE';
        $nome_arquivo_md5 = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT',$nome_arquivo_md5));
        $temp2 = explode(".", $base_filename2);
        
        //$nome_final = $destination_dir . $nome_arquivo_md5 . '.' . end($temp2);
        $target_file2 = $destination_dir . $nome_arquivo_md5 . '.' . end($temp2);
        //$target_file2 = str_replace('//','/',$destination_dir) . $nome_final;
        
        if (move_uploaded_file($_FILES["file2"]["tmp_name"], $target_file2) ){
            $path2 = $target_file2;
            $update2 = "tb_conhec = '$path2',";
            $response->status = false;
            $response->message = "Arquivo 2 exportado com sucesso!";
        }else{
            $update2 = "tb_conhec = tb_conhec,";
            $response->status = false;
            $response->message = "Falha ao salvar o arquivo 2 na pasta!";
        }
    }else{
         $update2 = "tb_conhec = tb_conhec,";
    }

    //////////////////TERCEIRO DOCUMENTO INVOICE//////////////////
    if(!empty($_FILES["file3"]["name"])){
        $base_filename3 = basename($_FILES["file3"]["name"]);
        $nome_arquivo_md5 = 'INVOICE';
        $nome_arquivo_md5 = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT',$nome_arquivo_md5));
        $temp3 = explode(".", $base_filename3);
        
        //$nome_final = $destination_dir . $nome_arquivo_md5 . '.' . end($temp3);
        $target_file3 = $destination_dir . $nome_arquivo_md5 . '.' . end($temp3);
        //$target_file3 = str_replace('//','/',$destination_dir) . $nome_final;
        
        if (move_uploaded_file($_FILES["file3"]["tmp_name"], $target_file3) ){
            $path3 = $target_file3;   
            $update3 = "tb_invoice = '$path3',";
            $response->status = false;
            $response->message = "Arquivo 3 exportado com sucesso!";
        }else{
            $update3 = "tb_invoice = tb_invoice,";
            $response->status = false;
            $response->message = "Falha ao salvar o arquivo 3 na pasta!";
        }
    }else{
         $update3 = "tb_invoice = tb_invoice,";
    }

    //////////////////QUARTO DOCUMENTO PACKING LIST//////////////////
    if(!empty($_FILES["file4"]["name"])){
        $base_filename4 = basename($_FILES["file4"]["name"]);
        $nome_arquivo_md5 = 'PACKING LIST';
        $nome_arquivo_md5 = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT',$nome_arquivo_md5));
        $temp4 = explode(".", $base_filename4);
        
        //$nome_final = $destination_dir . $nome_arquivo_md5 . '.' . end($temp4);
        $target_file4 = $destination_dir . $nome_arquivo_md5 . '.' . end($temp4);
        //$target_file4 = str_replace('//','/',$destination_dir) . $nome_final;
        
        if (move_uploaded_file($_FILES["file4"]["tmp_name"], $target_file4) ){
            $path4 = $target_file4;
            $update4 = "tb_packing = '$path4',";
            $response->status = false;
            $response->message = "Arquivo 4 exportado com sucesso!";
        }else{
            $update4 = "tb_packing = tb_packing,";
            $response->status = false;
            $response->message = "Falha ao salvar o arquivo 4 na pasta!";
        }
    }else{
        $update4 = "tb_packing = tb_packing,";
    }

    //////////////////QUINTO DOCUMENTO OUTROS DOCUMENTOS//////////////////
    if(!empty($_FILES["file5"]["name"])){
        $base_filename5 = basename($_FILES["file5"]["name"]);
        $nome_arquivo_md5 = 'OUTROS DOCUMENTOS';
        $nome_arquivo_md5 = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT',$nome_arquivo_md5));
        $temp5 = explode(".", $base_filename5);
        
        //$nome_final = $destination_dir . $nome_arquivo_md5 . '.' . end($temp5);
        $target_file5 = $destination_dir . $nome_arquivo_md5 . '.' . end($temp5);
        //$target_file5 = str_replace('//','/',$destination_dir) . $nome_final;
        
        if (move_uploaded_file($_FILES["file5"]["tmp_name"], $target_file5) ){
            $path5 = $target_file5;
            $update5 = "tb_outros = '$path5'";
            $response->status = false;
            $response->message = "Arquivo 5 exportado com sucesso!";
        }else {
            $update5 = "tb_outros = tb_outros";
            $response->status = false;
            $response->message = "Falha ao salvar o arquivo 5 na pasta! $destination_dir";
        }
    }else{
        $update5 = "tb_outros = tb_outros";
    }   
        
}else{
    $response->status = false;
    $response->message = "Falha arquivo 5 não existe!";
}

 
        $insert = mysqli_query($con,"INSERT INTO books 
                                        (
                                            cliente, 
                                            cnpj,
                                            dta,
                                            tb_extrato, 
                                            tb_conhec, 
                                            tb_invoice, 
                                            tb_packing, 
                                            tb_outros
                                        ) VALUES 
                                        (
                                            '$cliente', 
                                            '$cnpj', 
                                            '$dta', 
                                            '$path1', 
                                            '$path2', 
                                            '$path3', 
                                            '$path4', 
                                            '$path5'
                                        )on duplicate key update 
                                            cliente = '$cliente',
                                            cnpj = '$cnpj',
                                            $update1
                                            $update2
                                            $update3
                                            $update4
                                            $update5
                                        ")or die(mysqli_error($con));

        if ($insert) {
            
        } else {
            //echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
        
        

header('Content-type: application/json');
echo json_encode($response);

?>