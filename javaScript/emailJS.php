<script>
    var emails = {
        loadEmails: function(arr) {
            $('#spinner').show();
            $('#body').hide();
            $.ajax({
                url: '/src/controller/emailController.php?action=read',
                data: {
                    arrFunc: arr.join(', '),

                },
            }).done(function(dados) {
                $('#body').show();
                $('#spinner').hide();
                $('#listaEmails').html(dados);
                triggersEmailsList();
            });
        },


        validarPdf: function(strJson, id, doc, currentPage, totalPages) {

            $.ajax({
                url: '/src/controller/emailController.php',
                data: {
                    'objValidar': JSON.stringify(strJson),
                    'action': 'validate',
                    'currentPage': currentPage,
                },
            }).done(function(dados) {
                $(`.conteudopg.${doc.replace(/ /g, '')}`).append(dados);

                $(`.paginas.${doc.replace(/ /g, '')}`).html(`${totalPages}<span>Paginas</span>`);


            });

        },

        previa: function(id, arrArquivosPasta, nome) {

            $.ajax({
                url: `/src/controller/emailController.php?action=preview`,
                'data': funcFormDatation(id, arrArquivosPasta, nome),
                type: 'POST',
                'async': true,
                'cache': false,
                'contentType': false,
                'processData': false,

            }).done(function(dados) {

                $('#previa').append(dados);
                triggersPrevia();

            });

        },

        enviar: function(id, arrArquivosPasta, nome) {
            $('#spinner').show();
            $('#body').hide();
            $.ajax({
                url: `/src/controller/emailController.php?action=sendEmail`,
                'data': funcFormDatation(id, arrArquivosPasta, nome),
                type: 'POST',
                'async': true,
                'cache': false,
                'contentType': false,
                'processData': false,
                async: false,

            }).done(function(dados) {
                $('#body').show();
                $('#spinner').hide();
                $('#resultPrint').append(dados);

            });

        },



    }

    function funcFormDatation(id, arrArquivosPasta, nome) {

        data = new FormData();
        /*   Array.from($(`#arquivosGeral`)[0].files).forEach((f) => {
               data.append('arquivosGeral[]', f)
           })
           
           */
        for (let i = 0; i < $(`#arquivosGeral`)[0].files.length; i++) {

            data.append(`arquivosGeral_${i}`, $(`#arquivosGeral`)[0].files[i]);
        };
        for (let i = 0; i < $(`#arquivos${id}`)[0].files.length; i++) {

            data.append(`arquivosGeral${nome.replace(' ', '-')}_${i}`, $(`#arquivos${id}`)[0].files[i]);
        };

        data.append(`Nome`, $(`#Nome.${id}`).val());
        data.append(`Email`, $(`#Email.${id}`).val());
        data.append(`assunto`, $(`#assunto.${id}`).val());
        data.append(`mensagem`, '<p>' + $(`#mensagem.${id}`).val().replace(/\r\n|\r|\n/g, "</p><p>") + '</p>');
        data.append(`copias`, $('#copias').val());
        data.append(`arquivosPasta`, arrArquivosPasta);

        return data;
    }
</script>