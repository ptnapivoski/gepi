<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Endereço a retornar
		$id = (int) $_GET['id'];

		// Tenta selecionar aquele endereço
		if($db_query = mysqli_query($db_link, "SELECT pais.nome, uf.nome, cid.nome, bai.nome, tdl.nome, log.nome, end.numero, end.complemento FROM endereco end LEFT JOIN logradouro log ON end.logradouro = log.id LEFT JOIN tipo_de_logradouro tdl ON log.tipo_de_logradouro = tdl.id LEFT JOIN bairro bai ON end.bairro = bai.id LEFT JOIN cidade cid ON bai.cidade = cid.id LEFT JOIN uf ON cid.uf = uf.id LEFT JOIN pais ON uf.pais = pais.id WHERE end.id = $id;")){
			// Se selecionou pelo menos um
			if(mysqli_num_rows($db_query)){
				// Recebe os dados consultados
				$db_result = mysqli_fetch_row($db_query);

				// Os valida
				$pais               = $db_result[0];
				$uf                 = $db_result[1];
				$cidade             = $db_result[2];
				$bairro             = $db_result[3];
				$tipo_de_logradouro = $db_result[4];
				$logradouro         = $db_result[5];
				$numero             = (int) $db_result[6];
				$complemento        = $db_result[7];

				// Os concatena
				$nome = "$pais, $uf, $cidade";
				if($bairro)             $nome = "$nome, $bairro";
				if($tipo_de_logradouro) $nome = "$nome, $tipo_de_logradouro";
				if($logradouro)         $nome = "$nome $logradouro";
				if($numero)             $nome = "$nome, $numero"; else $nome = "$nome, S/N";
				if($complemento)        $nome = "$nome, $complemento";

				// E os exibe
				echo $nome;
			// Ao não encontrar o endereço
			} else echo 'Endereço inválido';

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);
		// Caso ocorrera uma falha na consulta à Base de Dados
		} else echo 'Erro na consulta com a Base de Dados.';

		// Finaliza a conexão com o servidor da Base de Dados
		mysqli_close($db_link);
	// Caso ocorrera uma falha na conexão com a Base de Dados
	} else require_once('db.link.err.echo.input.php');
// Para usuários não autenticados, não faz nada
} else exit();
