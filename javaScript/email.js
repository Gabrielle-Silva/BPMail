var emails = {
	/**
	 * @param arr: id's
	 * Get data from DB of each informed id
	 * @returns php file 'emailsList.php'
	 */
	loadEmails: (arr) => {
		$('#spinner').show();
		$('#body').hide();
		$.ajax({
			url: '/src/controller/emailController.php?',
			data: {
				arrFunc: arr.join(', '),
				action: 'read',
			},
		}).done((dados) => {
			$('#body').show();
			$('#spinner').hide();
			$('#listaEmails').html(dados);
			triggersEmailsList();
		});
	},

	/**
	 * @param Object: strJson
	 * @param int: currentPage
	 * @param int: totalPages
	 * @param boolean: firstItem - First item call
	 * @param boolean: lastItem - Last item call
	 * Get data about file validate
	 * @returns php file 'validacao.php' to append in respective filename class
	 */
	validarPdf: (strJson, doc, currentPage, totalPages, lastItem) => {
		$.ajax({
			url: '/src/controller/emailController.php',
			data: {
				objValidar: JSON.stringify(strJson),
				action: 'validate',
				currentPage: currentPage,
				async: true,
			},
		}).done((dados) => {
			$(`.conteudopg.${doc.replace(/\.| /g, '')}`).append(dados);
			$(`.paginas.${doc.replace(/\.| /g, '')}`).html(
				`${totalPages}<span>Paginas</span>`
			);
			if (lastItem) {
				//loader hide when return the last item
				$('#spinner').hide();
				$('.loader').removeClass('darkloader');
			}
		});
	},

	/**
	 * @param int: id
	 * @param array: arrArquivosPasta
	 * @param string: nome
	 * @returns php file 'previa.php' with a preview of each email to send
	 */
	previa: (id, arrArquivosPasta, nome) => {
		$.ajax({
			url: `/src/controller/emailController.php?action=preview`,
			data: funcFormDatation(id, arrArquivosPasta, nome),
			type: 'POST',
			cache: false,
			contentType: false,
			processData: false,
		}).done((dados) => {
			$('#previa').append(dados);
		});
	},

	/**
	 * @param int: id
	 * @param array: arrArquivosPasta
	 * @param string: nome
	 * @param boolean: firstItem - First item call
	 * @param boolean: lastItem - Last item call
	 * @returns php file 'result.php' with the sent emails status
	 */
	enviar: (id, arrArquivosPasta, nome, firstItem, lastItem) => {
		$.ajax({
			url: `/src/controller/emailController.php?action=sendEmail`,
			data: funcFormDatation(id, arrArquivosPasta, nome),
			type: 'POST',
			cache: false,
			contentType: false,
			processData: false,
			async: true,
		}).done((dados) => {
			$('#resultPrint').append(dados);
			if (firstItem) {
				//loader show when start returning
				$('.loader').addClass('darkloader');
				$('#spinner').show();
			}
			if (lastItem) {
				//loader hide when return the last item
				$('#spinner').hide();
				$('.loader').removeClass('darkloader');
			}
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
