<?php

// Seleciona-se e escapa-se o erro
$error = htmlspecialchars(mysqli_error($db_link));
// Seleciona-se a identificação numérica do erro
$errorn = mysqli_errno($db_link);

// Mensagens para cada erro
if($errorn === 1062)
	echo '<option value="0">Entrada já presente.</option>', $EOL;
else if($errorn === 1048)
	echo '<option value="0">Valor não pode ser vazio.</option>', $EOL;
else
	// E o inclui na mensagem passada ao usuário
	echo '<option value="0">Erro na consulta com a Base de Dados: ', $errorn, ' -> ', $error, '.</option>', $EOL;
