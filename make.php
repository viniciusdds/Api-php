<!DOCTYPE html>
<html lang="en">

<head>
    <title>HTML to PDF</title>
	<style>
    #conteudo {
        background: white;
    }
	
	#totable{
		margin-left: 30px;
	}

    .lista {
        font-size: 18px;
        padding: 10px;
        color: black;
    }

    .titulo {
        font-size: 20px;
        color: black;
        font-weight: bold;
        padding: 25px;
        text-align: center;
        height: 80px;
    }

    .aviso {
        font-size: 14px;
        padding: 15px;
		text-align: left;
    }

    .pdf {
        margin-left: -10px;
    }
</style>
</head>

<body>
    <a href="#">Download Table As PDF</a>
   
        <table id="totable" width="65%" align="center" style="text-align: center;" border="0">
            <tbody>
                <tr>
                    <td>
                        <table border="1" width="100%">
                            <thead>
                                <tr style="border:0" class="titulo">
                                    <th colspan="2" >
                                        <p><strong>Relatório de Verificação Física</strong></p>
                                    </th>
                                   
                                </tr>
							</thead>
							<tbody>
                                <tr class="lista">
                                    <td width="114">
                                        <p>Data: 14/10/2020</p>
                                    </td>
                                    <td width="114">
                                        <p>Recinto: Aurora Terminais</p>
                                    </td>
								</tr>
                                <tr class="lista">
                                    <td width="114">
                                        <p>Fiscal: Leonardo Moura</p>
                                    </td>
                                    <td width="114">
                                        <p>Vistoriador: Clayton Souza</p>
                                    </td>
								</tr>
								<tr class="lista">
                                    <td width="114">
                                        <p>Hora Inicial: 14/10/2020 09:23</p>
                                    </td>
                                    <td width="114">
                                        <p>Hora Final: 14/10/2020 10:34</p>
                                    </td>
								</tr>
<tr>
					<td colspan="2" class="aviso">Declaro sob a pena da lei, que a conferÇencia aduaneira remota no documento DUIMP - 12344567891 foi Aprovada conforme as anotações abaixo descritas:<br>
					Portaria 36/2020<br>
					Para demais comprovações, segue abaixo as imagens capturadas pela câmera do recinto:</td>
				</tr>
				<tr>
					<td colspan="2">
						 <img class="imagem" src="images/image3.jpg" alt="media" width="800" height="500">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						 <img class="imagem" src="images/image2.jpg" alt="media" width="800" height="500">
					</td>
				</tr>
                            </tbody>
                        </table>
						
                    </td>
                </tr>
				
            </tbody>
        </table>
        <p>&nbsp;</p>
   

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.1/jspdf.plugin.autotable.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
    <script type="text/javascript">
        var quotes = document.getElementById('totable');
        //! MAKE YOUR PDF
        var pdf = new jsPDF('p', 'mm', 'letter', true);
        html2canvas(quotes, {
            onrendered: function (canvas) {



                for (var i = 0; i <= quotes.clientHeight / 980; i++) {
                    //! This is all just html2canvas stuff
                    var srcImg = canvas;
                    var sX = 0;
                    var sY = 1100 * i; // start 1100 pixels down for every new page
                    var sWidth = 900;
                    var sHeight = 1100;
                    var dX = 0;
                    var dY = 0;
                    var dWidth = 900;
                    var dHeight = 1100;

                    window.onePageCanvas = document.createElement("canvas");
                    onePageCanvas.setAttribute('width', 900);
                    onePageCanvas.setAttribute('height', 1100);
                    var ctx = onePageCanvas.getContext('2d');
                    // details on this usage of this function: 
                    // https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial/Using_images#Slicing
                    ctx.drawImage(srcImg, sX, sY, sWidth, sHeight, dX, dY, dWidth, dHeight);

                    // document.body.appendChild(canvas);
                    var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);

                    var width = onePageCanvas.width;
                    var height = onePageCanvas.clientHeight;

                    //! If we're on anything other than the first page,
                    // add another page
                    if (i > 0) {
                        pdf.addPage(612, 791); //8.5" x 11" in pts (in*72)
                    }
                    //! now we declare that we're working on that page
                    pdf.setPage(i + 1);
                    //! now we add content to that page!
                    pdf.addImage(canvasDataURL, 'PNG', 30, 40, (width * .62), (height * .62));

                }
            }
        })

        $('a').click(function () {
            pdf.save('Test.pdf');
        });
    </script>
</body>

</html>