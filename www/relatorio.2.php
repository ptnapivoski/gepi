<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Valida entrada
		$cidade = (int) $_POST['cidade'];
		$tecnologia = (int) $_POST['tecnologia'];

		// Tenta selecionar dados
		if($db_query = mysqli_query($db_link, "SELECT bai.nome, COUNT(bai.id) FROM pessoa_fisica_e_tecnologia pft LEFT JOIN pessoa_fisica pf ON pf.id = pft.pessoa_fisica LEFT JOIN entidade ent ON ent.id = pf.id INNER JOIN endereco ON endereco.id = ent.endereco LEFT JOIN bairro bai ON bai.id = endereco.bairro LEFT JOIN cidade cid ON cid.id = bai.cidade WHERE cid.id = $cidade AND pft.tecnologia = $tecnologia GROUP BY bai.id ORDER BY bai.nome ASC;")){

			// Se consulta retornou uma linha
			if(mysqli_num_rows($db_query) > 0){
				// Cabeçalhos
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename=relatorio.csv');
				// Linha de nome das colunas
				echo 'Bairro', "\t", 'Quantidade', "\r\n";

				// Para cala linha
				while($db_result = mysqli_fetch_row($db_query)){
					// A imprime
					echo $db_result[0], "\t", $db_result[1], "\r\n";
				}
			// Caso contrário
			} else {
				// Configura erro
				require_once('no.data.err.php');
				// Volta para a página dos relatórios
				header('Location:relatorios.php');
			}

			// Limpa consulta no servidor
			mysqli_free_result($db_query);
		// Caso não tenha conseguido realizar a consulta
		} else {
			// Configura erro
			require_once('db.query.err.php');
			// Volta para a página dos relatórios
			header('Location:relatorios.php');
		}

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Caso contrário
	} else {
		// Informa que há problema na conexão com o DB
		require_once('db.link.err.php');
		// Volta para a página dos relatórios
		header('Location:relatorios.php');
	}
// Se não logado
} else require_once('login.err.php');


/*
*/