<?php

// Inicializa ambiente
require_once('init.php');

// Invalida o usuário logado
$_SESSION['user'] = 0;
// Informa que houve a saída
$_SESSION['msg'] = '<p class="success">Saída executada.</p>';
// Direciona ao formulário de login
header('Location:login.form.php');
