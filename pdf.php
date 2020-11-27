<?php 
	$dados = $_SERVER["REMOTE_ADDR"];
?>
<style>
	#table{
		font-size: 30px;
	}
</style>

<button id="btGerarPDF" onclick="generatePdf();">gerar PDF</button>
  <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">
            <div class="title_left">
                <h2><a href="index.php">Inicial</a> / Relatório</h2>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12 ">
                <div id="editor"></div>
                <a href="images/teste.pdf" download>Descarregue o regulamento</a>

                <button class="btn btn-danger" id="btGerarPDF" onclick="baixarPDF();"><i class="fa fa-file-pdf-o"></i> &nbsp;PDF</button>
            </div>
        </div>
        <div id="conteudo">
            <div class="row">
                <div class="col-md-12 border titulo">
                    <h2>Relatório de Verificação Física</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 border lista">
                    Data: 14/10/2020
                </div>
                <div class="col-md-6 border lista">
                    Recinto: Aurora Terminais
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 border lista">
                    Fiscal: Leonardo Moura
                </div>
                <div class="col-md-6 border lista">
                    Vistoriador: Clayton Souza
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 border lista">
                    Hora Inicial: 14/10/2020 09:23
                </div>
                <div class="col-md-6 border lista">
                    Hora Final: 14/10/2020 10:34
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 aviso">
                    Declaro sob a pena da lei, que a conferÇencia aduaneira remota no documento DUIMP - 12344567891 foi <b>Aprovada</b> conforme as anotações abaixo descritas:
                    <br>
                    Portaria 36/2020
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 aviso">
                    Para demais comprovações, segue abaixo as imagens capturadas pela câmera do recinto:
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 aviso">
                    <img src="images/image3.jpg" alt="media" width="800" height="500">
                </div>
            </div>
        </div>
    </div>



<script src="js/jqueryPdf.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.1.0/jspdf.plugin.autotable.js"></script>
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.1.0/jspdf.plugin.autotable.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.1.0/jspdf.plugin.autotable.js"></script>
-->

<script>
/*
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};
*/

//$('#btGerarPDF').click(function () {
	
	var div = document.querySelector("#conteudo");
	
	function generatePdf(){
		var imgData;
		
		html2canvas(div,{
			useCORS: true,
			onrendered: function(canvas){
				imgData = canvas.toDataURL('image/png');
				
				var doc = new jsPDF("p",'pt','a4');
				doc.addImage(imgData, 'PNG', 10, 10, 580, 300);
				
				doc.save('save-file.pdf');
			}
		});
	}
	
	//var dados = "<?php echo $dados; ?>";
    //var doc = new jsPDF();
	/*
	var specialElementHandlers = {
		'#editor': function (element, renderer) {
			return true;
		}
	};
	*/
	//doc.setFont("helverica");
	//doc.setFontStyle("bold");
	//doc.setFontSize(11);
	//doc.text("Pedido N°: "+dados,20,5);
	
	//doc.save();
	
	/*
	doc.fromHTML($('#conteudo').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save('exemplo-pdf.pdf');
	*/
//});
</script>
