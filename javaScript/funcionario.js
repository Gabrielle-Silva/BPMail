var funcionariosJs = {
	/**
	 * @returns php file 'funcionariosList.php' with all data from DB
	 */
	readEmployees: function () {
		$.ajax({
			url: '/src/controller/funcionarioController.php?action=read',
		}).done(function (dados) {
			$('#listaFunc').html(dados);
			triggersEmployeesList();
		});
	},

	/**
	 * @param int: id
	 * Delete row on DB with informed id
	 */
	deleteEmployee: function (id) {
		if (confirm('Deseja excluir o funcionário?')) {
			$.ajax({
				url: '/src/controller/funcionarioController.php?action=delete',
				data: {
					id: id,
				},
			}).done(function (dados) {
				funcionariosJs.readEmployees();
			});
		}
	},

	/**
	 * Insert new values on DB
	 * @returns updated php file 'funcionariosList.php'
	 *
	 */
	insertEmployee: function () {
		$.ajax({
			url: '/src/controller/funcionarioController.php?action=insert',
			data: {
				Contrato: document.getElementById('newContrato').value,
				Nome: document.getElementById('newNome').value,
				Email: document.getElementById('newEmail').value,
			},
		}).done(function (dados) {
			funcionariosJs.readEmployees();
		});
	},

	/**
	 * @param int: id
	 * Update row on DB with informed id
	 * @returns updated php file 'funcionariosList.php'
	 */
	updateEmployee: function (id) {
		if (confirm('Deseja editar o funcionário?')) {
			$.ajax({
				url: '/src/controller/funcionarioController.php?action=edit',

				data: {
					id: id,
					Contrato: document.getElementById('contrato' + id).value,
					Nome: document.getElementById('nome' + id).value,
					Email: document.getElementById('email' + id).value,
				},
			}).done(function (dados) {
				funcionariosJs.readEmployees();
			});
		}
	},
};
