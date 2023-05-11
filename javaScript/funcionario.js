var funcionariosJs = {
	/**
	 * @returns php file 'funcionariosList.php' with all data from DB
	 */
	readEmployees: () => {
		$.ajax({
			url: '/src/controller/funcionarioController.php?action=read',
		}).done((dados) => {
			$('#listaFunc').html(dados);
			triggersEmployeesList();
		});
	},

	/**
	 * @param int: id
	 * Delete row on DB with informed id
	 */
	deleteEmployee: (id) => {
		if (confirm('Deseja excluir o funcionário?')) {
			$.ajax({
				url: '/src/controller/funcionarioController.php?',
				data: {
					id: id,
					action: 'delete',
				},
			}).done((dados) => {
				let el = $(`${dados}`);
				$('#containerAlertStatus').append(el);
				setTimeout(() => {
					el.remove();
				}, 5000);
				funcionariosJs.readEmployees();
			});
		}
	},

	/**
	 * Insert new values on DB
	 * @returns updated php file 'funcionariosList.php'
	 *
	 */
	insertEmployee: () => {
		$.ajax({
			url: '/src/controller/funcionarioController.php?',
			data: {
				Contrato: document.getElementById('newContrato').value,
				Nome: document.getElementById('newNome').value,
				Email: document.getElementById('newEmail').value,
				action: 'insert',
			},
		}).done((dados) => {
			let el = $(`${dados}`);
			$('#containerAlertStatus').append(el);
			setTimeout(() => {
				el.remove();
			}, 5000);
			funcionariosJs.readEmployees();
		});
	},

	/**
	 * @param int: id
	 * Update row on DB with informed id
	 * @returns updated php file 'funcionariosList.php'
	 */
	updateEmployee: (id) => {
		if (confirm('Deseja editar o funcionário?')) {
			$.ajax({
				url: '/src/controller/funcionarioController.php?',

				data: {
					id: id,
					Contrato: document.getElementById('contrato' + id).value,
					Nome: document.getElementById('nome' + id).value,
					Email: document.getElementById('email' + id).value,
					action: 'edit',
				},
			}).done((dados) => {
				let el = $(`${dados}`);
				$('#containerAlertStatus').append(el);
				setTimeout(() => {
					el.remove();
				}, 5000);
				funcionariosJs.readEmployees();
			});
		}
	},
};
