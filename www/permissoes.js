$(function(){
	// Ao alterar o ID
	$('#genero-entidade-id').change(function(){
		// Se for um ID válido
		if($('#genero-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#genero-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#genero-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#genero-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#estado-civil-entidade-id').change(function(){
		// Se for um ID válido
		if($('#estado-civil-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#estado-civil-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#estado-civil-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#estado-civil-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#diagnostico-entidade-id').change(function(){
		// Se for um ID válido
		if($('#diagnostico-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#diagnostico-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#diagnostico-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#diagnostico-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#status-de-diagnostico-entidade-id').change(function(){
		// Se for um ID válido
		if($('#status-de-diagnostico-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#status-de-diagnostico-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#status-de-diagnostico-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#status-de-diagnostico-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#escolaridade-entidade-id').change(function(){
		// Se for um ID válido
		if($('#escolaridade-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#escolaridade-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#escolaridade-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#escolaridade-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#serie-escolar-entidade-id').change(function(){
		// Se for um ID válido
		if($('#serie-escolar-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#serie-escolar-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#serie-escolar-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#serie-escolar-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#turno-escolar-entidade-id').change(function(){
		// Se for um ID válido
		if($('#turno-escolar-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#turno-escolar-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#turno-escolar-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#turno-escolar-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#raca-entidade-id').change(function(){
		// Se for um ID válido
		if($('#raca-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#raca-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#raca-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#raca-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#beneficio-entidade-id').change(function(){
		// Se for um ID válido
		if($('#beneficio-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#beneficio-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#beneficio-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#beneficio-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#tecnologia-entidade-id').change(function(){
		// Se for um ID válido
		if($('#tecnologia-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#tecnologia-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#tecnologia-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#tecnologia-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#barreira-entidade-id').change(function(){
		// Se for um ID válido
		if($('#barreira-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#barreira-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#barreira-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#barreira-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#tipo-de-entidade-entidade-id').change(function(){
		// Se for um ID válido
		if($('#tipo-de-entidade-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#tipo-de-entidade-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#tipo-de-entidade-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#tipo-de-entidade-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#vinculo-pessoal-entidade-id').change(function(){
		// Se for um ID válido
		if($('#vinculo-pessoal-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#vinculo-pessoal-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#vinculo-pessoal-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#vinculo-pessoal-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#profissao-entidade-id').change(function(){
		// Se for um ID válido
		if($('#profissao-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#profissao-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#profissao-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#profissao-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#servico-de-saude-entidade-id').change(function(){
		// Se for um ID válido
		if($('#servico-de-saude-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#servico-de-saude-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#servico-de-saude-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#servico-de-saude-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#servico-de-educacao-entidade-id').change(function(){
		// Se for um ID válido
		if($('#servico-de-educacao-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#servico-de-educacao-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#servico-de-educacao-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#servico-de-educacao-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#servico-de-as-entidade-id').change(function(){
		// Se for um ID válido
		if($('#servico-de-as-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#servico-de-as-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#servico-de-as-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#servico-de-as-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#medicacao-entidade-id').change(function(){
		// Se for um ID válido
		if($('#medicacao-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#medicacao-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#medicacao-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#medicacao-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#servico-de-ddpd-entidade-id').change(function(){
		// Se for um ID válido
		if($('#servico-de-ddpd-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#servico-de-ddpd-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#servico-de-ddpd-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#servico-de-ddpd-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#servico-de-mob-entidade-id').change(function(){
		// Se for um ID válido
		if($('#servico-de-mob-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#servico-de-mob-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#servico-de-mob-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#servico-de-mob-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#tipo-de-logradouro-entidade-id').change(function(){
		// Se for um ID válido
		if($('#tipo-de-logradouro-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#tipo-de-logradouro-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#tipo-de-logradouro-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#tipo-de-logradouro-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#pais-entidade-id').change(function(){
		// Se for um ID válido
		if($('#pais-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#pais-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#pais-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#pais-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#uf-entidade-id').change(function(){
		// Se for um ID válido
		if($('#uf-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#uf-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#uf-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#uf-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#uf-obj-id').change(function(){
		// Se for um ID válido
		if($('#uf-obj-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.uf.php?id='+$('#uf-obj-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#uf-obj-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#uf-obj-nome').val('Qualquer');
	});

	// Ao alterar o ID
	$('#cidade-entidade-id').change(function(){
		// Se for um ID válido
		if($('#cidade-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#cidade-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#cidade-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#cidade-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#cidade-obj-id').change(function(){
		// Se for um ID válido
		if($('#cidade-obj-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.cidade.2.php?id='+$('#cidade-obj-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#cidade-obj-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#cidade-obj-nome').val('Qualquer');
	});

	// Ao alterar o ID
	$('#logradouro-entidade-id').change(function(){
		// Se for um ID válido
		if($('#logradouro-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#logradouro-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#logradouro-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#logradouro-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#logradouro-obj-id').change(function(){
		// Se for um ID válido
		if($('#logradouro-obj-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.logradouro.php?id='+$('#logradouro-obj-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#logradouro-obj-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#logradouro-obj-nome').val('Qualquer');
	});

	// Ao alterar o ID
	$('#bairro-entidade-id').change(function(){
		// Se for um ID válido
		if($('#bairro-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#bairro-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#bairro-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#bairro-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#bairro-obj-id').change(function(){
		// Se for um ID válido
		if($('#bairro-obj-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.bairro.php?id='+$('#bairro-obj-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#bairro-obj-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#bairro-obj-nome').val('Qualquer');
	});

	// Ao alterar o ID
	$('#entidade-entidade-id').change(function(){
		// Se for um ID válido
		if($('#entidade-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#entidade-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#entidade-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#entidade-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#entidade-obj-id').change(function(){
		// Se for um ID válido
		if($('#entidade-obj-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#entidade-obj-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#entidade-obj-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#entidade-obj-nome').val('Qualquer');
	});

	// Ao alterar o ID
	$('#endereco-entidade-id').change(function(){
		// Se for um ID válido
		if($('#endereco-entidade-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#endereco-entidade-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#endereco-entidade-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#endereco-entidade-nome').val('Qualquer um');
	});

	// Ao alterar o ID
	$('#endereco-obj-id').change(function(){
		// Se for um ID válido
		if($('#endereco-obj-id').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.endereco.php?id='+$('#endereco-obj-id').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#endereco-obj-nome').val(data);
			});
		// Caso não seja válido, colocar o nome adequado
		} else $('#endereco-obj-nome').val('Qualquer');
	});
});
