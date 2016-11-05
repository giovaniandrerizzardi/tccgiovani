var conexao;
var desconexao;
var encaminhar;
var help;
var tomada;
var canal;
var modulo;
var conexaoAtiva;
var reiniciar;

function pageLoad()
{
    conexao = document.getElementById("conectarWS");
    conexao.onclick = conectarWebSocket;

    desconexao = document.getElementById("desconectarWS");
    desconexao.onclick = desconectarWebSocket;

    tomada = document.getElementById("outletsForm");
    canal = document.getElementById("channelForm");
    modulo = document.getElementById("modulesForm");

    encaminhar = document.getElementById("mensagemWS");
    encaminhar.onclick = enviarCapture;

    help = document.getElementById("mensagemWSHelp");
    help.onclick = enviarHelp;

    reiniciar = document.getElementById("reiniciarMBED");
    reiniciar.onclick = enviarReset;

    consoleLogVar = document.getElementById("consoleLog");
}

function conectarWebSocket()
{
    websocket = new WebSocket('ws://localhost:8080');
    websocket.onopen = function (e) {
        onOpen(e);
    };
    websocket.onclose = function (e) {
        onClose(e);
    };
    websocket.onmessage = function (e) {
        onMessage(e);
    };
    websocket.onerror = function (e) {
        onError(e);
    };


    //return algo;
}

function onOpen(e)
{
    consoleLog("Conectado!!!");
    conexaoAtiva = true;
}
function onClose(e)
{
    conexaoAtiva = false;
    consoleLog("Desconectado!!!");
}

function onMessage(e)
{
    consoleLog('<span style="color: blue;">Resposta: ' + e.data+'</span>');
}

function onError(e)
{
    consoleLog('<span style="color: red;">Erro:</span> ' + e.data);
}

function enviarCapture() {

    moduloIP = modulo.options[modulo.selectedIndex].getAttribute("ip");
    if(!conexaoAtiva){
        conectarWebSocket();
        alert("Conexão não estava ativa, favor enviar novamente a mensagem!!!");
        //informar que está desconectado e precisa reenviar a mensagem
    }
     else {
      websocket.send("#*capture*#" + moduloIP + ":" + tomada.value + ":" + canal.value);
    }
    //consoleLog("Enviado: " + enviarMensagem.value);
}

function enviarHelp() {
    if(!conexaoAtiva){
        conectarWebSocket();
        alert("Conexão não estava ativa, favor enviar novamente a mensagem!!!");
        //informar que está desconectado e precisa reenviar a mensagem
    }
    else
    {
      websocket.send("#*help*#");
    }
    //consoleLog("Enviado: " + enviarMensagem.value);
}

function enviarReset() {
    if(!conexaoAtiva){
        conectarWebSocket();
        alert("Conexão não estava ativa, favor enviar novamente a mensagem!!!");
        //informar que está desconectado e precisa reenviar a mensagem
    }
    else
    {
      websocket.send("#*reiniciar*#");
    }
    //consoleLog("Enviado: " + enviarMensagem.value);
}

function consoleLog(mensagem)
{
    //mostrar em alguma div
}

function desconectarWebSocket()
{
    websocket.close();
}

window.addEventListener("load", pageLoad, false);
