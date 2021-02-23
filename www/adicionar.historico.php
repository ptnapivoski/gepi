<?php

// Inicializa ambiente
require_once('init.php');

ini_set('upload_max_filesize',$FMS);

// Se logado
if($_SESSION['user']){
	// Trata entrada de a quem adicionar
	$id = (int) $_POST['sobre'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 84, $id)){
			// Escapa descrição
			$descricao = mysqli_real_escape_string($db_link, $_POST['descricao']);
			// E título
			$titulo = mysqli_real_escape_string($db_link, $_POST['titulo']);

			// Valida conteúdo da descrição
			if($descricao !== '' && $titulo !== ''){
				// Caso tenha conseguido subir o arquivo com sucesso ou não tenha subido arquivo
				if($_FILES['arquivo']['error'] === UPLOAD_ERR_OK || $_FILES['arquivo']['error'] === UPLOAD_ERR_NO_FILE){
					// Nome para o arquivo no DB caso não tenha sido enviado algum
					$arquivo_db = 'NULL';
					// Endereço do arquivo caso não tenha sido enviado um
					$arquivo_addr = NULL;
					// Variável de teste do arquivo
					$ok = TRUE;
					// Caso tenha conseguido subir um arquivo
					if($_FILES['arquivo']['error'] === UPLOAD_ERR_OK){
						// Hash do conteúdo do arquivo
						$hash = sha1_file($_FILES['arquivo']['tmp_name']);
						// Extensão do arquivo enviada
						$ext = pathinfo($_FILES['arquivo']['name'],PATHINFO_EXTENSION);
						// Caso válida a extensão
						if($ext !== '')
							// Nome do arquivo
							$arquivo = "$hash.$ext";
						//Sem extensão
						else
							// Nome do arquivo
							$arquivo = "$hash";
						$arquivo_addr = "$FDIR/$arquivo";
						// Tenta mover o arquivo
						if(move_uploaded_file($_FILES['arquivo']['tmp_name'],$arquivo_addr)){
							// Nome a colocar no DB
							$arquivo_db = "'$arquivo'";
						// Ao ocorrer problema ao mover o arquivo
						} else {
							// Variável de teste de arquivo
							$ok = FALSE;
							// Mensagem a mostrar
							$_SESSION['msg'] = '<p class="error">Arquivo anexo enviado mas houve erro.</p>';
						}
					}

					// Prossegue tentando inserir no DB
					if($ok){
						// Tenta inserir
						if($db_query = mysqli_query($db_link, "INSERT INTO historico VALUES ($_SESSION[user], $id, NOW(), '$titulo', '$descricao', $arquivo_db);")){
							// Se consulta inseriu uma linha
							if(mysqli_affected_rows($db_link) === 1)
								// Informa que houve a inserção
								$_SESSION['msg'] = '<p class="success">Inserção efetuada.</p>';
							// Caso contrário
							else {
								// Caso tenha conseguido subir o arquivo, exclui-o
								if($arquivo_addr && is_file($arquivo_addr)) unlink($arquivo_addr);
								// Informa que não houve a inserção
								$_SESSION['msg'] = '<p class="error">Inserção não efetuada.</p>';
							}
						// Caso não tenha conseguido realizar a consulta
						} else {
							// Caso tenha conseguido subir o arquivo, exclui-o
							if($arquivo_addr && is_file($arquivo_addr)) unlink($arquivo_addr);
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
						}
					}
				// Avisa que houve erro ao enviar o arquivo
				} else $_SESSION['msg'] = '<p class="error">Erro ao enviar arquivo anexo do histórico.</p>';
			// Caso descrição vazia
			} else $_SESSION['msg'] = '<p class="error">Incorreto preenchimento do formulário.</p>';
		// Caso não possua permissão
		} else $_SESSION['msg'] = '<p class="error">Você não tem permissão para executar esta ação.</p>';

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página da entidade na aba dos históricos
	header("Location:entidade.php?id=$id&tab=6");
// Se não logado
} else require_once('login.err.php');
