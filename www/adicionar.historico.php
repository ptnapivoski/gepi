<?php

// Inicializa ambiente
require_once('init.php');

ini_set('upload_max_filesize',$FMS);

// Se logado
if($_SESSION['user']){
	// Trata entrada de a quem adicionar
	$id = (int) $_POST['sobre'];
	// E força inteiro para seção
	$sec = (int) $_POST['sec'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 78, $id)){
			// Escapa descrição
			$descricao = mysqli_real_escape_string($db_link, $_POST['descricao']);
			// E título
			$titulo = mysqli_real_escape_string($db_link, $_POST['titulo']);
			// Seção na qual inserir
			if($sec) $secq = $sec; else $secq = 'NULL';

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
						if($ext !== ''){
							// Força minúsculas
							$ext = mb_strtolower($ext,'UTF-8');
							// Caso tenha enviado um arquivo PHP, mudar para arquivo de texto
							if($ext === 'php') $ext = 'txt';
							// Nome do arquivo é seu hash e extensão
							$arquivo = "$hash.$ext";
						//Sem extensão
						} else
							// Nome do arquivo é apenas seu hash
							$arquivo = "$hash";

						$arquivo_addr = "$FDIR/$arquivo";
						// Tenta mover o arquivo
						if(move_uploaded_file($_FILES['arquivo']['tmp_name'],$arquivo_addr)){
							// Escapa nome do arquivo para DB
							$arquivo_db = mysqli_real_escape_string($db_link, $arquivo);
							// Nome a colocar no DB
							$arquivo_db = "'$arquivo_db'";
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
						if($db_query = mysqli_query($db_link, "INSERT INTO historico VALUES ($_SESSION[user], $id, $secq, NOW(), '$titulo', '$descricao', $arquivo_db);")){
							// Se consulta inseriu uma linha
							if(mysqli_affected_rows($db_link) === 1)
								// Informa que houve a inserção
								require_once('ins.suc.php');
							// Caso contrário
							else {
								// Caso tenha conseguido subir o arquivo, exclui-o
								if($arquivo_addr && is_file($arquivo_addr)) unlink($arquivo_addr);
								// Informa que não houve a inserção
								require_once('ins.err.php');
							}
						// Caso não tenha conseguido realizar a consulta
						} else {
							// Caso tenha conseguido subir o arquivo, exclui-o
							if($arquivo_addr && is_file($arquivo_addr)) unlink($arquivo_addr);
							// Mensagem
							require_once('db.query.err.php');
						}
					}
				// Avisa que houve erro ao enviar o arquivo
				} else $_SESSION['msg'] = '<p class="error">Erro ao enviar arquivo anexo do histórico.</p>';
			// Caso descrição vazia
			} else $_SESSION['msg'] = '<p class="error">Incorreto preenchimento do formulário.</p>';
		// Caso não possua permissão
		} else require_once('perm.err.php');

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Abra para a qual retornar
	if($sec >= 1 && $sec <= 6) $tab = $sec; else $tab = 8;

	// Volta para a página da entidade na aba dos históricos
	header("Location:entidade.php?id=$id&tab=$tab");
// Se não logado
} else require_once('login.err.php');
