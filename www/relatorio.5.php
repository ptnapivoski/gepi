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
		$escola = (int) $_POST['escola'];
		$ano = (int) $_POST['ano'];

		// Seleciona tipo para checar se escola
		$query =  mysqli_query($db_link, "SELECT tipo_de_entidade FROM entidade WHERE id = $escola;");
		$row = mysqli_fetch_row($query);
		mysqli_free_result($query);
		$tipo_de_entidade = (int) $row[0];

		// Se escola
		if(in_array($tipo_de_entidade, array(5,6,7,8,9), true)){
			// Tenta selecionar dados
			if($db_query = mysqli_query($db_link, "SELECT diag.nome, COUNT(diag.id) FROM pessoa_fisica_e_escola pfe INNER JOIN pessoa_fisica_e_diagnostico pfd ON pfd.pessoa_fisica = pfe.pessoa_fisica LEFT JOIN diagnostico diag ON diag.id = pfd.diagnostico WHERE pfe.ano = $ano AND pfe.escola = $escola GROUP BY diag.id;")){
				// Se consulta retornou uma linha
				if(mysqli_num_rows($db_query) > 0){
					// Cabeçalhos
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename=relatorio.csv');

					// Seleciona nome da escola
					$query = mysqli_query($db_link, "SELECT nome FROM entidade WHERE id = $escola;");
					$row = mysqli_fetch_row($query);
					mysqli_free_result($query);
					$escola_n = str_replace(array("\t", "\r", "\n"), ' ', $row[0]);

					// Linha de informação do relatório
					echo "$escola_n\tAno de $ano\t", date('d/m/Y H:i:s'), "\r\n\r\n";

					// Linha de nome das colunas
					echo "Diagnóstico\tQuantidade de pessoas\r\n";

					// Para cala linha
					while($db_result = mysqli_fetch_row($db_query)){
						// A imprime
						echo $db_result[0], "\t", $db_result[1], "\r\n";
					}

					// Seleciona soma da cidade
					$query = mysqli_query($db_link, "SELECT COUNT(pfd.pessoa_fisica) FROM pessoa_fisica_e_escola pfe INNER JOIN pessoa_fisica_e_diagnostico pfd ON pfd.pessoa_fisica = pfe.pessoa_fisica WHERE pfe.ano = $ano AND pfe.escola = $escola;");
					$row = mysqli_fetch_row($query);
					mysqli_free_result($query);
					$num = (int) $row[0];

					// Linha da soma
					echo "\r\nSoma\t$num\r\n";
				// Caso contrário
				} else {
					// Configura erro
					require_once('no.data.err.php');
					// Volta para a página dos relatórios
					header('Location:relatorios.php');
				}
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Configura erro
				require_once('db.query.err.php');
				// Volta para a página dos relatórios
				header('Location:relatorios.php');
			}
		// Avisa caso contrário
		} else $_SESSION['msg'] = '<p class="error">Escola inválida.</p>';

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