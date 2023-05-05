/**
 * @param string: nomeArquivo(file name)
 * @param string: path(path to the file)
 *
 * Open a modal with view of pdf
 */
function viewPdf(nomeArquivo, path) {
	var canvas = document.createElement('canvas');
	canvas.setAttribute('id', 'canvas' + nomeArquivo.replace(/ /g, ''));
	canvas.classList.add('the-canvas');
	var modal = document.getElementById('modal-content');
	modal.appendChild(canvas);

	// modal
	$('#modal-bg').addClass('bg');
	var modal = document.getElementById('myModal');
	modal.style.display = 'inherit';
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName('close')[0];
	span.onclick = function () {
		modal.style.display = 'none';
		$('#modal-bg').removeClass('bg');
		canvas.remove();
		window.onclick = function (event) {
			if (event.target == modal) {
				modal.style.display = 'none';
			}
		};
	};

	//-PDF JS

	var PDF_URL = path + decodeURI(nomeArquivo);
	pdfjsLib.GlobalWorkerOptions.workerSrc =
		'./lib/pdfjs-dist/build/pdf.worker.js';
	//var pdfjsLib = window['/lib/pdfjs-dist/build/pdf'];
	//pdfjsLib.GlobalWorkerOptions.workerSrc = './lib/pdfjs-dist/build/pdf.worker.js';
	let loadingTask = pdfjsLib.getDocument(decodeURI(PDF_URL));

	var pdfDoc = null,
		pageNum = 1,
		pageRendering = false,
		pageNumPending = null,
		scale = 0.8,
		ctx = canvas.getContext('2d');

	/**
	 * @param num: Page number.
	 *
	 * Get page info from document, resize canvas accordingly, and render page.
	 */
	function renderPage(num) {
		pageRendering = true;
		// Using promise to fetch the page
		pdfDoc.getPage(num).then(function (page) {
			var viewport = page.getViewport({
				scale: 2,
			});
			canvas.height = viewport.height;
			canvas.width = viewport.width;

			// Render PDF page into canvas context
			var renderContext = {
				canvasContext: ctx,
				viewport: viewport,
			};
			var renderTask = page.render(renderContext);

			// Wait for rendering to finish
			renderTask.promise.then(function () {
				pageRendering = false;
				if (pageNumPending !== null) {
					// New page rendering is pending
					renderPage(pageNumPending);
					pageNumPending = null;
				}
			});
		});

		// Update page counters
		document.getElementById('page_num').textContent = num;
	}

	/**
	 * @param num: Page number.
	 * If another page rendering in progress, waits until the rendering is
	 * finised. Otherwise, executes rendering immediately.
	 */
	function queueRenderPage(num) {
		if (pageRendering) {
			pageNumPending = num;
		} else {
			renderPage(num);
		}
	}

	/**
	 * Displays previous page.
	 */
	function onPrevPage() {
		if (pageNum <= 1) {
			return;
		}
		pageNum--;
		queueRenderPage(pageNum);
	}
	document.getElementById('prev').addEventListener('click', onPrevPage);

	/**
	 * Displays next page.
	 */
	function onNextPage() {
		if (pageNum >= pdfDoc.numPages) {
			return;
		}
		pageNum++;
		queueRenderPage(pageNum);
	}
	document.getElementById('next').addEventListener('click', onNextPage);

	/**
	 * Asynchronously downloads PDF.
	 */
	pdfjsLib.getDocument(decodeURI(PDF_URL)).promise.then(function (pdfDoc_) {
		pdfDoc = pdfDoc_;
		document.getElementById('page_count').textContent = pdfDoc.numPages;

		// Initial/first page rendering
		renderPage(pageNum);
	});
}

/**
 * @param string: nomeArquivo
 * @param string: nome
 * @param string: sobrenome
 * @param int: id
 *
 * Find files inside the path folder, read content and turn into array
 * Verify if contains in this array the name (nome) and last name (sobrenome)
 *
 * call method -> emails.validarPdf(obj: {PageNumber:{nome: boolean, sobrenome: boolean}}, int: id, string: nomeArquivo, num: CurrentPgage, num: totalPgs)
 *
 */
function chamaValidar(nomeArquivo, nome, sobrenome, id) {
	var PDF_URL =
		'<?= __PATH_FILE__ ?>' + decodeURI(nomeArquivo) + '<?= __EXT_FILE__ ?>';
	let objResult = {};

	pdfjsLib.GlobalWorkerOptions.workerSrc =
		'./lib/pdfjs-dist/build/pdf.worker.js';
	let loadingTask = pdfjsLib.getDocument(decodeURI(PDF_URL));

	loadingTask.promise.then(function (pdf) {
		let totalPgs = pdf.numPages;
		for (let y = 1; y <= Number(totalPgs); y++) {
			sincrona(y);
		}

		function sincrona(i) {
			pdf.getPage(i).then(function (page) {
				let arrContent = new Array();

				page.getTextContent().then(function (textContent) {
					for (let j = 0; j < textContent.items.length; j++) {
						arrContent.push(textContent.items[j].str.toUpperCase());
					}

					let objPaginas = {};

					var nomeRegex = new RegExp(`(${nome.toUpperCase()})`, 'g');
					var SobrenomeRegex = new RegExp(`(${sobrenome.toUpperCase()})`, 'g');

					var matchedNome = arrContent.some((e) => nomeRegex.test(e));
					var matchedSobrenome = arrContent.some((e) => SobrenomeRegex.test(e));

					if (matchedNome) {
						Object.assign(objPaginas, {
							nome: [nome.toUpperCase(), true],
						});
					} else {
						Object.assign(objPaginas, {
							nome: [nome.toUpperCase(), false],
						});
					}

					if (matchedSobrenome) {
						Object.assign(objPaginas, {
							sobrenome: [sobrenome.toUpperCase(), true],
						});
					} else {
						Object.assign(objPaginas, {
							sobrenome: [sobrenome.toUpperCase(), false],
						});
					}

					emails.validarPdf(
						Object.assign(
							{},
							{
								[i]: objPaginas,
							}
						),
						id,
						nomeArquivo,
						i,
						totalPgs
					);
				});
			});
		}
	});
}
