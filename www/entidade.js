$(function(){
	// Controle das sessões
	show_ge   = function(){$('#tab-ge').show();$('#tab-sau').hide();$('#tab-ed').hide();$('#tab-assi').hide();$('#tab-tra').hide();$('#tab-vin').hide();$('#tab-his').hide();$('#tab-hab').hide();$('#tab-mob').hide();}
	show_sau  = function(){$('#tab-ge').hide();$('#tab-sau').show();$('#tab-ed').hide();$('#tab-assi').hide();$('#tab-tra').hide();$('#tab-vin').hide();$('#tab-his').hide();$('#tab-hab').hide();$('#tab-mob').hide();}
	show_ed   = function(){$('#tab-ge').hide();$('#tab-sau').hide();$('#tab-ed').show();$('#tab-assi').hide();$('#tab-tra').hide();$('#tab-vin').hide();$('#tab-his').hide();$('#tab-hab').hide();$('#tab-mob').hide();}
	show_assi = function(){$('#tab-ge').hide();$('#tab-sau').hide();$('#tab-ed').hide();$('#tab-assi').show();$('#tab-tra').hide();$('#tab-vin').hide();$('#tab-his').hide();$('#tab-hab').hide();$('#tab-mob').hide();}
	show_tra  = function(){$('#tab-ge').hide();$('#tab-sau').hide();$('#tab-ed').hide();$('#tab-assi').hide();$('#tab-tra').show();$('#tab-vin').hide();$('#tab-his').hide();$('#tab-hab').hide();$('#tab-mob').hide();}
	show_vin  = function(){$('#tab-ge').hide();$('#tab-sau').hide();$('#tab-ed').hide();$('#tab-assi').hide();$('#tab-tra').hide();$('#tab-vin').show();$('#tab-his').hide();$('#tab-hab').hide();$('#tab-mob').hide();}
	show_his  = function(){$('#tab-ge').hide();$('#tab-sau').hide();$('#tab-ed').hide();$('#tab-assi').hide();$('#tab-tra').hide();$('#tab-vin').hide();$('#tab-his').show();$('#tab-hab').hide();$('#tab-mob').hide();}
	show_hab  = function(){$('#tab-ge').hide();$('#tab-sau').hide();$('#tab-ed').hide();$('#tab-assi').hide();$('#tab-tra').hide();$('#tab-vin').hide();$('#tab-his').hide();$('#tab-hab').show();$('#tab-mob').hide();}
	show_mob  = function(){$('#tab-ge').hide();$('#tab-sau').hide();$('#tab-ed').hide();$('#tab-assi').hide();$('#tab-tra').hide();$('#tab-vin').hide();$('#tab-his').hide();$('#tab-hab').hide();$('#tab-mob').show();}

	// Mostrar e ocultar descrição em histórico
	desc = function(id){
		$('#hist-'+id).toggle(250);
		$('#hist-'+id+'-a').toggle();
		$('#hist-'+id+'-b').toggle();
	}

	// Validação do CPF
	validacpf = function(){
		if(!cpf($('#cpf').val())) alert('CPF inválido');
		return cpf($('#cpf').val());
	}

	// Ao alterar o ID do endereço
	$('#endereco').change(function(){
		// Se for um endereço válido
		if($('#endereco').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.endereco.php?id='+$('#endereco').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#endereco-nome').val(data);
			});
		// Caso não seja válido, colocar o endereço vazio
		} else $('#endereco-nome').val('Nenhum');
	});

	// Ao alterar o ID da naturalidade
	$('#naturalidade').change(function(){
		// Se for uma cidade válida
		if($('#naturalidade').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.cidade.php?id='+$('#naturalidade').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#naturalidade-nome').val(data);
			});
		// Caso não seja válida, colocar a cidade vazia
		} else $('#naturalidade-nome').val('Nenhuma');
	});

	// Ao alterar o ID da escola
	$('#escola').change(function(){
		// Se for uma entidade válida
		if($('#escola').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.escola.php?id='+$('#escola').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#escola-nome').val(data);
			});
		// Caso não seja válida, colocar a escola vazia
		} else $('#escola-nome').val('Nenhuma');
	});

	// Ao alterar o ID de entidade em vínculo
	$('#de').change(function(){
		// Se for uma entidade válida
		if($('#de').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.pessoa.fisica.php?id='+$('#de').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#de-nome').val(data);
			});
		// Caso não seja válida, colocar a escola vazia
		} else $('#de-nome').val('Nenhuma');
	});

	// Ao alterar o ID de entidade em vínculo
	$('#pessoa').change(function(){
		// Se for uma entidade válida
		if($('#pessoa').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.pessoa.fisica.php?id='+$('#pessoa').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#pessoa-nome').val(data);
			});
		// Caso não seja válida, colocar a escola vazia
		} else $('#pessoa-nome').val('Nenhuma');
	});

	// Ao alterar o ID de entidade no trabalho
	$('#trabalha-para').change(function(){
		// Se for uma entidade válida
		if($('#trabalha-para').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#trabalha-para').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#trabalha-para-nome').val(data);
			});
		// Caso não seja válida, colocar a escola vazia
		} else $('#trabalha-para-nome').val('Nenhum');
	});
});
