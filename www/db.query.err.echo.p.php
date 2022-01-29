<?php

// Seleciona-se e escapa-se o erro
$error = htmlspecialchars(mysqli_error($db_link));
// Seleciona-se a identificação numérica do erro
$errorn = mysqli_errno($db_link);

// Mensagens para cada erro
if($errorn === 1062)
	echo '<p class="error">Entrada já presente.</p>', $EOL;
else
	// E o inclui na mensagem passada ao usuário
	echo '<p class="error">Erro na consulta com a Base de Dados: ', $errorn, ' -> ', $error, '.</p>', $EOL;
