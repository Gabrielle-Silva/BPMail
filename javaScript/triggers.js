window.onload = () => {
	funcionariosJs.readEmployees();
};

/**
 * call triggers when the EmployeesList are load
 */
function triggersEmployeesList() {
	/**
	 * On click #btnProximo
	 * Creates an array with all input checkbox Id's containing property 'checked' inside the table
	 * Hide the select section of employees and shows the emails settings
	 * Calls the function emails.loadEmails() passing the created array as param
	 */
	$(`#btnProximo`).on('click', () => {
		var arr = [];
		$.each($("input[name='select']:checked"), function () {
			arr.push($(this).val());
		});
		$('#listaFunc').hide();
		$('#listaEmails').show();
		emails.loadEmails(arr);
	});

	/**
	 * @param event - on click input type checkbox #selectall
	 * Set the same property (checked or not) of element target for every element that has the name 'select'
	 */
	$('#selectall').on('click', (e) => {
		checkboxes = $("[name='select']");
		for (var i = 0, n = checkboxes.length; i < n; i++) {
			checkboxes[i].checked = e.target.checked;
		}
	});
	/**
	 * @param event - click input type checkbox #selecPJ
	 * Set the same property (checked or not) of element target for each element that contains the class 'CLT'
	 */
	$('#selecPJ').on('click', (e) => {
		checkboxes = $('.PJ');
		for (var i = 0, n = checkboxes.length; i < n; i++) {
			checkboxes[i].checked = e.target.checked;
		}
	});
	/**
	 * @param event - click input type checkbox #selectCLT
	 * Set the same property (checked or not) of element target for each element that contains the class 'PJ'
	 */
	$('#selectCLT').on('click', (e) => {
		checkboxes = $('.CLT');
		for (var i = 0, n = checkboxes.length; i < n; i++) {
			checkboxes[i].checked = e.target.checked;
		}
	});
	/**
	 * @param event - click input type checkbox #selectEstagio
	 * Set the same property (checked or not) of element target for each element that contains the class 'Estagio'
	 */
	$('#selectEstagio').on('click', (e) => {
		checkboxes = $('.Estagio');
		for (var i = 0, n = checkboxes.length; i < n; i++) {
			checkboxes[i].checked = e.target.checked;
		}
	});

	/**
	 * On click #btn-inserirCampos
	 * Creates a new line at the top of the table to enter data about a new employee
	 */
	$(`#btn-inserirCampos`).on('click', () => {
		if ($('#newNome').length == 0) {
			const str = `<td></td>
	    	<td><select name="newContrato" id="newContrato" ><option value="">Contrato</option><option value="PJ">PJ</option><option value="Estagio">Estagio</option><option value="CLT">CLT</option></select></td>
	    	<td><input name="newNome" id="newNome" ></td>
		    <td><input name="newEmail" id="newEmail" type="email" ></td>
		    <td><button id="btnInsert" type="button" class="btnLow" title="SALVAR"><i class="fa-solid fa-floppy-disk"></i></button></td>
		    <td><button id="btnCancel" type="button" class="btnLow" title="CANCELAR"><i class="fa-solid fa-xmark"></i></button></td>`;
			const firstTr = $('tr')[1];
			const tr = document.createElement('tr');
			$(tr).html(str);
			firstTr.before(tr);

			$(`#btnCancel`).on('click', () => {
				funcionariosJs.readEmployees();
			});
			$(`#btnInsert`).on('click', () => {
				funcionariosJs.insertEmployee();
			});
		}
	});

	/**
	 * On click #btnEditarCampos
	 * Changes the clicked row employee, allowing to update
	 */
	$("[id='btnEditarCampos']").each(function (btn) {
		$(this).on('click', function () {
			const id = $(this).attr('data-id');
			const nome = $('#valuesFunc_' + id).attr('data-nome');
			const contrato = $('#valuesFunc_' + id).attr('data-contrato');
			const email = $('#valuesFunc_' + id).attr('data-email');
			const SelectPJ = contrato == 'PJ' ? 'selected' : '';
			const SelectCLT = contrato == 'CLT' ? 'selected' : '';
			const SelectEst = contrato == 'Estagio' ? 'selected' : '';
			$(
				'#funcionario' + id
			).html(`<td></td><td><select name="contrato" id="contrato${id}" ><option value="">Contrato</option><option value="PJ" ${SelectPJ} >PJ</option><option value="Estagio" ${SelectEst} >Estagio</option><option value="CLT" ${SelectCLT} >CLT</option></select></td>		
		        <td><input name="nome" id="nome${id}" value="${nome}" ></td>
		        <td><input name="email" id="email${id}" value="${email}" type="email" ></td>
	    	    <td><button id="btnUpdate" data-id="${id}" type="button" class="btnLow" title="SALVAR"><i class="fa-solid fa-floppy-disk"></i></button></td>
	        	<td><button id="btnCancel"  type="button" class="btnLow" title="CANCELAR"><i class="fa-solid fa-xmark"></i></button></td>`);

			$(`#btnUpdate`).on('click', () => {
				funcionariosJs.updateEmployee(id);
			});
			$(`#btnCancel`).on('click', () => {
				funcionariosJs.readEmployees();
			});
		});
	});

	/**
	 * On click #btnDelete
	 * Delete te clicked employee
	 */
	$("[id='btnDelete']").each(function (btn) {
		$(this).on('click', function () {
			const id = $(this).attr('data-id');
			funcionariosJs.deleteEmployee(id);
		});
	});
}

