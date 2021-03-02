$(window).on('load', function () {
    $('#preloader .inner').fadeOut();
    $('#preloader').delay(350).fadeOut('slow'); 
    $('body').delay(350).css({'overflow': 'visible'});
});

function abrirPopup(url,w,h) {
    var newW = w + 100;
    var newH = h + 100;
    var left = (screen.width-newW)/2;
    var top = (screen.height-newH)/2;
    var newwindow = window.open(url,'width='+newW+',height='+newH+',left='+left+',top='+top);
    newwindow.resizeTo(newW, newH);                
    //posiciona o popup no centro da tela
    newwindow.moveTo(left, top);
    newwindow.focus();
    return false;
}

function formataData(data){
    var dataFormatada = new Date(data + ' 00:00:00'); 
    return dataFormatada.toLocaleDateString('pt-BR');
}

var texto = new Array();
var valor = new Array();

function moversemordem(vemde, para) {
    var selLength = vemde.length;
    var count = 0;
    for(var i=selLength-1; i>=0; i--) {
        if(vemde.options[i].selected) {
            texto[count] = vemde.options[i].text;
            valor[count] = vemde.options[i].value;
            remover(vemde, i);
            count++;
            
        }
    }
    for(var i=count-1;i>=0;i--) {
        adicionar(para, texto[i], valor[i]);
    }
}
function adicionar(theSel, texto, valor) {
    var newOpt = new Option(texto,valor);
    var selLength = theSel.length;
    theSel.options[selLength] = newOpt;
}

function remover(theSel, theIndex) {
    var selLength = theSel.length;
    if(selLength>0) theSel.options[theIndex] = null;
}

$('#btnLocalizar').click(function(){
    abrirPopup("{{ route('layouts.localizar') }}",500,500);
});
$('#btnExcluir').prop('disabled', true);
$('#btnEditar').prop('disabled', true);
$('#btnImprimir').prop('disabled', true);


function calculaDesconto(){
    valorIntegral = $('#cont_valor_integral').val();
    desconto      = $('#cont_valor_desconto').val();
    desconto = desconto.replace(',','.');
    v1 = valorIntegral.replace(",",".");    
    valorDesconto = (desconto * v1) / 100;
    v2 = valorDesconto;
    $('#cont_vDesconto').val(v2.toFixed(2));
    valorFinal = v1 - valorDesconto;
    $('#cont_valor_final').val(valorFinal.toFixed(2));
}

function calculaParcelas(){
    valor1 = $('#cont_valor_final').val();
    valorEntrada = $('#cont_valor_entrada').val();
    vFinal = valor1.replace(',','.');
    nEntrada = valorEntrada.replace(',','.');
    n_parcelas = $('#cont_qtdParcela').val();
    calc2 = (vFinal - nEntrada) / n_parcelas;
    result = calc2;
    result = result.toFixed(2);
    $('#cont_valor_parcelas').val(result);
}

function formataValor(campo){
   int = $('#'+campo+'').val();
   var tmp = int+'';
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
    return $('#'+campo+'').val(tmp);
}

function ocultaCampo(valor, campo){
    var valor = $('#'+ valor).val();
    if(valor == 1){
        $(campo).hide();
    }else{
        $(campo).show();
    }
}