<?php

// Caso exista mensagem para exibir
if(isset($_SESSION['msg'])){
	// A exibe
	echo '<section>', $_SESSION['msg'], '</section>', $EOL;
	// E a exclui
	unset($_SESSION['msg']);
}