/**
 * call triggers when the EmailsList are load
 */
function triggersEmailsList() {
	/**
	 * On click #submitPrevia
	 * Show a preview with the same data that will be send
	 */
	$(`#submitPrevia`).on('click', (e) => {
		$("[id='emailsData']").each(function () {
			const id = $(this).attr('data-id');
			const nome = $(this).attr('data-nome');
			const fileList = $(this).attr('data-listaArquivos');
			emails.previa(id, fileList, nome);
		});
		$('#listaEmails').hide();
		$('#previa').show();
		triggersPrevia();
	});

	/**
	 * On click #btnBackEmp
	 * Empty and hide the section emails and shows the previous employees list section
	 */
	$('#btnBackEmp').on('click', () => {
		$('#listaFunc').show();
		$('#listaEmails').html('');
		$('#listaEmails').hide();
		triggersEmployeesList();
	});

	/**
	 * On click #btn-reload
	 * Reload the settings emails page
	 */
	$('#btn-reload').on('click', () => {
		var arr = [];
		$.each($("input[name='select']:checked"), function () {
			arr.push($(this).val());
		});
		emails.loadEmails(arr);
	});

	/**
	 * On click #btnSwitch
	 * Toggle class on the #saudacao input changing the order in the result
	 */
	$('#btnSwitch').on('click', () => {
		$('#saudacao').toggleClass('first');
		viewSaudacao();
	});

	/**
	 * On change #saudacao call function viewSaudacao()
	 */
	$('#saudacao').on('change', viewSaudacao);

	/**
	 * On click #limpaTodos
	 * Set empty values for all the emails inputs on each employee
	 */
	$('#limpaTodos').on('click', () => {
		$('[id="mensagem"]').val('');
	});

	/**
	 * On click #aplicaTodos
	 * Set the values for every employee email with the value #resultSaudacao(replacing "**Nome**" by the respective employee), input #mansagemGeral and #assuntoGeral
	 */
	$('#aplicaTodos').on('click', () => {
		$('[id="FormEmail"]').each(function () {
			$(this)
				.children('#mensagem')
				.val(
					$('#saudacaoResult')
						.val()
						.replace(
							'**Nome**',
							$(this).children('#Nome').val().split(' ')[0]
						) +
						'\n' +
						$('#mensagemGeral').val()
				);
			$(this).children('#assunto').val($('#assuntoGeral').val());
		});
	});

	/**
	 * On click #btnValidaTodos
	 * Call a function that shows the validation if each file in folder contains the name and last name inside the content
	 */
	$('#btnValidaTodos').on('click', () => {
		$('.loader').addClass('darkloader');
		$('#spinner').show();
		var i = 0;
		var totalItems = $('[id="ArquivoPdfPasta"]').length;
		$('[id="ArquivoPdfPasta"]').each(function (btn) {
			const id = $(this).attr('data-id');
			const firstName = $(this).attr('data-nome');
			const lastName = $(this).attr('data-sobrenome');
			const FileName = $(this).attr('data-nomeArquivo');
			chamaValidar(FileName, firstName, lastName, id);
			if (i === totalItems - 1) {
				$('#spinner').hide();
				$('.loader').removeClass('darkloader');
			}
			i++;
		});
		$('[id="oblvalidar"]').show();
		$('.validarTodos').hide();
	});

	/**
	 * On click #arquivosGeral
	 * Call a function that controls the files upload
	 */
	$('#arquivosGeral').on('change', function () {
		btnAddAnexos(this, 'todos');
	});

	/**
	 * On click each #ArquivoPdfPasta
	 * Call a function that controls the files uploaded
	 */
	$("[id='arquivosLabel']").each(function (btn) {
		const id = $(this).attr('data-id');
		const nome = $(this).attr('data-nome');
		$(`#arquivos${id}`).on('change', (e) => {
			btnAddAnexos(e.target, `N${nome.replace(' ', '')}`);
		});
	});

	/**
	 * On click each #ArquivoPdfPasta
	 * Call a function to open a modal and show the file
	 */
	$("[id='ArquivoPdfPasta']").each(function (btn) {
		$(this).on('click', function () {
			const FileName = $(this).attr('data-nomeArquivo');
			viewPdf(`${FileName}<?= __EXT_FILE__ ?>`, '<?= __PATH_FILE__ ?>');
		});
	});
}

