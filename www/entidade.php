<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Inclui começo padrão: abre html e head
	require_once('inc.top.php');
	// Coloca o título do documento
	echo '<title>GEPI: Entidade</title>', $EOL;
	// Inclue meio comum: css, jquery, fecha head e abre body
	require_once('inc.mid.php');
	// Coloca JavaScript da página
	echo '<script src="entidade.js"></script>', $EOL;

	// Aba a mostrar
	if(isset($_GET['tab'])) $tab = (int) $_GET['tab']; else $tab = 0;
	echo '<script>$(function(){';
	if($tab === 1)      echo 'show_sau();';
	else if($tab === 2) echo 'show_ed();';
	else if($tab === 3) echo 'show_assi();';
	else if($tab === 4) echo 'show_tra();';
	else if($tab === 5) echo 'show_vin();';
	else if($tab === 6) echo 'show_his();';
	else if($tab === 7) echo 'show_hab();';
	else if($tab === 8) echo 'show_mob();';
	else echo 'show_ge();';
	echo '});</script>';

	// Coloca JavaScript para CPF
	echo '<script src="cpf.js"></script>', $EOL;
	// Inclue menu
	require_once('inc.menu.php');
	// Inclue mensagem da sessão
	require_once('inc.msg.php');
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// ID da entidade a exibir
		$id = (int) $_GET['id'];

		// Tenta selecionar os dados da entidade
		if($db_query_1 = mysqli_query($db_link, "SELECT tipo_de_entidade, endereco, nome FROM entidade WHERE id = $id;")){
			// Se conseguiu selecionar a entidade
			if(mysqli_num_rows($db_query_1)){
				// Recebe os dados do servidor
				$db_result_1 = mysqli_fetch_row($db_query_1);
				// Valida os dados
				$db_result_1[0] = (int) $db_result_1[0];
				$db_result_1[1] = (int) $db_result_1[1];
				$db_result_1[2] = htmlspecialchars($db_result_1[2]);
				// Limpa a consulta no servidor
				mysqli_free_result($db_query_1);

				// Se for pessoa física, insere menu para ela
				if($db_result_1[0] === 1) echo
					'<nav>',
						'<ul>',
							'<li><a href="javascript:show_ge();">Geral</a></li>',
							'<li><a href="javascript:show_sau();">Saúde</a></li>',
							'<li><a href="javascript:show_ed();">Educação</a></li>',
							'<li><a href="javascript:show_assi();">Assistência social</a></li>',
							'<li><a href="javascript:show_tra();">Trabalho</a></li>',
							'<li><a href="javascript:show_hab();">Habitação</a></li>',
							'<li><a href="javascript:show_mob();">Mobilidade Urbana</a></li>',
							'<li><a href="javascript:show_vin();">Vínculos</a></li>',
							'<li><a href="javascript:show_his();">Histórico</a></li>',
						'</ul>',
					'</nav>', $EOL
				;

				echo
					// Começa a aba geral
					'<div id="tab-ge">', $EOL,
						'<section class="cad">', $EOL,
							// Se for pessoa física ou outro tipo de entidade
							'<h1>', ($db_result_1[0] === 1 ? 'Pessoa' : 'Entidade'), '</h1>', $EOL,
							// Formulário contendo os dados vindos da entidade
							'<form action="alterar.entidade.php" method="post">', $EOL,
								// Campo do ID
								'<p class="lab">',
									'<label>ID: <input type="number" name="id" readonly="readonly" value="', $id, '"/></label>',
								'</p>', $EOL,
								// Campo do nome da entidade
								'<p class="lab">',
									'<label>Nome: <input type="text" name="nome" id="nome" value="', $db_result_1[2], '"/></label>',
								'</p>', $EOL,
								// Campo do endereço
								'<p class="lab">',
									'<label>Endereço: <input type="number" name="endereco" id="endereco" value="" min="0"/></label> ',
									'<input type="text" readonly="readonly" class="address2" id="endereco-nome" value=""/>',
								'</p>', $EOL,
								'<p class="lab">',
									'<input type="submit" value="Alterar" onclick="return confirm(\'Tem certeza que deseja alterar?\');"/>',
								'</p>', $EOL,
							'</form>', $EOL,
							// Seleciona o endereço
							'<script>',
								'$(function(){',
									'$(\'#endereco\').val(', $db_result_1[1], ');',
									'$(\'#endereco\').change();',
								'});',
							'</script>', $EOL,
						'</section>', $EOL
				;

				// Se pessoa física
				if($db_result_1[0] === 1){
					echo
						'<section class="cad">', $EOL,
							// Começa a seção dos dados pessoais
							'<h1>Dados pessoais</h1>', $EOL
					;

					// Tenta selecionar os dados daquela pessoa
					if($db_query_2 = mysqli_query($db_link, "SELECT nascimento, cpf, rg, sus, nis, certidao_de_nascimento, genero, raca, estado_civil, renda, escolaridade, naturalidade FROM pessoa_fisica WHERE id = $id;")){
						if(mysqli_num_rows($db_query_2)){
							// Recebe os dados da consulta
							$db_result_2 = mysqli_fetch_row($db_query_2);
							// Limpa a query no servidor
							mysqli_free_result($db_query_2);
							// Valida dados
							$nascimento             = htmlspecialchars($db_result_2[0]);
							$cpf                    = htmlspecialchars($db_result_2[1]);
							$rg                     = htmlspecialchars($db_result_2[2]);
							$sus                    = htmlspecialchars($db_result_2[3]);
							$nis                    = htmlspecialchars($db_result_2[4]);
							$certidao_de_nascimento = htmlspecialchars($db_result_2[5]);
							$genero                 = (int) $db_result_2[6];
							$raca                   = (int) $db_result_2[7];
							$estado_civil           = (int) $db_result_2[8];
							$renda                  = htmlspecialchars($db_result_2[9]);
							$escolaridade           = (int) $db_result_2[10];
							$naturalidade           = (int) $db_result_2[11];

							// Insere o formulário para alteração dos dados vindos da Base de Dados
							echo
								'<form action="alterar.pessoa.fisica.php" method="post">', $EOL,
									// Campo da data de nascimento
									'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
									'<p class="lab">', $EOL,
										'<label>Nascimento: <input type="date" name="nascimento" value="', $nascimento, '"/></label>', $EOL,
									'</p>', $EOL,
									// Campo do RG
									'<p class="lab">', $EOL,
										'<label>RG: <input type="text" name="rg" value="', $rg, '"/></label>', $EOL,
									'</p>', $EOL,
									// Campo do NIS
									'<p class="lab">', $EOL,
										'<label>NIS: <input type="text" name="nis" value="', $nis, '"/></label>', $EOL,
									'</p>', $EOL,
									// Campo do CPF
									'<p class="lab">', $EOL,
										'<label>CPF: <input type="text" name="cpf" value="', $cpf, '" id="cpf"/></label>', $EOL,
									'</p>', $EOL,
									// Campo do cartão do SUS
									'<p class="lab">', $EOL,
										'<label>SUS: <input type="text" name="sus" value="', $sus, '"/></label>', $EOL,
									'</p>', $EOL
							;

							// Tenta selecionar as raças
							if($db_query_3 = mysqli_query($db_link, "SELECT id, nome FROM raca ORDER BY id;")){
								// Se selecionou raças
								if(mysqli_num_rows($db_query_3)){
									// Começa o select das raças
									echo
										'<p class="select-field">', $EOL,
											'<label>Raça: ', $EOL,
												'<select name="raca">', $EOL,
													'<option value="0">Selecione uma raça</option>', $EOL
									;

									// Para cada raça selecionada
									while($db_result_3 = mysqli_fetch_row($db_query_3)){
										// Valida dados vindos
										$db_result_3[0] = (int) $db_result_3[0];
										$db_result_3[1] = htmlspecialchars($db_result_3[1]);
										echo '<option value="', $db_result_3[0], '"', ($db_result_3[0] === $raca ? ' selected="selected"' : ''), '>', $db_result_3[1], '</option>', $EOL;
									}

									echo

												'</select>', $EOL,
											'</label>', $EOL,
										'</p>', $EOL
									;
								}

								// Limpa a query no servidor
								mysqli_free_result($db_query_3);
							// Caso ocorra problema com a consulta
							} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

							// Tenta selecionar os gêneros
							if($db_query_3 = mysqli_query($db_link, "SELECT id, nome FROM genero ORDER BY id;")){
								// Se selecionou gêneros
								if(mysqli_num_rows($db_query_3)){
									// Começa o select dos gêneros
									echo
										'<p class="select-field">', $EOL,
											'<label>Gênero: ', $EOL,
												'<select name="genero">', $EOL,
													'<option value="0">Selecione um gênero</option>', $EOL
									;

									// Para cada gênero selecionado
									while($db_result_3 = mysqli_fetch_row($db_query_3)){
										// Valida dados vindos
										$db_result_3[0] = (int) $db_result_3[0];
										$db_result_3[1] = htmlspecialchars($db_result_3[1]);
										echo '<option value="', $db_result_3[0], '"', ($db_result_3[0] === $genero ? ' selected="selected"' : ''), '>', $db_result_3[1], '</option>', $EOL;
									}

									echo

												'</select>', $EOL,
											'</label>', $EOL,
										'</p>', $EOL
									;
								}

								// Limpa a query no servidor
								mysqli_free_result($db_query_3);
							// Caso ocorra problema com a consulta
							} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

							// Tenta selecionar os estados civis
							if($db_query_3 = mysqli_query($db_link, "SELECT id, nome FROM estado_civil ORDER BY id;")){
								// Se selecionou estados civis
								if(mysqli_num_rows($db_query_3)){
									// Começa o select dos estados civis
									echo
										'<p class="select-field">', $EOL,
											'<label>Estado civil: ', $EOL,
												'<select name="estado_civil">', $EOL,
													'<option value="0">Selecione um estado civil</option>', $EOL
									;

									// Para cada estado civil selecionado
									while($db_result_3 = mysqli_fetch_row($db_query_3)){
										// Valida dados vindos
										$db_result_3[0] = (int) $db_result_3[0];
										$db_result_3[1] = htmlspecialchars($db_result_3[1]);
										echo '<option value="', $db_result_3[0], '"', ($db_result_3[0] === $estado_civil ? ' selected="selected"' : ''), '>', $db_result_3[1], '</option>', $EOL;
									}

									echo

												'</select>', $EOL,
											'</label>', $EOL,
										'</p>', $EOL
									;
								}

								// Limpa a query no servidor
								mysqli_free_result($db_query_3);
							// Caso ocorra problema com a consulta
							} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

							// Tenta selecionar as escolaridades
							if($db_query_3 = mysqli_query($db_link, "SELECT id, nome FROM escolaridade ORDER BY id;")){
								// Se selecionou escolaridades
								if(mysqli_num_rows($db_query_3)){
									// Começa o select das escolaridades
									echo
										'<p class="select-field">', $EOL,
											'<label>Escolaridade: ', $EOL,
												'<select name="escolaridade">', $EOL,
													'<option value="0">Selecione uma escolaridade</option>', $EOL
									;

									// Para cada escolaridade selecionada
									while($db_result_3 = mysqli_fetch_row($db_query_3)){
										// Valida dados vindos
										$db_result_3[0] = (int) $db_result_3[0];
										$db_result_3[1] = htmlspecialchars($db_result_3[1]);
										echo '<option value="', $db_result_3[0], '"', ($db_result_3[0] === $escolaridade ? ' selected="selected"' : ''), '>', $db_result_3[1], '</option>', $EOL;
									}

									echo

												'</select>', $EOL,
											'</label>', $EOL,
										'</p>', $EOL
									;
								}

								// Limpa a query no servidor
								mysqli_free_result($db_query_3);
							// Caso ocorra problema com a consulta
							} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

							echo
									// Campo da renda
									'<p class="lab">', $EOL,
										'<label>Renda: <input type="number" name="renda" step="0.01" value="', $renda, '" min="0"/></label>', $EOL,
									'</p>', $EOL,
									// Campo da certidão de nascimento
									'<p class="lab">', $EOL,
										'<label>Certidão de nascimento: <input type="text" name="certidao_de_nascimento" value="', $certidao_de_nascimento, '"/></label>', $EOL,
									'</p>', $EOL,
									// Campo da naturalidade
									'<p class="lab">',
										'<label>Naturalidade: <input type="number" name="naturalidade" id="naturalidade" value="" min="0"/></label> ',
										'<input type="text" readonly="readonly" class="address2" id="naturalidade-nome" value=""/>',
									'</p>', $EOL,
									// Botão de alterar que valida o CPF
									'<p class="lab">', $EOL,
										'<input type="submit" value="Alterar" onclick="if(confirm(\'Tem certeza que deseja alterar?\')) return validacpf(); else return false;"/>', $EOL,
									'</p>', $EOL,
								'</form>', $EOL,
								// Seleciona a naturalidade
								'<script>',
									'$(function(){',
										'$(\'#naturalidade\').val(', $naturalidade, ');',
										'$(\'#naturalidade\').change();',
									'});',
								'</script>', $EOL
							;
						}

					// Caso ocorra problema com a consulta
					} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

					echo
						'</section>', $EOL,
						'<section class="cad">', $EOL,
							// Começa a seção das tecnologias às quais a pessoa tem acesso
							'<h1>Tecnologias</h1>', $EOL
					;

					// Tenta selecionar as tecnologias às quais a pessoa tem acesso
					if($db_query_2 = mysqli_query($db_link, "SELECT tec.id, tec.nome FROM pessoa_fisica_e_tecnologia pft LEFT JOIN tecnologia tec ON tec.id = pft.tecnologia WHERE pft.pessoa_fisica = $id;")){
						// Se selecionou pelo menos uma tecnologia
						if(mysqli_num_rows($db_query_2)){
							// Inicia as linhas
							echo '<div class="but">', $EOL;

							// Para cada selecionado
							while($db_result_2 = mysqli_fetch_row($db_query_2)){
								// Trata as entradas
								$tecnologia   = (int) $db_result_2[0];
								$tecnologia_n = htmlspecialchars($db_result_2[1]);

								// Imprime em campos num formulário para exclusão
								echo
									'<form action="excluir.pessoa.fisica.e.tecnologia.php" method="post">', $EOL,
										'<p class="lab">',
											'<input type="hidden" name="id" value="', $id, '"/>',
											'<input type="hidden" name="tecnologia" value="', $tecnologia, '"/>',
											'<input readonly="readonly" type="text" value="', $tecnologia_n, '" class="name"/> ',
											'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir a tecnologia?\');"/>',
										'</p>', $EOL,
									'</form>', $EOL
								;
							}

							// Finaliza linhas
							echo '</div>', $EOL;
						// Caso não tenha selecionado alguma tecnologia
						} else echo '<p class="but">Nenhuma tecnologia a listar</p>', $EOL;
					// Caso tenha ocorrido problema com a consulta
					} else {
						// Seleciona-se e escapa-se o erro
						$error = htmlspecialchars(mysqli_error($db_link));
						// E o inclui na mensagem passada ao usuário
						echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
					}

					// Tenta selecionar as tecnologias
					if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM tecnologia ORDER BY nome;")){
						// Ao selecionar pelo menos uma tecnologia
						if(mysqli_num_rows($db_query_2)){
							// Gera formulário para inserção
							echo
								'<form action="adicionar.pessoa.fisica.e.tecnologia.php" method="post" class="new">', $EOL,
									'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
									'<select name="tecnologia">',
										'<option value="0">Selecione tecnologia</option>'
							;

							// Para cada possível tecnologia existente cadastrada
							while($db_result_2 = mysqli_fetch_row($db_query_2)){
								// Trata entrada
								$db_result_2[0] = (int) $db_result_2[0];
								$db_result_2[1] = htmlspecialchars($db_result_2[1]);
								echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
							}

							// Limpa consulta no servidor
							mysqli_free_result($db_query_2);

							echo
									'</select>', $EOL,
									'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar a tecnologia?\');"/>', $EOL,
								'</form>', $EOL
							;
						// Caso não tenha selecionado tecnologias
						} else echo '<p class="but">Nenhuma tecnologia a listar</p>', $EOL;
					// Caso tenha ocorrido problema com a consulta
					} else {
						// Seleciona-se e escapa-se o erro
						$error = htmlspecialchars(mysqli_error($db_link));
						// E o inclui na mensagem passada ao usuário
						echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
					}

					echo
						'</section>', $EOL
					;
				}

				// Começa seção dos emails
				echo
					'<section class="cad">', $EOL,
						'<h1>E-mails</h1>', $EOL
				;

				// Seleciona os emails da entidade
				if($db_query_2 = mysqli_query($db_link, "SELECT email FROM email WHERE entidade = $id;")){
					// Se selecionou pelo menos um
					if(mysqli_num_rows($db_query_2)){
						// Inicia tabela
						echo '<table>', $EOL;
						// Para cada email selecionado
						while($db_result_2 = mysqli_fetch_row($db_query_2)){
							// Valida os dados vindos
							$db_result_2[0] = htmlspecialchars($db_result_2[0]);
							// Imprime
							echo
								'<tr>', $EOL,
									'<td>', $EOL,
										'<form action="excluir.email.php" method="post">', $EOL,
											'<input type="hidden" name="id" value="', $id, '"/>',
											'<input type="text" name="email" class="name" required="required" value="', $db_result_2[0], '"/> ',
											'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este email?\');"/>', $EOL,
										'</form>', $EOL,
									'</td>', $EOL,
								'</tr>', $EOL
							;
						}
						// Finaliza a tabela
						echo '</table>', $EOL;
					}

					// Limpa a query no servidor
					mysqli_free_result($db_query_2);
				// Caso ocorra problema com a consulta
				} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

				echo
						// Formulário de inserção de email
						'<form action="adicionar.email.php" method="post" class="new">', $EOL,
							'<p>',
								'<input type="hidden" name="id" value="', $id,'" />',
								'<label>Novo: <input type="text" name="email" id="novo-email" required="required" value="" /></label> ',
								'<input type="submit" value="Inserir" onclick="if($(\'#novo-email\').val()) return confirm(\'Tem certeza que deseja inserir o email \\\'\' + $(\'#novo-email\').val() + \'\\\'?\');"/>',
							'</p>', $EOL,
						'</form>', $EOL,
					// Termina seção dos emails
					'</section>', $EOL,
					// Começa seção dos telefones
					'<section class="cad">', $EOL,
						'<h1>Telefones</h1>', $EOL
				;

				// Seleciona os telefones da entidade
				if($db_query_2 = mysqli_query($db_link, "SELECT telefone, obs FROM telefone WHERE entidade = $id;")){
					// Se selecionou pelo menos um
					if(mysqli_num_rows($db_query_2)){
						// Inicia tabela
						echo '<table>', $EOL;
						// Para cada telefone selecionado
						while($db_result_2 = mysqli_fetch_row($db_query_2)){
							// Valida os dados vindos
							$db_result_2[0] = htmlspecialchars($db_result_2[0]);
							$db_result_2[1] = htmlspecialchars($db_result_2[1]);
							// Imprime
							echo
								'<tr>', $EOL,
									'<td>', $EOL,
										'<form action="excluir.telefone.php" method="post">', $EOL,
											'<input type="hidden" name="id" value="', $id, '"/>',
											'<input type="text" name="telefone" class="name" required="required" value="', $db_result_2[0], '"/> ',
											'<label>Obs: <input type="text" value="', $db_result_2[1], '"/></label> ',
											'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este telefone?\');"/>', $EOL,
										'</form>', $EOL,
									'</td>', $EOL,
								'</tr>', $EOL
							;
						}
						// Finaliza a tabela
						echo '</table>', $EOL;
					}

					// Limpa a consulta no servidor
					mysqli_free_result($db_query_2);
				// Caso ocorra problema com a consulta
				} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

				echo
							// Formulário de inserção de telefone
							'<form action="adicionar.telefone.php" method="post" class="new">', $EOL,
								'<p>',
									'<input type="hidden" name="id" value="', $id,'" />',
									'<label>Novo: <input type="text" name="telefone" id="novo-telefone" required="required" value="" /></label> ',
									'<label>Obs: <input type="text" name="obs" value=""/></label> ',
									'<input type="submit" value="Inserir" onclick="if($(\'#novo-telefone\').val()) return confirm(\'Tem certeza que deseja inserir o telefone \\\'\' + $(\'#novo-telefone\').val() + \'\\\'?\');"/>',
								'</p>', $EOL,
							'</form>', $EOL,
						// Termina seção dos emails
						'</section>', $EOL,
					'</div>', $EOL
				;

				// Se pessoa física, imprime as seções pertinentes
				if($db_result_1[0] === 1){
					// Insere manipulação de permissões
					require_once('perm.php');

					echo
						'<div id="tab-sau">', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Diagnósticos</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 73, $id)){
						// Tenta selecionar os diagnósticos da pessoa em questão
						if($db_query_2 = mysqli_query($db_link, "SELECT diag.id, diag.nome, diag.cid, pfd.permanente, sdd.nome FROM pessoa_fisica_e_diagnostico pfd LEFT JOIN diagnostico diag ON diag.id = pfd.diagnostico LEFT JOIN status_de_diagnostico sdd ON sdd.id = pfd.status_de_diagnostico WHERE pfd.pessoa_fisica = $id;")){
							// Se selecionou pelo menos um diagnóstico
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$diagnostico             = (int) $db_result_2[0];
									$diagnostico_n           = htmlspecialchars($db_result_2[1]);
									$diagnostico_cid         = htmlspecialchars($db_result_2[2]);
									$permanente              = (int) $db_result_2[3];
									$status_de_diagnostico_n = htmlspecialchars($db_result_2[4]);

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.diagnostico.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="diagnostico" value="', $diagnostico, '"/>',
												'<input readonly="readonly" type="text" value="', $diagnostico_cid, '" class="cid"/> ',
												'<input readonly="readonly" type="text" value="', $diagnostico_n, '"/> ',
												'<input readonly="readonly" type="text" value="', $status_de_diagnostico_n, '"/> ',
												'<input readonly="readonly" type="text" value="'
									;

									if($permanente === 1) echo 'Permanente';
									else echo 'Provisório';

									echo '"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o diagnóstico?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado algum diagnóstico da pessoa
							} else echo '<p class="but">Nenhum diagnóstico a listar</p>', $EOL;

							// Limpa consulta
							mysqli_free_result($db_query_2);
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar os diagnósticos e status de diagnóstico
						$db_query_2 = mysqli_query($db_link, "SELECT id, cid, nome, ISNULL(cid) isnullcid FROM diagnostico ORDER BY isnullcid, cid, nome;");
						$db_query_3 = mysqli_query($db_link, "SELECT id, nome FROM status_de_diagnostico ORDER BY id;");
						if($db_query_2 && $db_query_3){
							// Ao selecionar pelo menos um diagnóstico e pelo menos um status de diagnóstico
							if(mysqli_num_rows($db_query_2) && mysqli_num_rows($db_query_3)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.diagnostico.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'<select name="diagnostico">',
											'<option value="0">Selecione diagnóstico</option>'
								;

								// Para cada possível diagnóstico existente cadastrado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									$db_result_2[2] = htmlspecialchars($db_result_2[2]);
									echo '<option value="', $db_result_2[0], '">';
									if($db_result_2[1] !== '') echo $db_result_2[1], ' - ';
									echo $db_result_2[2], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'<select name="status_de_diagnostico">',
											'<option value="0">Selecione status do diagnóstico</option>'
								;

								// Para cada possível diagnóstico existente cadastrado
								while($db_result_3 = mysqli_fetch_row($db_query_3)){
									// Trata entrada
									$db_result_3[0] = (int) $db_result_3[0];
									$db_result_3[1] = htmlspecialchars($db_result_3[1]);
									echo '<option value="', $db_result_3[0], '">', $db_result_3[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_3);

								echo
										'</select>', $EOL,
										'<select name="permanente">',
											'<option value="0">Selecione se permanente ou não</option>',
											'<option value="1">Permanete</option>',
											'<option value="2">Provisório</option>',
										'</select>', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar o diagnóstico?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado diagnósticos
							} else echo '<p class="but">Nenhum diagnóstico a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
							// Limpa consultas que deram certo
							if($db_query_2) mysqli_free_result($db_query_2);
							if($db_query_3) mysqli_free_result($db_query_3);
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
						'</div>', $EOL,
						'<div id="tab-ed">', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Histórico escolar</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 75, $id)){
						// Tenta selecionar o histórico escolar da pessoa em questão
						if($db_query_2 = mysqli_query($db_link, "SELECT ent.id, ent.nome, pfe.ano, se.id, se.nome, te.nome, pfe.frequencia, pfe.repetencia FROM pessoa_fisica_e_escola pfe LEFT JOIN entidade ent ON ent.id = pfe.escola LEFT JOIN serie_escolar se ON se.id = pfe.serie_escolar LEFT JOIN turno_escolar te ON te.id = pfe.turno_escolar WHERE pfe.pessoa_fisica = $id ORDER BY pfe.ano DESC;")){
							// Se selecionou pelo menos um histórico escolar
							if(mysqli_num_rows($db_query_2)){
								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$escola     = (int) $db_result_2[0];
									$escola_n   = htmlspecialchars($db_result_2[1]);
									$ano        = (int) $db_result_2[2];
									$serie      = (int) $db_result_2[3];
									$serie_n    = htmlspecialchars($db_result_2[4]);
									$turno_n    = htmlspecialchars($db_result_2[5]);
									$freq       = (double) $db_result_2[6];
									$repetencia = (int) $db_result_2[7];

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.escola.php" method="post" class="but">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="escola" value="', $escola, '"/>',
												'<input type="hidden" name="serie" value="', $serie, '"/>',
												'<input readonly="readonly" type="text" value="', $escola_n, '" class="name"/> ',
												'<input readonly="readonly" type="number" name="ano" value="', $ano, '"/> ',
												'<input readonly="readonly" type="text" value="', $serie_n, '" class="name"/> ',
												'<input readonly="readonly" type="text" value="', $turno_n, '"/> ',
												'<label>Repetência: <input readonly="readonly" type="number" value="', $repetencia, '"/></label> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o histórico escolar?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;

									// Imprime em campos num formulário para alteração de frequência
									echo
										'<form action="alterar.pessoa.fisica.e.escola.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="ano" value="', $ano, '"/>',
												'<input type="hidden" name="escola" value="', $escola, '"/>',
												'<input type="hidden" name="serie" value="', $serie, '"/>',
												'<label>Frequência: ',
													'<input type="number" name="frequencia" value="', $freq, '" min="0" max="100" step="0.01"/> ',
												'</label>',
												'<input type="submit" value="Alterar" onclick="return confirm(\'Tem certeza que deseja alterar a frequência do histórico escolar?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}
							// Caso não tenha selecionado algum histórico escolar
							} else echo '<p class="but">Nenhum histórico escolar a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar as séries escolares e os turnos
						$db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM serie_escolar ORDER BY id;");
						$db_query_3 = mysqli_query($db_link, "SELECT id, nome FROM turno_escolar ORDER BY id;");
						if($db_query_2 && $db_query_3){
							// Ao selecionar pelo menos uma série escolar e pelo menos um turno
							if(mysqli_num_rows($db_query_2) && mysqli_num_rows($db_query_3)){
								// Gera formulário para inserção
								echo
									'<p class="but">Adicionar</p>', $EOL,
									'<p class="lab">', $EOL,
										'<form action="adicionar.pessoa.fisica.e.escola.php" method="post">', $EOL,
											'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
											'<input type="number" name="escola" id="escola" value="0" min="0"/> ', $EOL,
											'<input type="text" id="escola-nome" value="" class="name"/> ', $EOL,
											'<input type="number" name="ano" value="', date('Y'), '" min="0"/> ', $EOL,
											'<select name="serie">',
												'<option value="0">Selecione série escolar</option>'
								;

								// Para cada possível série escolar existente cadastrada
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
											'</select>', $EOL,
											'<select name="turno">',
												'<option value="0">Selecione turno escolar</option>'
								;

								// Para cada possível turno escolar existente cadastrado
								while($db_result_3 = mysqli_fetch_row($db_query_3)){
									// Trata entrada
									$db_result_3[0] = (int) $db_result_3[0];
									$db_result_3[1] = htmlspecialchars($db_result_3[1]);
									echo '<option value="', $db_result_3[0], '">', $db_result_3[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_3);

								echo
											'</select>', $EOL,
											'<input type="number" name="repetencia" id="repetencia" value="" min="0" placeholder="Repetência" style="width:85px" /> ', $EOL,
											'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar o histórico escolar?\');"/>', $EOL,
										'</form>', $EOL,
									'</p>', $EOL
								;
							// Caso não tenha selecionado séries escolares e turnos
							} else echo '<p class="but">Séries escolares ou turnos inexistentes</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
							// Limpa consultas que deram certo
							if($db_query_2) mysqli_free_result($db_query_2);
							if($db_query_3) mysqli_free_result($db_query_3);
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Barreiras no ensino</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 75, $id)){
						// Tenta selecionar as barreiras no ensino da pessoa em questão
						if($db_query_2 = mysqli_query($db_link, "SELECT bar.id, bar.nome FROM pessoa_fisica_e_barreira_no_ensino pfbe LEFT JOIN barreira bar ON bar.id = pfbe.barreira_no_ensino WHERE pfbe.pessoa_fisica = $id;")){
							// Se selecionou pelo menos uma barreira
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$barreira   = (int) $db_result_2[0];
									$barreira_n = htmlspecialchars($db_result_2[1]);

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.barreira.no.ensino.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="barreira" value="', $barreira, '"/>',
												'<input readonly="readonly" type="text" value="', $barreira_n, '" class="name"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir esta barreira no ensino?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado alguma barreira
							} else echo '<p class="but">Nenhuma barreira a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar as barreiras
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM barreira ORDER BY nome;")){
							// Ao selecionar pelo menos uma barreira
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.barreira.no.ensino.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'<select name="barreira">',
											'<option value="0">Selecione barreira</option>'
								;

								// Para cada possível barreira existente cadastrado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar a barreira?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado barreiras
							} else echo '<p class="but">Nenhuma barreira a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
						'</div>', $EOL,
						'<div id="tab-assi">', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Benefícios</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 77, $id)){
						// Tenta selecionar os benefícios da pessoa em questão
						if($db_query_2 = mysqli_query($db_link, "SELECT ben.id, ben.nome, pfb.quantidade FROM pessoa_fisica_e_beneficio pfb LEFT JOIN beneficio ben ON ben.id = pfb.beneficio WHERE pfb.pessoa_fisica = $id;")){
							// Se selecionou pelo menos um benefício
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$beneficio   = (int) $db_result_2[0];
									$beneficio_n = htmlspecialchars($db_result_2[1]);
									$quantidade  = (double) $db_result_2[2];

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.beneficio.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="beneficio" value="', $beneficio, '"/>',
												'<input readonly="readonly" type="text" value="', $beneficio_n, '" class="name"/> ',
												'<input readonly="readonly" type="number" value="', $quantidade, '"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o benefício?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado algum benefício
							} else echo '<p class="but">Nenhum benefício a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar os benefícios
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM beneficio ORDER BY nome;")){
							// Ao selecionar pelo menos um benefício
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.beneficio.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'<select name="beneficio">',
											'<option value="0">Selecione benefício</option>'
								;

								// Para cada possível benefício existente cadastrado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'<input type="number" name="quantidade" step="0.01" min="0"/> ', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar o benefício?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado benefícios
							} else echo '<p class="but">Nenhum benefício a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Conhecimento de Serviço de Assistência Social</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 77, $id)){
						// Tenta selecionar os serviços de assistência social dos quais a pessoa tem conhecimento
						if($db_query_2 = mysqli_query($db_link, "SELECT sas.id, sas.nome FROM pessoa_fisica_e_conhecimento_de_servico_de_as pfcsas LEFT JOIN servico_de_as sas ON sas.id = pfcsas.conhecimento WHERE pfcsas.pessoa_fisica = $id;")){
							// Se selecionou pelo menos um serviço
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$servico   = (int) $db_result_2[0];
									$servico_n = htmlspecialchars($db_result_2[1]);

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.conhecimento.de.servico.de.as.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="servico" value="', $servico, '"/>',
												'<input readonly="readonly" type="text" value="', $servico_n, '" class="name"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o serviço?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado algum serviço
							} else echo '<p class="but">Nenhum serviço a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar os serviços de assistência social
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM servico_de_as ORDER BY nome;")){
							// Ao selecionar pelo menos um serviço
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.conhecimento.de.servico.de.as.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'<select name="servico">',
											'<option value="0">Selecione serviço</option>'
								;

								// Para cada possível serviço existente cadastrado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar o serviço de assistência social?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado serviços
							} else echo '<p class="but">Nenhum serviço a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Uso de Serviço de Assistência Social</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 77, $id)){
						// Tenta selecionar os serviços de assistência social dos quais a pessoa faz uso
						if($db_query_2 = mysqli_query($db_link, "SELECT sas.id, sas.nome FROM pessoa_fisica_e_uso_de_servico_de_as pfusas LEFT JOIN servico_de_as sas ON sas.id = pfusas.uso WHERE pfusas.pessoa_fisica = $id;")){
							// Se selecionou pelo menos um serviço
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$servico   = (int) $db_result_2[0];
									$servico_n = htmlspecialchars($db_result_2[1]);

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.uso.de.servico.de.as.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="servico" value="', $servico, '"/>',
												'<input readonly="readonly" type="text" value="', $servico_n, '" class="name"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o serviço?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado algum serviço
							} else echo '<p class="but">Nenhum serviço a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar os serviços de assistência social
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM servico_de_as ORDER BY nome;")){
							// Ao selecionar pelo menos um serviço
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.uso.de.servico.de.as.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'<select name="servico">',
											'<option value="0">Selecione serviço</option>'
								;

								// Para cada possível serviço existente cadastrado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar o serviço de assistência social?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado serviços
							} else echo '<p class="but">Nenhum serviço a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Uso de Serviço de Defesa dos Direitos da Pessoa com Deficiência</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 77, $id)){
						// Tenta selecionar os serviços de defesa dos direitos da pessoa com deficiência dos quais a pessoa faz uso
						if($db_query_2 = mysqli_query($db_link, "SELECT sddpd.id, sddpd.nome FROM pessoa_fisica_e_uso_de_servico_de_ddpd pfusddpd LEFT JOIN servico_de_ddpd sddpd ON sddpd.id = pfusddpd.uso WHERE pfusddpd.pessoa_fisica = $id;")){
							// Se selecionou pelo menos um serviço
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$servico   = (int) $db_result_2[0];
									$servico_n = htmlspecialchars($db_result_2[1]);

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.uso.de.servico.de.ddpd.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="servico" value="', $servico, '"/>',
												'<input readonly="readonly" type="text" value="', $servico_n, '" class="name"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o serviço?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado algum serviço
							} else echo '<p class="but">Nenhum serviço a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar os serviços de assistência social
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM servico_de_ddpd ORDER BY nome;")){
							// Ao selecionar pelo menos um serviço
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.uso.de.servico.de.ddpd.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'<select name="servico">',
											'<option value="0">Selecione serviço</option>'
								;

								// Para cada possível serviço existente cadastrado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar o serviço de defesa dos direitos da pessoa com deficiência?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado serviços
							} else echo '<p class="but">Nenhum serviço a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
						'</div>', $EOL,
						'<div id="tab-tra">', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Histórico de trabalho</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 79, $id)){
						// Tenta selecionar para quem a pessoa trabalha ou trabalhou
						if($db_query_2 = mysqli_query($db_link, "SELECT ent.id, ent.nome, prof.id, prof.nome, pft.passado FROM pessoa_fisica_e_trabalho pft LEFT JOIN entidade ent ON ent.id = pft.para LEFT JOIN profissao prof ON prof.id = pft.como WHERE pft.pessoa_fisica = $id;")){
							// Se selecionou pelo menos um trabalho da pessoa
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$ent     = (int) $db_result_2[0];
									$ent_n   = htmlspecialchars($db_result_2[1]);
									$prof    = (int) $db_result_2[2];
									$prof_n  = htmlspecialchars($db_result_2[3]);
									$passado = (int) $db_result_2[4];

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.trabalho.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="ent" value="', $ent, '"/>',
												'<input type="hidden" name="prof" value="', $prof, '"/>',
												'Para <input readonly="readonly" type="text" value="', $ent_n, '" class="name"/> ',
												'<input readonly="readonly" type="text" value="', ($passado === 1 ? 'Trabalhou' : 'Trabalha'), '"/> ',
												'como <input readonly="readonly" type="text" value="', $prof_n, '" class="name"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este histórico de trabalho?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado algum trabalho
							} else echo '<p class="but">Nenhum histórico de trabalho a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar as profissões
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM profissao ORDER BY nome;")){
							// Ao selecionar pelo menos uma profissão
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.trabalho.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'Para <input type="number" name="trabalha-para" id="trabalha-para" value="0" min="0"/> ', $EOL,
										'<input type="text" id="trabalha-para-nome" value="" class="name"/> ', $EOL,
										'<select name="passado">',
											'<option value="1">Trabalhou</option>',
											'<option value="0">Trabalha</option>',
										'</select>', $EOL,
										'como <select name="profissao">',
											'<option value="0">Selecione profissão</option>'
								;

								// Para cada possível barreira existente cadastrado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar o histórico de trabalho?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado profissões
							} else echo '<p class="but">Nenhuma profissão a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Qualificação</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 79, $id)){
						// Tenta selecionar as qualificações da pessoa em questão
						if($db_query_2 = mysqli_query($db_link, "SELECT prof.id, prof.nome FROM pessoa_fisica_e_qualificacao pfq LEFT JOIN profissao prof ON prof.id = pfq.qualificacao WHERE pfq.pessoa_fisica = $id;")){
							// Se selecionou pelo menos uma qualificação
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$qualificacao   = (int) $db_result_2[0];
									$qualificacao_n = htmlspecialchars($db_result_2[1]);

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.qualificacao.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="qualificacao" value="', $qualificacao, '"/>',
												'<input readonly="readonly" type="text" value="', $qualificacao_n, '" class="name"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir esta qualificação?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado alguma qualificação
							} else echo '<p class="but">Nenhuma qualificação a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar as profissões
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM profissao ORDER BY nome;")){
							// Ao selecionar pelo menos uma profissão
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.qualificacao.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'<select name="qualificacao">',
											'<option value="0">Selecione profissão</option>'
								;

								// Para cada possível profissão existente cadastrada
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar a qualificação?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado profissões
							} else echo '<p class="but">Nenhuma profissão a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Interesse em qualificação</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 79, $id)){
						// Tenta selecionar os interesses em qualificações da pessoa em questão
						if($db_query_2 = mysqli_query($db_link, "SELECT prof.id, prof.nome FROM pessoa_fisica_e_interesse_em_qualificacao pfiq LEFT JOIN profissao prof ON prof.id = pfiq.interesse WHERE pfiq.pessoa_fisica = $id;")){
							// Se selecionou pelo menos um interesse em qualificação
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$interesse   = (int) $db_result_2[0];
									$interesse_n = htmlspecialchars($db_result_2[1]);

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.interesse.em.qualificacao.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="interesse" value="', $interesse, '"/>',
												'<input readonly="readonly" type="text" value="', $interesse_n, '" class="name"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este interesse em qualificação?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado algum interesse em qualificação
							} else echo '<p class="but">Nenhum interesse em qualificação a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar as profissões
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM profissao ORDER BY nome;")){
							// Ao selecionar pelo menos uma profissão
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.interesse.em.qualificacao.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'<select name="interesse">',
											'<option value="0">Selecione profissão</option>'
								;

								// Para cada possível profissão existente cadastrada
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar o interesse em qualificação?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado profissões
							} else echo '<p class="but">Nenhuma profissão a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Interesse em trabalho</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 79, $id)){
						// Tenta selecionar os interesses em trabalho da pessoa em questão
						if($db_query_2 = mysqli_query($db_link, "SELECT prof.id, prof.nome FROM pessoa_fisica_e_interesse_em_trabalho pfit LEFT JOIN profissao prof ON prof.id = pfit.interesse WHERE pfit.pessoa_fisica = $id;")){
							// Se selecionou pelo menos um interesse em trabalho
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$interesse   = (int) $db_result_2[0];
									$interesse_n = htmlspecialchars($db_result_2[1]);

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.interesse.em.trabalho.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="interesse" value="', $interesse, '"/>',
												'<input readonly="readonly" type="text" value="', $interesse_n, '" class="name"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este interesse em trabalho?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado algum interesse em trabalho
							} else echo '<p class="but">Nenhum interesse em trabalho a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar as profissões
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM profissao ORDER BY nome;")){
							// Ao selecionar pelo menos uma profissão
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.interesse.em.trabalho.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'<select name="interesse">',
											'<option value="0">Selecione profissão</option>'
								;

								// Para cada possível profissão existente cadastrada
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar o interesse em trabalho?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado profissões
							} else echo '<p class="but">Nenhuma profissão a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Barreiras no trabalho</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 79, $id)){
						// Tenta selecionar as barreiras no trabalho da pessoa em questão
						if($db_query_2 = mysqli_query($db_link, "SELECT bar.id, bar.nome FROM pessoa_fisica_e_barreira_no_trabalho pfbt LEFT JOIN barreira bar ON bar.id = pfbt.barreira_no_trabalho WHERE pfbt.pessoa_fisica = $id;")){
							// Se selecionou pelo menos uma barreira
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$barreira   = (int) $db_result_2[0];
									$barreira_n = htmlspecialchars($db_result_2[1]);

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.barreira.no.trabalho.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="barreira" value="', $barreira, '"/>',
												'<input readonly="readonly" type="text" value="', $barreira_n, '" class="name"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir esta barreira no trabalho?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado alguma barreira
							} else echo '<p class="but">Nenhuma barreira a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar as barreiras
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM barreira ORDER BY nome;")){
							// Ao selecionar pelo menos uma barreira
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.barreira.no.trabalho.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'<select name="barreira">',
											'<option value="0">Selecione barreira</option>'
								;

								// Para cada possível barreira existente cadastrado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar a barreira?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado barreiras
							} else echo '<p class="but">Nenhuma barreira a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
						'</div>', $EOL,
						'<div id="tab-vin">', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Vínculos pessoais (sujeito)</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 81, $id)){
						// Tenta selecionar os vínculos da pessoa em questão
						if($db_query_2 = mysqli_query($db_link, "SELECT vp.id, vp.nome, ent.id, ent.nome FROM pessoa_fisica_e_vinculo_pessoal pfvp LEFT JOIN vinculo_pessoal vp ON vp.id = pfvp.eh LEFT JOIN entidade ent ON ent.id = pfvp.de WHERE pfvp.pessoa_fisica = $id;")){
							// Se selecionou pelo menos um vínculo
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$eh   = (int) $db_result_2[0];
									$eh_n = htmlspecialchars($db_result_2[1]);
									$de        = (int) $db_result_2[2];
									$de_n      = htmlspecialchars($db_result_2[3]);

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.vinculo.pessoal.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="id" value="', $id, '"/>',
												'<input type="hidden" name="eh" value="', $eh, '"/>',
												'<input type="hidden" name="de" value="', $de, '"/>',
												'Esta pessoa é <input readonly="readonly" type="text" value="', $eh_n, '"/> ',
												'de <input readonly="readonly" type="text" value="', $de_n, '" class="name"/> ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este vínculo?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado algum vínculo
							} else echo '<p class="but">Nenhum vínculo a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar vínculos pessoais
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM vinculo_pessoal ORDER BY nome;")){
							// Ao selecionar pelo menos um vínculo pessoal
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.vinculo.pessoal.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="id" value="', $id, '"/>', $EOL,
										'Esta pessoa é <select name="eh">',
											'<option value="0">Selecione vínculo</option>'
								;

								// Para cada possível vínculo existente cadastrado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										'de <input type="number" name="de" id="de" value="0" min="0"/>', $EOL,
										'<input type="text" id="de-nome" value="" class="name"/>', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar o vínculo?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado vínculos
							} else echo '<p class="but">Nenhum vínculo a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Vínculos pessoais (objeto)</h1>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 81, $id)){
						// Tenta selecionar os vínculos da pessoa em questão
						if($db_query_2 = mysqli_query($db_link, "SELECT ent.id, ent.nome, vp.id, vp.nome FROM pessoa_fisica_e_vinculo_pessoal pfvp LEFT JOIN entidade ent ON ent.id = pfvp.pessoa_fisica LEFT JOIN vinculo_pessoal vp ON vp.id = pfvp.eh WHERE pfvp.de = $id;")){
							// Se selecionou pelo menos um vínculo
							if(mysqli_num_rows($db_query_2)){
								// Inicia as linhas
								echo '<div class="but">', $EOL;

								// Para cada selecionado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata as entradas
									$pessoa_fisica   = (int) $db_result_2[0];
									$pessoa_fisica_n = htmlspecialchars($db_result_2[1]);
									$eh              = (int) $db_result_2[2];
									$eh_n            = htmlspecialchars($db_result_2[3]);

									// Imprime em campos num formulário para exclusão
									echo
										'<form action="excluir.pessoa.fisica.e.vinculo.pessoal.php" method="post">', $EOL,
											'<p class="lab">',
												'<input type="hidden" name="go-de" value="1"/>', $EOL,
												'<input type="hidden" name="id" value="', $pessoa_fisica, '"/>',
												'<input type="hidden" name="eh" value="', $eh, '"/>',
												'<input type="hidden" name="de" value="', $id, '"/>',
												'<input readonly="readonly" type="text" value="', $pessoa_fisica_n, '" class="name"/> ',
												'é <input readonly="readonly" type="text" value="', $eh_n, '"/> desta pessoa ',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este vínculo?\');"/>',
											'</p>', $EOL,
										'</form>', $EOL
									;
								}

								// Finaliza linhas
								echo '</div>', $EOL;
							// Caso não tenha selecionado algum vínculo
							} else echo '<p class="but">Nenhum vínculo a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}

						// Tenta selecionar vínculos pessoais
						if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM vinculo_pessoal ORDER BY nome;")){
							// Ao selecionar pelo menos um vínculo pessoal
							if(mysqli_num_rows($db_query_2)){
								// Gera formulário para inserção
								echo
									'<form action="adicionar.pessoa.fisica.e.vinculo.pessoal.php" method="post" class="new">', $EOL,
										'<input type="hidden" name="go-de" value="1"/>', $EOL,
										'<input type="hidden" name="de" value="', $id, '"/>', $EOL,
										'<input type="number" name="id" id="pessoa" value="0" min="0"/>', $EOL,
										'<input type="text" id="pessoa-nome" value="" class="name"/> ', $EOL,
										'é <select name="eh">',
											'<option value="0">Selecione vínculo</option>'
								;

								// Para cada possível vínculo existente cadastrado
								while($db_result_2 = mysqli_fetch_row($db_query_2)){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>';
								}

								// Limpa consulta no servidor
								mysqli_free_result($db_query_2);

								echo
										'</select>', $EOL,
										' desta pessoa', $EOL,
										'<input type="submit" value="Adicionar" onclick="return confirm(\'Tem certeza que deseja adicionar o vínculo?\');"/>', $EOL,
									'</form>', $EOL
								;
							// Caso não tenha selecionado vínculos
							} else echo '<p class="but">Nenhum vínculo a listar</p>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<p class="error but">Erro na consulta com a Base de Dados: ', $error, '</p>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<p class="error but">Você não tem permissão para visualizar estes dados.</p>', $EOL;

					echo
							'</section>', $EOL,
						'</div>', $EOL,
						'<div id="tab-his">', $EOL,
							'<section class="cad">', $EOL,
								'<h1>Histórico</h1>', $EOL,
								'<form action="adicionar.historico.php" method="post" enctype="multipart/form-data" class="new">', $EOL,
									'<input type="hidden" name="sobre" value="', $id, '" />', $EOL,
									'<p class="lab"><label>Título: <input type="text" name="titulo" style="width:885px"/></label></p>', $EOL,
									'<p class="lab"><label for="descricao">Descrição: </label></p>', $EOL,
									'<p><textarea id="descricao" name="descricao" style="width:918px;height:150px"></textarea></p>', $EOL,
									'<input type="hidden" name="MAX_FILE_SIZE" value="', $FMS, '" />', $EOL,
									'<p class="lab but"><label>Anexo: <input id="arquivo" name="arquivo" type="file"/></label> Máximo: ', number_format($FMS,0,',','.'), ' bytes</p>', $EOL,
									'<p class="but"><input type="submit" value="Adicionar"/></p>', $EOL,
								'</form>', $EOL,
							'</section>', $EOL
					;

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 83, $id)){
						// Tenta selecionar históricos
						if($db_query_2 = mysqli_query($db_link, "SELECT ent1.id, ent1.nome, DATE_FORMAT(his.quando, '%Y-%m-%d %H:%i:%s'), DATE_FORMAT(his.quando, '%d/%m/%Y %H:%i:%s'), his.titulo, his.descricao, his.arquivo FROM historico his LEFT JOIN entidade ent1 ON ent1.id = his.entidade LEFT JOIN entidade ent2 ON ent2.id = his.sobre WHERE ent2.id = $id ORDER BY his.quando DESC;")){
							// Ao selecionar pelo menos um histórico
							if(mysqli_num_rows($db_query_2)){
								// Para cada possível histórico existente cadastrado
								for($i = 1;$db_result_2 = mysqli_fetch_row($db_query_2);$i++){
									// Trata entrada
									$db_result_2[0] = (int) $db_result_2[0];
									$db_result_2[1] = htmlspecialchars($db_result_2[1]);
									$db_result_2[2] = htmlspecialchars($db_result_2[2]);
									$db_result_2[3] = htmlspecialchars($db_result_2[3]);
									$db_result_2[4] = htmlspecialchars($db_result_2[4]);
									$db_result_2[5] = htmlspecialchars($db_result_2[5]);
									if($db_result_2[6] !== NULL) $db_result_2[6] = htmlspecialchars($db_result_2[6]);

									// Imprime os dados pertinentes
									echo
										'<section>', $EOL,
											'<p><b>Por:</b> ', $db_result_2[1], '</p>', $EOL,
											'<p class="but"><b>Quando:</b> ', $db_result_2[3], '</p>', $EOL,
											'<p class="but"><b>Título:</b> ', $db_result_2[4], '</p>', $EOL,
											// Link para mostrar a descrição
											'<p class="but">',
												'<a href="javascript:desc(', $i, ')"><b>Descrição <span id="hist-', $i, '-a">▼</span><span id="hist-', $i, '-b">▲</span></b></a>',
											'</p>', $EOL,
											// Esconde descrição inicialmente
											'<script>',
												'$(function(){',
													'$("#hist-', $i, '").hide();',
													'$("#hist-', $i, '-b").hide();',
												'});',
											'</script>', $EOL,
											'<div id="hist-', $i, '">',
												'<p class="but" style="text-align:justify">'
									;

									// Parágrafos a exibir
									$pars = str_replace("\r\n",'</p><p class="but" style="text-align:justify">',$db_result_2[5]);

									echo $pars, '</p></div>', $EOL;

									// Se tem anexo, exibe link
									if($db_result_2[6])
										echo '<p class="but"><b><a href="', $FDIR, '/', $db_result_2[6], '">Anexo</a></b></p>', $EOL;
									else
										echo '<p class="but"><b>Sem anexo</b></p>', $EOL;

									// Formulário para exclusão
									echo
											'<form method="post" action="excluir.historico.php" class="but">',
												'<input type="hidden" name="entidade" value="', $db_result_2[0], '"/>',
												'<input type="hidden" name="sobre" value="', $id, '"/>',
												'<input type="hidden" name="quando" value="', $db_result_2[2], '"/>',
												'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este histórico?\');"/>',
											'</form>', $EOL,
										'</section>', $EOL
									;
								}
							// Caso não tenha selecionado históricos
							} else echo '<section><p>Nenhum histórico a listar</p></section>', $EOL;
						// Caso tenha ocorrido problema com a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							echo '<section><p class="error">Erro na consulta com a Base de Dados: ', $error, '</p></section>', $EOL;
						}
					// Caso não possua permissão
					} else echo '<section><p class="error">Você não tem permissão para visualizar estes dados.</p></section>', $EOL;

					echo
						'</div>', $EOL
					;
				}

			// Caso não tenha conseguido selecionar a entidade
			} else echo '<section><p class="error">Entidade não encontrada.</p></section>', $EOL;
		// Caso tenha ocorrido algo com a consulta
		} else echo '<section><p class="error">Erro na consulta com a Base de Dados.</p></section>', $EOL;

		// Fecha a conexão com o servidor da Base de Dados
		mysqli_close($db_link);
	// Caso não tenha conseguido conectar ao servidor de Base de Dados
	} else require_once('db.link.err.echo.section.php');

	// Fecha body e html
	require_once('inc.bot.php');
// Se não logado
} else require_once('login.err.php');
