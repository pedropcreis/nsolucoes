function mascara(o,f){
    v_obj = o
    v_fun = f
    setTimeout("execmascara()",1)
}
function execmascara() {
    var valor_alterado = v_fun(v_obj.value);
    if (valor_alterado !== v_obj.value) {
        v_obj.value = v_fun(v_obj.value)
    }
}
function mtel(v){
    v=v.replace(/\D/g,"");
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2");
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");
    return v;
}
function mtelsemddd(v){
    v=v.replace(/\D/g,"");
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");
    return v;
}
function mcnpj(v){
    v=v.replace(/\D/g,"")
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
    v=v.replace(/(\d{4})(\d)/,"$1-$2")
    return v
}
function mcpf(v){
    v=v.replace(/\D/g,"")
    v=v.replace(/(\d{3})(\d)/,"$1.$2")
    v=v.replace(/(\d{3})(\d)/,"$1.$2")
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
    return v
}
function mcep(v){
    v=v.replace(/\D/g,"")
    v=v.replace(/^(\d{2})(\d{3})(\d)/,"$1.$2-$3")
    return v
}
function mnbm(v){
    v=v.replace(/\D/g,"")
    v=v.replace(/(\d{4})(\d)/,"$1.$2");
    v=v.replace(/(\d{2})(\d{1,2})$/,"$1.$2");
    return v
}
function msite(v){
    v=v.replace(/^http:\/\/?/,"")
    dominio=v
    caminho=""
    if(v.indexOf("/")>-1)
        dominio=v.split("/")[0]
        caminho=v.replace(/[^\/]*/,"")
    dominio=dominio.replace(/[^\w\.\+-:@]/g,"")
    caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
    caminho=caminho.replace(/([\?&])=/,"$1")
    if(caminho!="")dominio=dominio.replace(/\.+$/,"")
    v="http://"+dominio+caminho
    return v
}
function mdinheiro(v) {
	v=v.replace(/\D/g,"")
	v=v.replace(/(\d{1})(\d{14})$/,"$1.$2")
	v=v.replace(/(\d{1})(\d{11})$/,"$1.$2")
	v=v.replace(/(\d{1})(\d{8})$/,"$1.$2")
	v=v.replace(/(\d{1})(\d{5})$/,"$1.$2")
	v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2")
	return v;
}

function mQuantidadeBalanca(v) {
	v=v.replace(/\D/g,"")
	v=v.replace(/(\d{1})(\d{15})$/,"$1.$2")
	v=v.replace(/(\d{1})(\d{12})$/,"$1.$2")
	v=v.replace(/(\d{1})(\d{9})$/,"$1.$2")
	v=v.replace(/(\d{1})(\d{6})$/,"$1.$2")
	v=v.replace(/(\d{1})(\d{1,3})$/,"$1,$2")
	return v;
}

function mdinheiros(v) {
	v=v.replace(/\D/g,"")
	v=v.replace(/(\d{1})(\d)/,"$1,$2");
	return v;
}

function mdata(v){
    v=v.replace(/\D/g,"");
    v=v.replace(/(\d{2})(\d)/,"$1/$2");
    v=v.replace(/(\d{2})(\d)/,"$1/$2");
    v=v.replace(/(\d{4})(\d)/,"$1/$2");
    return v;
}
function mcvv(v){
    v=v.replace(/\D/g,"");    
    v=v.replace(/(\d{2})(\d)/,"$1/$2");
    v=v.replace(/(\d{4})(\d)/,"$1/$2");
    return v;
}

function mdata_hora(v) {
    v=v.replace(/\D/g, "");
    v=v.replace(/(\d{2})(\d)/, "$1/$2");
    v=v.replace(/(\d{2})(\d)/, "$1/$2");
    v=v.replace(/(\d{2})(\d{2})/, "$1$2");
    v=v.replace(/(\d{4})(\d)/, "$1 $2");
    v=v.replace(/\s(\d{2})(\d)/, " $1:$2");
    return v;
}

function mhora(v) {
    v=v.replace(/\D/g, "");
    v=v.replace(/(\d{2})(\d)/, "$1:$2");
    return v;
}

function soLetras(v){
    return v.replace(/\d/g,"")
}

function soLetrasMA(v){
    v = v.toUpperCase();
    return v.replace(/\d/g,"");
}

function letrasMA(v){
    v = v.toUpperCase();
    return v;
}

function soLetrasMI(v){
    v=v.toLowerCase()
    return v.replace(/\d/g,"")
}

function soNumeros(v){
    return v.replace(/\D/g,"")
}

function soNumerosPositivos(v){
    if(!isNaN(v)) {
        if(Number(v) < 1) {
            return v.replace(/[0]/g,"")
        }
    }
    return v.replace(/\D/g,"")
}

function soNumerosVirgulas(v){
    return v.replace(/^[0-9.,]+$/,"")
}