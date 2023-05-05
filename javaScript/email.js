var emails = {
	/**
	 * @param arr: id's
	 * Get data from DB of each informed id
	 * @returns php file 'emailsList.php'
	 */
	loadEmails: function (arr) {
		$('#spinner').show();
		$('#body').hide();
		$.ajax({
			url: '/src/controller/emailController.php?action=read',
			data: {
				arrFunc: arr.join(', '),
			},
		}).done(function (dados) {
			$('#body').show();
			$('#spinner').hide();
			$('#listaEmails').html(dados);
			triggersEmailsList();
		});
	},

	/**
	 * @param Object: strJson
	 * @param int: id
	 * @param int: currentPage
	 * @param int: totalPages
	 * Get data about file validate
	 * @returns php file 'validacao.php' to append in respective filename class
	 */
	validarPdf: function (strJson, id, doc, currentPage, totalPages) {
		$.ajax({
			url: '/src/controller/emailController.php',
			data: {
				objValidar: JSON.stringify(strJson),
				action: 'validate',
				currentPage: currentPage,
			},
		}).done(function (dados) {
			$(`.conteudopg.${doc.replace(/ /g, '')}`).append(dados);
			$(`.paginas.${doc.replace(/ /g, '')}`).html(
				`${totalPages}<span>Paginas</span>`
			);
		});
	},

	/**
	 * @param int: id
	 * @param array: arrArquivosPasta
	 * @param string: nome
	 * @returns php file 'previa.php' with a preview of each email to send
	 */
	previa: function (id, arrArquivosPasta, nome) {
		$.ajax({
			url: `/src/controller/emailController.php?action=preview`,
			data: funcFormDatation(id, arrArquivosPasta, nome),
			type: 'POST',
			cache: false,
			contentType: false,
			processData: false,
		}).done(function (dados) {
			$('#previa').append(dados);
		});
	},

	/**
	 * @param int: id
	 * @param array: arrArquivosPasta
	 * @param string: nome
	 * @returns php file 'result.php' with the sent emails status
	 */
	enviar: function (id, arrArquivosPasta, nome) {
		$.ajax({
			url: `/src/controller/emailController.php?action=sendEmail`,
			data: funcFormDatation(id, arrArquivosPasta, nome),
			type: 'POST',
			cache: false,
			contentType: false,
			processData: false,
			async: false,
		}).done(function (dados) {
			$('#resultPrint').append(dados);
		});
	},
};

/**
 * @param mixed id
 * @param mixed arrArquivosPasta
 * @param mixed nome
 *
 * @return [FormData]: Email informations to send
 */
function funcFormDatation(id, arrArquivosPasta, nome) {
	data = new FormData();
	for (let i = 0; i < $(`#arquivosGeral`)[0].files.length; i++) {
		data.append(`arquivosGeral_${i}`, $(`#arquivosGeral`)[0].files[i]);
	}
	for (let i = 0; i < $(`#arquivos${id}`)[0].files.length; i++) {
		data.append(
			`arquivos${nome.replace(' ', '-')}_${i}`,
			$(`#arquivos${id}`)[0].files[i]
		);
	}
	data.append(`Nome`, $(`#Nome.${id}`).val());
	data.append(`Email`, $(`#Email.${id}`).val());
	data.append(`assunto`, $(`#assunto.${id}`).val());
	data.append(
		`mensagem`,
		'<p>' +
			$(`#mensagem.${id}`)
				.val()
				.replace(/\r\n|\r|\n/g, '</p><p>') +
			'</p>'
	);
	data.append(`copias`, $('#copias').val());
	data.append(`arquivosPasta`, arrArquivosPasta);

	return data;
}
