<?php

// Informa que é necessária autenticação
$_SESSION['msg'] = '<p class="error">Autenticação requerida.</p>';
// Manda para o formulário de login
header('Location:login.form.php');
