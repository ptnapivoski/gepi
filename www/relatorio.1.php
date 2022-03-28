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
		$diagnostico = (int) $_POST['diagnostico'];

		// Tenta selecionar dados
		if($db_query = mysqli_query($db_link, "SELECT bai.nome, COUNT(bai.id) FROM pessoa_fisica_e_diagnostico pfd LEFT JOIN pessoa_fisica pf ON pf.id = pfd.pessoa_fisica LEFT JOIN entidade ent ON ent.id = pf.id INNER JOIN endereco ON endereco.id = ent.endereco LEFT JOIN bairro bai ON bai.id = endereco.bairro LEFT JOIN cidade cid ON cid.id = bai.cidade WHERE cid.id = $cidade AND pfd.diagnostico = $diagnostico GROUP BY bai.id ORDER BY bai.nome ASC;")){

			// Se consulta retornou uma linha
			if(mysqli_num_rows($db_query) > 0){
				// Cabeçalhos
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename=relatorio.csv');

				// Seleciona nome da cidade e sigla do estado
				$query = mysqli_query($db_link, "SELECT cidade.nome, uf.sigla FROM cidade LEFT JOIN uf ON uf.id = cidade.uf WHERE cidade.id = $cidade;");
				$row = mysqli_fetch_row($query);
				mysqli_free_result($query);
				$cidade_n = str_replace(array("\t", "\r", "\n"), ' ', $row[0]);
				$uf_s = str_replace(array("\t", "\r", "\n"), ' ', $row[1]);

				// Seleciona nome do diagnóstico
				$query = mysqli_query($db_link, "SELECT nome FROM diagnostico WHERE id = $diagnostico;");
				$row = mysqli_fetch_row($query);
				mysqli_free_result($query);
				$diagnostico_n = str_replace(array("\t", "\r", "\n"), ' ', $row[0]);

				// Linha de informação do relatório
				echo "$cidade_n";
				if($uf_s) echo " - $uf_s";
				echo "\t$diagnostico_n\t", date('d/m/Y H:i:s'), "\r\n\r\n";

				// Linha de nome das colunas
				echo "Bairro\tQuantidade\r\n";

				// Para cala linha
				while($db_result = mysqli_fetch_row($db_query)){
					// Caso bairro tenha caracteres que devam ser modificados
					$db_result[0] = str_replace(array("\t", "\r", "\n"), ' ', $db_result[0]);
					// A imprime
					echo $db_result[0], "\t", $db_result[1], "\r\n";
				}

				// Seleciona soma da cidade
				$query = mysqli_query($db_link, "SELECT COUNT(cid.id) FROM pessoa_fisica_e_diagnostico pfd LEFT JOIN pessoa_fisica pf ON pf.id = pfd.pessoa_fisica LEFT JOIN entidade ent ON ent.id = pf.id INNER JOIN endereco ON endereco.id = ent.endereco LEFT JOIN bairro bai ON bai.id = endereco.bairro LEFT JOIN cidade cid ON cid.id = bai.cidade WHERE cid.id = $cidade AND pfd.diagnostico = $diagnostico GROUP BY cid.id;");
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