/**
 * call triggers when the previa (preview) are load
 */
function triggersPrevia() {
	/**
	 * On click #btnBackEmail
	 * Empty and hide the section preview and shows the previous email settings section
	 */
	$('#btnBackEmail').on('click', () => {
		$('#listaEmails').show();
		$('#previa')
			.html(`<button id="btnBackEmail" type="button" class="btnFixLeft" title="VOLTAR"><i class="fa-solid fa-chevron-left"></i> <i class="fa-solid fa-envelope"></i></button>
            <i class="fa-solid fa-eye icon-page"></i>
            <div class="titulo">
                <h2>PRÉVIA EMAILS</h2>
                <button id="submitEnviar" type="button" class="btnFix" title="ENVIAR"><i class="fa-solid fa-paper-plane"></i> <i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>`);
		$('#previa').hide();
	});

	/**
	 * On click #submitEnviar
	 * Call a function with the data and send all the emails
	 */
	$(`#submitEnviar`).on('click', (e) => {
		e.preventDefault();
		if (confirm('Deseja enviar os emails?')) {
			const doBefore = () => {
				$('#spinner').show();
				$('#body').hide();
				if ($('#spinner').is(':visible') && $('#body').is(':hidden')) {
					setTimeout(callSync, 1000);
				} else {
					setTimeout(doBefore, 500);
				}
			};

			const sendMail = (_callback) => {
				var totalItems = $('[id="emailsData"]').length;
				$("[id='emailsData']").each(function (i, e) {
					const id = $(this).attr('data-id');
					const nome = $(this).attr('data-nome');
					const fileList = $(this).attr('data-listaArquivos');
					//order sent: first and last
					if (i == 0) {
						emails.enviar(id, fileList, nome, true, false);
					} else if (i == totalItems - 1) {
						emails.enviar(id, fileList, nome, false, true);
					} else {
						emails.enviar(id, fileList, nome, false, false);
					}
					i++;
				});

				_callback();
			};

			const callSync = () => {
				sendMail(() => {
					$('#body').show();
					$('#spinner').hide();
					$('#previa').hide();
					$('#result').show();
				});
			};
			$('#submitEnviar').prop('disabled', true);
			setTimeout(() => {
				$('#submitEnviar').prop('disabled', false);
			}, 5000);

			doBefore();
		}
	});
}

//---------------- Other Functions called by the triggers------------------

/**
 * Set the input #saudacaoResult value with the #saudacao and #tempNome values. Order according the class that can be changed by method switchSaudacao
 */
function viewSaudacao() {
	let saudacao = $('#saudacao').val();
	let tempNome = $('#tempNome').val();
	if ($('#saudacao').hasClass('first')) {
		$('#saudacaoResult').val(saudacao + ' ' + tempNome);
	} else {
		$('#saudacaoResult').val(tempNome + ' ' + saudacao);
	}
}

var arrFiles = {};

/**
 * @param element this Input File
 * @param string identificador - class to differentiate each file input
 *
 * save files data into external array (arrFiles) enabling add or delete, then update items input
 */
function btnAddAnexos(thisInputFile, identificador) {
	//cria novo dataTransfer para array fora da função que irá armazenar os dados
	if (!arrFiles[identificador]) {
		Object.assign(arrFiles, {
			[identificador]: new DataTransfer(),
		});
	}

	for (var i = 0; i < thisInputFile.files.length; i++) {
		let fileBloc = $('<span/>', {
				class: `file-block ${identificador}`,
			}),
			fileName = $('<span/>', {
				class: `name ${identificador}`,
				text: thisInputFile.files.item(i).name,
			});
		fileBloc
			.append('<span class="file-delete"><span>+</span></span>')
			.append(fileName);
		$(`#filesList > #files-names.${identificador}`).append(fileBloc);
	}

	for (let file of thisInputFile.files) {
		arrFiles[identificador].items.add(file);
	}

	thisInputFile.files = arrFiles[identificador].files;

	$('span.file-delete').click(function () {
		let name = $(this).next('span.name').text();
		$(this).parent().remove();
		for (let i = 0; i < arrFiles[identificador].items.length; i++) {
			if (name === arrFiles[identificador].items[i].getAsFile().name) {
				arrFiles[identificador].items.remove(i);
				continue;
			}
		}

		thisInputFile.files = arrFiles[identificador].files;
	});
}
