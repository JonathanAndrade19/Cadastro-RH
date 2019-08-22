<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Sistema de Cadastro</title>
	<link rel="shortcut icon" href="../imagens/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class='container box-mensagem-crud'>
		<?php
    require './conexao.php';

        // Atribui uma conexão PDO
    $conexao = conexao::getInstance();

        // Recebe os dados enviados pela submissão
    $acao = (isset($_POST['acao'])) ? $_POST['acao'] : '';
    $id = (isset($_POST['id'])) ? $_POST['id'] : '';
    $nome = (isset($_POST['nome'])) ? $_POST['nome'] : '';
    $pai = (isset($_POST['pai'])) ? $_POST['pai'] : '';
    $mae = (isset($_POST['mae'])) ? $_POST['mae'] : '';
    $rua = (isset($_POST['rua'])) ? $_POST['rua'] : '';
    $numero = (isset($_POST['numero'])) ? $_POST['numero'] : '';
    $complemento = (isset($_POST['complemento'])) ? $_POST['complemento'] : '';
    $cep = (isset($_POST['cep'])) ? str_replace(['-', ' '], '', $_POST['cep']) : '';
    $bairro = (isset($_POST['bairro'])) ? $_POST['bairro'] : '';
    $cidade = (isset($_POST['cidade'])) ? $_POST['cidade'] : '';
    $nacionalidade = (isset($_POST['nacionalidade'])) ? $_POST['nacionalidade'] : '';
    $naturalidade = (isset($_POST['naturalidade'])) ? $_POST['naturalidade'] : '';
    $estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
    $estado_civil = (isset($_POST['estado_civil'])) ? $_POST['estado_civil'] : '';
    $numero_dependente = (isset($_POST['numero_dependente'])) ? $_POST['numero_dependente'] : '';
    $cpf = (isset($_POST['cpf'])) ? str_replace(['-', ' '], '', $_POST['cpf']) : '';
    $carteiratrabalho = (isset($_POST['carteiratrabalho'])) ? $_POST['carteiratrabalho'] : '';
    $reservista = (isset($_POST['reservista'])) ? $_POST['reservista'] : '';
    $escolar = (isset($_POST['escolar'])) ? $_POST['escolar'] : '';
    $instituicao = (isset($_POST['instituicao'])) ? $_POST['instituicao'] : '';
    $curso = (isset($_POST['curso'])) ? $_POST['curso'] : '';
    $deficiente = (isset($_POST['deficiente'])) ? $_POST['deficiente'] : '';
    $nota = (isset($_POST['nota'])) ? $_POST['nota'] : '';
    $cargo = (isset($_POST['cargo'])) ? $_POST['cargo'] : '';
    $funcao = (isset($_POST['funcao'])) ? $_POST['funcao'] : '';
    $forma_admissao = (isset($_POST['forma_admissao'])) ? $_POST['forma_admissao'] : '';
    $identidade = (isset($_POST['identidade'])) ? $_POST['identidade'] : '';
    $titulo = (isset($_POST['titulo'])) ? str_replace(['-', ' '], '', $_POST['titulo']) : '';
    $zona = (isset($_POST['zona'])) ? $_POST['zona'] : '';
    $secao = (isset($_POST['secao'])) ? $_POST['secao'] : '';
    $pis = (isset($_POST['pis'])) ? str_replace(['.', '-'], '', $_POST['pis']) : '';
    $matricula = (isset($_POST['matricula'])) ? str_replace(['.', '-'], '', $_POST['matricula']) : '';
    $email = (isset($_POST['email'])) ? $_POST['email'] : '';
    $foto_atual = (isset($_POST['foto_atual'])) ? $_POST['foto_atual'] : '';
    $data_nascimento = (isset($_POST['data_nascimento'])) ? $_POST['data_nascimento'] : '';
    $data_admissao = (isset($_POST['data_admissao'])) ? $_POST['data_admissao'] : '';
    $regime = (isset($_POST['regime'])) ? $_POST['regime'] : '';
    $setor = (isset($_POST['setor'])) ? $_POST['setor'] : '';
    $sexo = (isset($_POST['sexo'])) ? $_POST['sexo'] : '';
    $telefone = (isset($_POST['telefone'])) ? str_replace(['-', ' '], '', $_POST['telefone']) : '';
    $celular = (isset($_POST['celular'])) ? str_replace(['-', ' '], '', $_POST['celular']) : '';
    $whatsapp = (isset($_POST['whatsapp'])) ? str_replace(['-', ' '], '', $_POST['whatsapp']) : '';
    $banco = (isset($_POST['banco'])) ? $_POST['banco'] : '';
    $agencia = (isset($_POST['agencia'])) ? $_POST['agencia'] : '';
    $conta_corrente = (isset($_POST['conta_corrente'])) ? $_POST['conta_corrente'] : '';
    $status = (isset($_POST['status'])) ? $_POST['status'] : '';
    $cnh = (isset($_POST['cnh'])) ? $_POST['cnh'] : '';
    $cnh_categoria = (isset($_POST['cnh_categoria'])) ? $_POST['cnh_categoria'] : '';
    $tipo_sangue = (isset($_POST['tipo_sangue'])) ? $_POST['tipo_sangue'] : '';
    $deficiente_tipo = (isset($_POST['deficiente_tipo'])) ? $_POST['deficiente_tipo'] : '';

    $mensagem = '';

    include './form-validate.php';

        // Verifica se foi solicitada a inclusão de dados
    if ('incluir' === $acao) {
        $nome_foto = 'padrao.jpg';
        if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0) {
            $extensoes_aceitas = ['bmp', 'png', 'svg', 'jpeg', 'jpg'];
            $tmp = explode('.', $_FILES['foto']['name']);
            $extensao = strtolower(end($tmp));
            //$extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));

            // Validamos se a extensão do arquivo é aceita
            if (false === array_search($extensao, $extensoes_aceitas, true)) {
                echo '<h1>Extensão Inválida!</h1>';
                exit;
            }

            // Verifica se o upload foi enviado via POST
            if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
                // Verifica se o diretório de destino existe, senão existir cria o diretório
                if (!file_exists('fotos')) {
                    mkdir('fotos');
                }

                // Monta o caminho de destino com o nome do arquivo e sua extensão
                $filefotoextensao = $_FILES['foto']['name'];
                $ext = pathinfo($filefotoextensao, PATHINFO_EXTENSION);

                $nome_foto = $matricula.'.'.$ext;

                // Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino
                if (!move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos/'.$nome_foto)) {
                    echo 'Houve um erro ao gravar arquivo na pasta de destino!';
                }
            }
        }

        $sql = 'INSERT INTO servidor (nome, pai, mae, rua, numero, complemento, cep, bairro, cidade, email, matricula, cpf, identidade, 
			titulo, zona, secao, pis, carteiratrabalho, reservista, escolar, instituicao, curso, nota, cargo, funcao, forma_admissao, regime, setor, data_nascimento, data_admissao, 
			sexo, 
			nacionalidade, naturalidade, estado, estado_civil, numero_dependente, telefone, celular, whatsapp, banco, agencia, conta_corrente, status, foto,cnh,cnh_categoria,tipo_sangue,deficiente,deficiente_tipo)
							   VALUES(:nome, :pai, :mae, :rua, :numero, :complemento, :cep, :bairro, :cidade, :email, :matricula, :cpf, :identidade, 
			:titulo, :zona, :secao, :pis, :carteiratrabalho, :reservista, :escolar, :instituicao, :curso, :nota, :cargo, :funcao, :forma_admissao, :regime, :setor, :data_nascimento, :data_admissao, 
			:sexo, 
			:nacionalidade, :naturalidade, :estado, :estado_civil, :numero_dependente, :telefone, :celular, :whatsapp, :banco, :agencia, :conta_corrente, :status, :foto, :cnh, :cnh_categoria, :tipo_sangue, :deficiente, :deficiente_tipo)';

        $stm = $conexao->prepare($sql);
        $stm->bindValue(':nome', $nome);
        $stm->bindValue(':pai', $pai);
        $stm->bindValue(':mae', $mae);
        $stm->bindValue(':rua', $rua);
        $stm->bindValue(':numero', $numero);
        $stm->bindValue(':complemento', $complemento);
        $stm->bindValue(':cep', $cep);
        $stm->bindValue(':bairro', $bairro);
        $stm->bindValue(':cidade', $cidade);
        $stm->bindValue(':email', $email);
        $stm->bindValue(':cpf', $cpf);
        $stm->bindValue(':identidade', $identidade);
        $stm->bindValue(':titulo', $titulo);
        $stm->bindValue(':zona', $zona);
        $stm->bindValue(':secao', $secao);
        $stm->bindValue(':pis', $pis);
        $stm->bindValue(':carteiratrabalho', $carteiratrabalho);
        $stm->bindValue(':reservista', $reservista);
        $stm->bindValue(':escolar', $escolar);
        $stm->bindValue(':instituicao', $instituicao);
        $stm->bindValue(':curso', $curso);
        $stm->bindValue(':deficiente', $deficiente);
        $stm->bindValue(':nota', $nota);
        $stm->bindValue(':cargo', $cargo);
        $stm->bindValue(':funcao', $funcao);
        $stm->bindValue(':forma_admissao', $forma_admissao);
        $stm->bindValue(':regime', $regime);
        $stm->bindValue(':setor', $setor);
        $stm->bindValue(':matricula', $matricula);
        $stm->bindValue(':data_nascimento', $data_ansi);
        $stm->bindValue(':data_admissao', $data2_ansi2);
        $stm->bindValue(':sexo', $sexo);
        $stm->bindValue(':nacionalidade', $nacionalidade);
        $stm->bindValue(':naturalidade', $naturalidade);
        $stm->bindValue(':estado', $estado);
        $stm->bindValue(':estado_civil', $estado_civil);
        $stm->bindValue(':numero_dependente', $numero_dependente);
        $stm->bindValue(':telefone', $telefone);
        $stm->bindValue(':celular', $celular);
        $stm->bindValue(':whatsapp', $whatsapp);
        $stm->bindValue(':banco', $banco);
        $stm->bindValue(':agencia', $agencia);
        $stm->bindValue(':conta_corrente', $conta_corrente);
        $stm->bindValue(':status', $status);
        $stm->bindValue(':foto', $nome_foto);
        $stm->bindValue(':cnh', $cnh);
        $stm->bindValue(':cnh_categoria', $cnh_categoria);
        $stm->bindValue(':tipo_sangue', $tipo_sangue);
        $stm->bindValue(':deficiente_tipo', $deficiente_tipo);
        $retorno = $stm->execute();

        if ($retorno) {
            echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso, aguarde você está sendo redirecionado ...</div> ";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
        }

        echo "<meta http-equiv=refresh content='3;URL=../painel.php'>";
    }

        // Verifica se foi solicitada a edição de dados
    if ('editar' === $acao) {
        if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0) {
            // Verifica se a foto é diferente da padrão, se verdadeiro exclui a foto antiga da pasta
            if ('padrao.jpg' !== $foto_atual) {
                unlink('fotos/'.$foto_atual);
            }

            $extensoes_aceitas = ['bmp', 'png', 'svg', 'jpeg', 'jpg'];
            $tmp = explode('.', $_FILES['foto']['name']);
            $extensao = strtolower(end($tmp));
            // $extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));

            // Validamos se a extensão do arquivo é aceita
            if (false === array_search($extensao, $extensoes_aceitas, true)) {
                echo '<h1>Extensão Inválida!</h1>';
                exit;
            }

            // Verifica se o upload foi enviado via POST
            if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
                // Verifica se o diretório de destino existe, senão existir cria o diretório
                if (!file_exists('fotos')) {
                    mkdir('fotos');
                }

                // Monta o caminho de destino com o nome do arquivo e sua extensão
                $filefotoextensao = $_FILES['foto']['name'];
                $ext = pathinfo($filefotoextensao, PATHINFO_EXTENSION);

                $nome_foto = $matricula.'.'.$ext;

                // Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino
                if (!move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos/'.$nome_foto)) {
                    echo 'Houve um erro ao gravar arquivo na pasta de destino!';
                }
            }
        } else {
            $nome_foto = $foto_atual;
        }

        $sql = 'UPDATE servidor SET nome=:nome, pai=:pai, mae=:mae, rua=:rua, numero=:numero, complemento=:complemento, cep=:cep, bairro=:bairro, 
			cidade=:cidade, email=:email, matricula=:matricula, cpf=:cpf, titulo=:titulo, zona=:zona, secao=:secao, pis=:pis, identidade=:identidade, 
			carteiratrabalho=:carteiratrabalho, reservista=:reservista, escolar=:escolar, instituicao=:instituicao, curso=:curso, deficiente=:deficiente, 
			nota=:nota, cargo=:cargo, funcao=:funcao, forma_admissao=:forma_admissao, regime=:regime, setor=:setor, data_nascimento=:data_nascimento, data_admissao=:data_admissao, sexo=:sexo, 
			nacionalidade=:nacionalidade, naturalidade=:naturalidade, estado=:estado, estado_civil=:estado_civil, numero_dependente=:numero_dependente, 
			telefone=:telefone, celular=:celular, whatsapp=:whatsapp, banco=:banco, agencia=:agencia, conta_corrente=:conta_corrente, status=:status, foto=:foto, cnh=:cnh, cnh_categoria=:cnh_categoria, tipo_sangue=:tipo_sangue, deficiente_tipo=:deficiente_tipo  ';
        $sql .= 'WHERE id = :id';

        $stm = $conexao->prepare($sql);
        $stm->bindValue(':nome', $nome);
        $stm->bindValue(':pai', $pai);
        $stm->bindValue(':mae', $mae);
        $stm->bindValue(':rua', $rua);
        $stm->bindValue(':numero', $numero);
        $stm->bindValue(':complemento', $complemento);
        $stm->bindValue(':cep', $cep);
        $stm->bindValue(':bairro', $bairro);
        $stm->bindValue(':cidade', $cidade);
        $stm->bindValue(':email', $email);
        $stm->bindValue(':cpf', $cpf);
        $stm->bindValue(':identidade', $identidade);
        $stm->bindValue(':titulo', $titulo);
        $stm->bindValue(':zona', $zona);
        $stm->bindValue(':secao', $secao);
        $stm->bindValue(':pis', $pis);
        $stm->bindValue(':carteiratrabalho', $carteiratrabalho);
        $stm->bindValue(':reservista', $reservista);
        $stm->bindValue(':escolar', $escolar);
        $stm->bindValue(':instituicao', $instituicao);
        $stm->bindValue(':curso', $curso);
        $stm->bindValue(':deficiente', $deficiente);
        $stm->bindValue(':nota', $nota);
        $stm->bindValue(':cargo', $cargo);
        $stm->bindValue(':funcao', $funcao);
        $stm->bindValue(':forma_admissao', $forma_admissao);
        $stm->bindValue(':regime', $regime);
        $stm->bindValue(':setor', $setor);
        $stm->bindValue(':matricula', $matricula);
        $stm->bindValue(':data_nascimento', $data_ansi);
        $stm->bindValue(':data_admissao', $data2_ansi2);
        $stm->bindValue(':sexo', $sexo);
        $stm->bindValue(':nacionalidade', $nacionalidade);
        $stm->bindValue(':naturalidade', $naturalidade);
        $stm->bindValue(':estado', $estado);
        $stm->bindValue(':estado_civil', $estado_civil);
        $stm->bindValue(':numero_dependente', $numero_dependente);
        $stm->bindValue(':telefone', $telefone);
        $stm->bindValue(':celular', $celular);
        $stm->bindValue(':whatsapp', $whatsapp);
        $stm->bindValue(':banco', $banco);
        $stm->bindValue(':agencia', $agencia);
        $stm->bindValue(':conta_corrente', $conta_corrente);
        $stm->bindValue(':status', $status);
        $stm->bindValue(':foto', $nome_foto);
        $stm->bindValue(':cnh', $cnh);
        $stm->bindValue(':cnh_categoria', $cnh_categoria);
        $stm->bindValue(':tipo_sangue', $tipo_sangue);
        $stm->bindValue(':deficiente_tipo', $deficiente_tipo);
        $stm->bindValue(':id', $id);
        $retorno = $stm->execute();

        if ($retorno) {
            echo "<div class='alert alert-success' role='alert'>Registro editado com sucesso, aguarde você está sendo redirecionado ...</div> ";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div> ";
        }

        echo "<meta http-equiv=refresh content='3;URL=../painel.php'>";
    }

        // Verifica se foi solicitada a exclusão dos dados
    if ('excluir' === $acao) {
        // Captura o nome da foto para excluir da pasta
        $sql = "SELECT foto FROM servidor WHERE id = :id AND foto <> 'padrao.jpg'";
        $stm = $conexao->prepare($sql);
        $stm->bindValue(':id', $id);
        $stm->execute();
        $cliente = $stm->fetch(PDO::FETCH_OBJ);

        if (!empty($cliente) && file_exists('fotos/'.$cliente->foto)) {
            unlink('fotos/'.$cliente->foto);
        }

        // Exclui o registro do banco de dados
        $sql = 'DELETE FROM servidor WHERE id = :id';
        $stm = $conexao->prepare($sql);
        $stm->bindValue(':id', $id);
        $retorno = $stm->execute();

        if ($retorno) {
            echo "<div class='alert alert-success' role='alert'>Registro excluído com sucesso, aguarde você está sendo redirecionado ...</div> ";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro ao excluir registro!</div> ";
        }

        //head ('Location: ../painel.php');
        echo "<meta http-equiv=refresh content='3;URL=../painel.php'>";
    }
    ?>

	</div>
</body>
</html>