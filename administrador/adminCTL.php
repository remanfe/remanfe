<?php

if (isset($_POST['gravar'])) {
    include '../config/conexao.php';
    include '../classes/administrador.php';

    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $complemento_logradouro = $_POST['complemento'];
    $numero_logradouro = $_POST['numero'];
    $bairro_logradouro = $_POST['bairro'];
    $cidade_logradouro = $_POST['cidade'];
    $estado_logradouro = $_POST['estado'];
    $celular = $_POST['celular'];
    $celular_comercial = $_POST['celular_com'];
    $email = $_POST['email'];
    $usuario_login = $_POST['usuario'];
    $senha_login = $_POST['senha'];
    $status = $_POST['status'];

    if (empty($cpf)) {
        $msg = 'CPF não informado! Verifique-o, por gentileza.';
        header('location: ../cadastrar_admin.php?mensagem=' . $msg);
    } else {
        $verificarCPF = verificarCPF($cpf);

        if (count($verificarCPF) > 0) {
            $msg = 'O CPF informado já foi cadastrado! Verifique-o, por gentileza.';
            header('location: ../cadastrar_admin.php?mensagem=' . $msg);
        } else {
            $conn = conexao();
            $stmt = $conn->prepare("INSERT INTO public.administrador(
	cpf_admin, nome_admin, cep_admin, logradouro_admin, complemento_logradouro_admin, numero_logradouro_admin, 
        bairro_logradouro_admin, cidade_logradouro_admin, uf_logradoruo_admin, celular_admin, 
        celular_comercial_admin, email_admin, usuario_login_admin, senha_login_admin, 
        status_admin, data_integracao, tipo_usuario)
	VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, current_date, 0);");
            $stmt->bindParam(1, $cpf);
            $stmt->bindParam(2, $nome);
            $stmt->bindParam(3, $cep);
            $stmt->bindParam(4, $logradouro);
            $stmt->bindParam(5, $complemento_logradouro);
            $stmt->bindParam(6, $numero_logradouro);
            $stmt->bindParam(7, $bairro_logradouro);
            $stmt->bindParam(8, $cidade_logradouro);
            $stmt->bindParam(9, $estado_logradouro);
            $stmt->bindParam(10, $celular);
            $stmt->bindParam(11, $celular_comercial);
            $stmt->bindParam(12, $email);
            $stmt->bindParam(13, $usuario_login);
            $stmt->bindParam(14, $senha_login);
            $stmt->bindParam(15, $status);

            if ($stmt->execute()) {
                $msg = 'Administrador cadastrado com sucesso!';
                header('location: ../cadastrar_admin.php?mensagem=' . $msg);
            } else {
                echo "<script>alert('Erro ao cadastrar administrador!');</script>";
            }
        }
    }
} else if (isset($_POST['atualizar'])) {
    include '../config/conexao.php';
    include '../classes/administrador.php';

    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $complemento_logradouro = $_POST['complemento'];
    $numero_logradouro = $_POST['numero'];
    $bairro_logradouro = $_POST['bairro'];
    $cidade_logradouro = $_POST['cidade'];
    $estado_logradouro = $_POST['estado'];
    $celular = $_POST['celular'];
    $celular_comercial = $_POST['celular_com'];
    $email = $_POST['email'];
    $usuario_login = $_POST['usuario'];
    $senha_login = $_POST['senha'];
    $status = $_POST['status'];

    $conn = conexao();
    $stmt = $conn->prepare("UPDATE public.administrador
	SET cpf_admin=?, nome_admin=?, cep_admin=?, logradouro_admin=?, 
        complemento_logradouro_admin=?, numero_logradouro_admin=?, bairro_logradouro_admin=?, 
        cidade_logradouro_admin=?, uf_logradoruo_admin=?, celular_admin=?, celular_comercial_admin=?, 
        email_admin=?, usuario_login_admin=?, senha_login_admin=?, status_admin=? 
	WHERE cpf_admin=?;");
    $stmt->bindParam(1, $cpf);
    $stmt->bindParam(2, $nome);
    $stmt->bindParam(3, $cep);
    $stmt->bindParam(4, $logradouro);
    $stmt->bindParam(5, $complemento_logradouro);
    $stmt->bindParam(6, $numero_logradouro);
    $stmt->bindParam(7, $bairro_logradouro);
    $stmt->bindParam(8, $cidade_logradouro);
    $stmt->bindParam(9, $estado_logradouro);
    $stmt->bindParam(10, $celular);
    $stmt->bindParam(11, $celular_comercial);
    $stmt->bindParam(12, $email);
    $stmt->bindParam(13, $usuario_login);
    $stmt->bindParam(14, $senha_login);
    $stmt->bindParam(15, $status);
    $stmt->bindParam(16, $cpf);

    if ($stmt->execute()) {
        $msg = 'Administrador atualizado com sucesso!';
        header('location: ../cadastrar_admin.php?mensagem=' . $msg);
    } else {
        echo "<script>alert('Erro ao atualizar administrador!');</script>";
    }
}

function verificarCPF($cpf) {
    include_once('../config/conexao.php');

    $conn = conexao();
    $stmt = $conn->prepare("select * from administrador where cpf_admin = '" . $cpf . "';");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function localizarCPFAdmin($cpf) {
    include_once('../config/conexao.php');

    $conn = conexao();
    $stmt = $conn->prepare("select * from administrador where cpf_admin = '" . $cpf . "';");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//function CEP_curl($cep) {
//    $cep = preg_replace('/[^0-9]/', '', (string) $cep);
//    $url = "http://viacep.com.br/ws/" . $cep . "/json/";
//// CURL
//    $ch = curl_init();
//// Disable SSL verification
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//// Will return the response, if false it print the response
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//// Set the url
//    curl_setopt($ch, CURLOPT_URL, $url);
//// Execute
//    $result = curl_exec($ch);
//// Closing
//    curl_close($ch);
//
//    $json = json_decode($result);
////var_dump($json);
//    if (!isset($json->erro)) {
//        $array['uf'] = $json->uf;
//        $array['cidade'] = $json->localidade;
//        $array['bairro'] = $json->bairro;
//        $array['logradouro'] = $json->logradouro;
//    } else {
//        $array = 'Erro';
//    }
//    return $array;
//}
?>
