<script>
    window.onload = (event) => {
        funcionariosJs.readEmployees();
    }

    function triggersEmployeesList() {
        /**
         * On click #btnProximo
         * Creates an array with all Ids of the lines checked with the checkbox
         * Hide the section of select employees and shows the emails settings
         * Calls the function emails.loadEmails() passing the created array as param      
         */
        $(`#btnProximo`).on('click', function() {
            var arr = [];
            $.each($("input[name='select']:checked"), function() {
                arr.push($(this).val());
            });
            $('#listaFunc').hide();
            $('#listaEmails').show();
            emails.loadEmails(arr);


        });

        /**	      
         * @param event - on click input type checkbox #selectall    
         * Set the same value of element target (checked or not) for every element that has the name 'select'
         */
        $("#selectall").on('click', function(e) {
            checkboxes = $("[name='select']");
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = e.target.checked;
            }
        });
        /**	
         * @param event - click input type checkbox #selecPJ      
         * Set the same value of element target (checked or not) for each element that contains the class 'CLT'
         */
        $("#selecPJ").on('click', function(e) {
            checkboxes = $('.PJ');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = e.target.checked;
            }

        });
        /**	
         * @param event - click input type checkbox #selectCLT       
         * Set the same value of element target (checked or not) for each element that contains the class 'PJ'
         */
        $("#selectCLT").on('click', function(e) {
            checkboxes = $('.CLT');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = e.target.checked;
            }
        });
        /**	
         * @param event - click input type checkbox #selectEstagio       
         * Set the same value of element target (checked or not) for each element that contains the class 'Estagio'
         */
        $("#selectEstagio").on('click', function(e) {
            checkboxes = $('.Estagio');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = e.target.checked;
            }
        });


        /**	
         * On click #btn-inserirCampos
         * Create a new line at the top of the table to insert data of a new employee  
         */
        $(`#btn-inserirCampos`).on('click', function() {
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

                $(`#btnCancel`).on('click', function() {
                    funcionariosJs.readEmployees()
                });
                $(`#btnInsert`).on('click', function() {
                    funcionariosJs.insertEmployee()
                });
            }
        });

        /**
         * On click #btnEditarCampos
         * Changes the line of the clicked employee bringing the data and allowing to update    
         */
        $("[id='btnEditarCampos']").each(function(btn) {
            $(this).on("click", function() {
                const id = $(this).attr('data-id');
                const nome = $('#valuesFunc_' + id).attr('data-nome');
                const contrato = $('#valuesFunc_' + id).attr('data-contrato');
                const email = $('#valuesFunc_' + id).attr('data-email');
                const SelectPJ = contrato == 'PJ' ? 'selected' : '';
                const SelectCLT = contrato == 'CLT' ? 'selected' : '';
                const SelectEst = contrato == 'Estagio' ? 'selected' : '';
                $('#funcionario' + id).html(`<td></td><td><select name="contrato" id="contrato${id}" ><option value="">Contrato</option><option value="PJ" ${SelectPJ} >PJ</option><option value="Estagio" ${SelectEst} >Estagio</option><option value="CLT" ${SelectCLT} >CLT</option></select></td>		
		        <td><input name="nome" id="nome${id}" value="${nome}" ></td>
		        <td><input name="email" id="email${id}" value="${email}" type="email" ></td>
	    	    <td><button id="btnUpdate" data-id="${id}" type="button" class="btnLow" title="SALVAR"><i class="fa-solid fa-floppy-disk"></i></button></td>
	        	<td><button id="btnCancel"  type="button" class="btnLow" title="CANCELAR"><i class="fa-solid fa-xmark"></i></button></td>`);

                $(`#btnUpdate`).on('click', function() {
                    funcionariosJs.updateEmployee(id);
                });
                $(`#btnCancel`).on('click', function() {
                    funcionariosJs.readEmployees();
                });

            });
        });

        /**
         * On click #btnDelete
         * Delete te clicked employee
         */
        $("[id='btnDelete']").each(function(btn) {
            $(this).on("click", function() {
                const id = $(this).attr('data-id');
                funcionariosJs.deleteEmployee(id);
            });
        });

    }


    function triggersEmailsList() {
        /**
         * On click #submitPrevia
         * Show a preview with the same data to send
         */
        $(`#submitPrevia`).on('click', function(e) {
            $("[id='emailsData']").each(function() {
                const id = $(this).attr('data-id');
                const nome = $(this).attr('data-nome');
                const fileList = $(this).attr('data-listaArquivos');
                emails.previa(id, fileList, nome);
            });
            $('#listaEmails').hide();
            $('#previa').show();
        });

        triggerBtnEnviar();

        /**
         * On click #btnBackEmp
         * Empty and hide the section emails and shows the previous section od employees list
         */
        $("#btnBackEmp").on('click', function() {
            $('#listaFunc').show();
            $('#listaEmails').html("");
            $('#listaEmails').hide();
            triggersEmployeesList();
        });

        /**
         * On click #btn-reload
         * Reload the settings emails page     
         */
        $("#btn-reload").on('click', function() {
            var arr = [];
            $.each($("input[name='select']:checked"), function() {
                arr.push($(this).val());
            });
            emails.loadEmails(arr);
        });

        /**	
         * On click #btnSwitch
         * Toggle class on the #saudacao input changing the order in the result
         */
        $("#btnSwitch").on('click', function() {
            $('#saudacao').toggleClass("first");
            viewSaudacao();
        });

        /**
         * On change #saudacao call function viewSaudacao()
         */
        $("#saudacao").on('change', viewSaudacao);

        /**
         * On change #limpaTodos
         * Set empty values for all the emails inputs of every employee 
         */
        $("#limpaTodos").on('click', function() {
            $('[id="mensagem"]').val("")
        });

        /**
         * On change #aplicaTodos
         * Set the values for every employee email with the value of #resultSaudacao(replacing "**Nome**" by the respective employee), input #mansagemGeral and #assuntoGeral 
         */
        $("#aplicaTodos").on('click', function() {
            $('[id="FormEmail"]').each(function() {
                $(this).children('#mensagem').val($("#saudacaoResult").val().replace("**Nome**", $(this).children('#Nome').val().split(' ')[0]) + "\n" + $("#mensagemGeral").val());
                $(this).children('#assunto').val($("#assuntoGeral").val())

            })
        });

        /**
         * On click #btnValidaTodos
         * Call a function that show in every file on the folder and validate if the file contains the name and last name inside the pdf 
         */
        $("#btnValidaTodos").on('click', function() {
            $('[id="ArquivoPdfPasta"]').each(function(btn) {
                const id = $(this).attr('data-id');
                const firstName = $(this).attr('data-nome');
                const lastName = $(this).attr('data-sobrenome');
                const FileName = $(this).attr('data-nomeArquivo');
                chamaValidar(FileName, firstName, lastName, id);
            });
            $('[id="oblvalidar"]').show();
            $('.validarTodos').hide();
        });

        /**
         * On click #arquivosGeral
         * Call a function that controls the files uploaded
         */
        $("#arquivosGeral").on('change', function() {
            btnAddAnexos(this, 'todos');
        });

        /**
         * On click each #ArquivoPdfPasta
         * Call a function that controls the files uploaded
         */
        $("[id='arquivosLabel']").each(function(btn) {
            const id = $(this).attr('data-id');
            const nome = $(this).attr('data-nome');
            $(`#arquivos${id}`).on('change', function(e) {
                btnAddAnexos(e.target, `N${nome.replace(' ', '')}`);
            });
        });

        /**
         * On click each #ArquivoPdfPasta
         * Call a function to open a modal and show the file
         */
        $("[id='ArquivoPdfPasta']").each(function(btn) {
            $(this).on("click", function() {
                const FileName = $(this).attr('data-nomeArquivo');
                viewPdf(`${FileName}<?= __EXT_FILE__ ?>`, '<?= __PATH_FILE__ ?>');
            });
        });




    }

    function triggersPrevia() {
        /**
         * On click #btnBackEmail
         * Empty and hide the section preview of the emails and shows the previous section settings emails         
         */
        $("#btnBackEmail").on('click', function() {
            $('#listaEmails').show();
            $('#previa').html(`<button id="btnBackEmail" type="button" class="btnFixLeft" title="VOLTAR"><i class="fa-solid fa-chevron-left"></i> <i class="fa-solid fa-envelope"></i></button>
            <i class="fa-solid fa-eye icon-page"></i>
            <div class="titulo">
                <h2>PRÉVIA EMAILS</h2>
                <button id="submitEnviar" type="button" class="btnFix" title="ENVIAR"><i class="fa-solid fa-paper-plane"></i> <i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>`);
            $('#previa').hide();

        });
        triggerBtnEnviar();

    }



    //---------------- Other Functions called by the triggers------------------



    /**   
     * Set the input #saudacaoResult value with the #saudacao and #tempNome values. Order according with the class that can be changed by function switchSaudacao  
     */
    function viewSaudacao() {
        let saudacao = $('#saudacao').val();
        let tempNome = $('#tempNome').val();
        if ($('#saudacao').hasClass("first")) {
            $('#saudacaoResult').val(saudacao + " " + tempNome);
        } else {
            $('#saudacaoResult').val(tempNome + " " + saudacao);
        }
    }


    var arrFiles = {};
    //array com arquivos Geral de todos os funcionários
    /**          
     * @param this input file 
     * Botão de adicionar anexos com visualização de nome do arquivo e com opção de deletar
     */
    function btnAddAnexos(thisInputFile, identificador) {
        //cria novo dataTransfer para array fora da função que irá armazenar os dados
        if (!arrFiles[identificador]) {
            Object.assign(arrFiles, {
                [identificador]: new DataTransfer()
            });
        }

        for (var i = 0; i < thisInputFile.files.length; i++) {
            let fileBloc = $('<span/>', {
                    class: `file-block ${identificador}`
                }),
                fileName = $('<span/>', {
                    class: `name ${identificador}`,
                    text: thisInputFile.files.item(i).name
                });
            fileBloc.append('<span class="file-delete"><span>+</span></span>')
                .append(fileName);
            $(`#filesList > #files-names.${identificador}`).append(fileBloc);
        };

        for (let file of thisInputFile.files) {
            arrFiles[identificador].items.add(file);
        }

        thisInputFile.files = arrFiles[identificador].files;


        $('span.file-delete').click(function() {
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

    /**
     * On click #submitEnviar
     * Call a function with the data and send all the emails
     */
    function triggerBtnEnviar() {
        $(`#submitEnviar`).on('click', function() {
            if (confirm('Deseja enviar os emails?')) {

                function doBefore() {
                    $('#spinner').show();
                    $('#body').hide();
                    if ($('#spinner').is(":visible") && $('#body').is(":hidden")) {
                        setTimeout(callSync, 1000)
                    } else {
                        setTimeout(doBefore, 500)
                    }
                }

                function sendMail(_callback) {
                    $("[id='emailsData']").each(function() {
                        const id = $(this).attr('data-id');
                        const nome = $(this).attr('data-nome');
                        const fileList = $(this).attr('data-listaArquivos');
                        emails.enviar(id, fileList, nome, );
                    });

                    _callback();
                }

                function callSync() {
                    sendMail(function() {
                        $('#body').show();
                        $('#spinner').hide();
                        $('#previa').hide();
                        $('#result').show();
                    });
                }
                $("#submitEnviar").prop('disabled', true);
                setTimeout(function() {
                    $("#submitEnviar").prop('disabled', false);
                }, 5000)
                doBefore()

            }
        });
    }
</script>