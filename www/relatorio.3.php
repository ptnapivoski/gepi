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
		$diagnostico = (int) $_POST['diagnostico'];
		$ano = (int) $_POST['ano'];

		// Se diagnóstico específico
		if($diagnostico > 0){
			// Tenta selecionar dados
			if($db_query = mysqli_query($db_link, "SELECT pfe.frequencia FROM pessoa_fisica_e_diagnostico pfd INNER JOIN pessoa_fisica_e_escola pfe ON pfe.pessoa_fisica = pfd.pessoa_fisica WHERE pfd.diagnostico = $diagnostico AND pfe.ano = $ano ORDER BY pfe.frequencia ASC;")){
				// Se consulta retornou uma linha
				if(mysqli_num_rows($db_query) > 0){
					// Cabeçalhos
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename=relatorio.csv');

					// Seleciona nome do diagnóstico
					$query = mysqli_query($db_link, "SELECT nome FROM diagnostico WHERE id = $diagnostico;");
					$row = mysqli_fetch_row($query);
					mysqli_free_result($query);
					$diagnostico_n = str_replace(array("\t", "\r", "\n"), ' ', $row[0]);

					// Linha de informação do relatório
					echo "$diagnostico_n\tAno de $ano\t", date('d/m/Y H:i:s'), "\r\n\r\n";

					// Linha de nome das colunas
					echo "Frequências\r\n";

					// Para cala linha
					while($db_result = mysqli_fetch_row($db_query)){
						// A imprime
						echo number_format($db_result[0], 2, ',', '.'), "\r\n";
					}

					// Seleciona média das frequências
					$query = mysqli_query($db_link, "SELECT AVG(pfe.frequencia) FROM pessoa_fisica_e_diagnostico pfd INNER JOIN pessoa_fisica_e_escola pfe ON pfe.pessoa_fisica = pfd.pessoa_fisica WHERE pfd.diagnostico = $diagnostico AND pfe.ano = $ano;");
					$row = mysqli_fetch_row($query);
					mysqli_free_result($query);
					$num = (double) $row[0];

					// Linha da média
					echo "\r\nMédia\t$num\r\n";
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
		// Todas as frequências daquele ano
		} else {
			// Tenta selecionar dados
			if($db_query = mysqli_query($db_link, "SELECT pfe.frequencia FROM pessoa_fisica_e_escola pfe WHERE pfe.ano = $ano ORDER BY pfe.frequencia ASC;")){
				// Se consulta retornou uma linha
				if(mysqli_num_rows($db_query) > 0){
					// Cabeçalhos
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename=relatorio.csv');

					// Linha de informação do relatório
					echo "Qualquer diagnóstico\tAno de $ano\t", date('d/m/Y H:i:s'), "\r\n\r\n";

					// Linha de nome das colunas
					echo "Frequências\r\n";

					// Para cala linha
					while($db_result = mysqli_fetch_row($db_query)){
						// A imprime
						echo number_format($db_result[0], 2, ',', '.'), "\r\n";
					}

					// Seleciona média das frequências
					$query = mysqli_query($db_link, "SELECT AVG(pfe.frequencia) FROM pessoa_fisica_e_diagnostico pfd INNER JOIN pessoa_fisica_e_escola pfe ON pfe.pessoa_fisica = pfd.pessoa_fisica WHERE pfe.ano = $ano;");
					$row = mysqli_fetch_row($query);
					mysqli_free_result($query);
					$num = (double) $row[0];

					// Linha da média
					echo "\r\nMédia\t$num\r\n";
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