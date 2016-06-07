<?
/*
SERPRO - Serviço Federal de Processamento de Dados, Brasil

Este arquivo é parte do programa SAGÜI -Sistema de Apoio à Gerência Unificada de Informações

O SAGÜI é um software livre; você pode redistribui-lo e/ou modifica-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença, ou (na sua opnião) qualquer versão.

Este programa é distribuido na esperança que possa ser util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "LICENCA.txt", junto com este programa, se não, escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
 
<HTML><HEAD><TITLE>.:SAGUI:.</TITLE><LINK href="default.css" type=text/css rel=StyleSheet>
<script language="javascript">
function createRequestObject() {
     var ro;
     var browser = navigator.appName;
     if(browser == "Microsoft Internet Explorer"){
          ro = new ActiveXObject("Microsoft.XMLHTTP");
     }else{
          ro = new XMLHttpRequest();
     }
     return ro;
}

var http = createRequestObject();

function sndReq( idElemento, tipoPesquisa ) {
     http.open('get', 'ajaxResposta.php?idElemento='+idElemento+'&tipoPesquisa='+tipoPesquisa);
     http.onreadystatechange = handleResponse;
     http.send(null);
}

function handleResponse() {
        if(http.readyState == 4){
                textoTip = http.responseText;
                tipobj.innerHTML = textoTip;
                enabletip=true
        }
}
</script>

<?
if($_GET['refresh']){ 
	$refresh=$_GET['refresh'];
	if($refresh<10) $refresh=10;
}
else	$refresh=60;
if($_GET['histsize']){
        $HR=$_GET['histsize'];
        if($HR<1) $refresh=1;
}
else    $HR=1;
if($_GET['evento']){
	$evento=strtoupper($_GET['evento']);
	$filtro=" and te.nome='$evento' ";
}
if($_GET['chave']){
        $chave=$_GET['chave']; 
	$filtro=$filtro." and idequipamento='$chave' ";

}
if($_GET['status']){
        $status=$_GET['status'];
	$filtro=$filtro." and status='$status' ";
}
if($_GET['idscript']){
        $idscript=$_GET['idscript'];
	$filtro=$filtro." and idscript='$idscript' ";
}
if($_GET['ip']){
        $ip=$_GET['ip'];
	$filtro=$filtro." and ip='$ip' ";
}
echo "<meta HTTP-EQUIV = \"Refresh\" CONTENT = \"$refresh; URL = painelevento.php?".$_SERVER['QUERY_STRING']."\">"; 
?>

</HEAD><BODY>
<div id="dhtmltooltip"  onClick=hideddrivetip()></div>
<script type="text/javascript">
<!--
var offsetxpoint=-60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false

var textoTip = ''

if (ie||ns6)
var tipobj= ( document.all? document.all["dhtmltooltip"] : document.getElementById ? document.getElementById("dhtmltooltip")
: "" )

/*

tipobj.style.width = 300px
tipobj.style.backgroundColor = yellow

*/


function ietruebody(){
        return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip( idElemento, tipoPesquisa ){
        if (ns6||ie){
                http.open('get', 'ajaxResposta.php?idElemento='+idElemento+'&tipoPesquisa='+tipoPesquisa)
                http.onreadystatechange = handleResponse;
                http.send(null);
		return false
       }
}

function positiontip(e){
        if (enabletip){
		tipobj.style.top="1px"
		tipobj.style.left="5px"
                tipobj.style.visibility="visible"
        }
}

function hideddrivetip(){
        if (ns6||ie){
               enabletip=false
                tipobj.style.visibility="hidden"
                tipobj.style.left="-1000px"
                tipobj.style.backgroundColor=''
                tipobj.style.width=''
        }
}

document.onclick=positiontip
-->
</script>

<?
//print_r($_SERVER['QUERY_STRING']);
include "includes/functions.php";
connect();

?>


<form method=get name=painel target=_parent action=painel.php>
<table align=center>
<?if($_GET['unidade']) echo "<tr><td colspan=14>UNIDADE: ".$_GET['unidade']."</td></tr>";?>
<tr>
<td class=text_small>TEMPO(>10)<BR>(segundos)</td><td><input type=text name=refresh value="<?echo $refresh;?>" size=5></td>
<td class=text_small>EVENTO</td><td><input type=text name=evento size=10 value="<?echo $evento;?>"></td>
<td class=text_small>CHAVE EQP</td><td><input type=text name=chave size=5 value="<?echo $chave;?>"></td>
<td class=text_small>IP EQP</td><td><input type=text name=ip size=5 value="<?echo $ip;?>"></td>
<td class=text_small>PLUGIN</td><td><input type=text name=idscript size=5 value="<?echo $idscript;?>"></td>
<td class=text_small>STATUS</td><td><input type=text name=status size=3 value="<?echo $status;?>"></td>
<td class=text_small>HISTORICO<br>(horas)</td><td><input type=text name=histsize value="<?echo $HR;?>" size=4></td>
<td><input type=submit name=but value=OK></td><td></td>
</tr></table>
<input type=hidden name=unidade value=<?echo $_GET['unidade'];?>>
<input type=hidden name=idunidade value=<?echo $_GET['idunidade'];?>>
</form> 
<?
if($chave){        
	$q="(SELECT vc.idequipamento as id,a.nome,c.value from (SELECT idatributo,idequipamento,max(id) as id from coleta  group by idatributo,idequipamento) as vc, atributo a, coleta c  where c.id=vc.id and a.id=c.idatributo) as tabela";
	$cols=array("nome","value");
        geralistamulti("Dados de Servidor",$cols,$q,"","painelevento.php?".$_SERVER['QUERY_STRING'],"where id ='$chave'");
}
if($_GET["idunidade"]){
	$porunid="and eq.idunidade='".$_GET["idunidade"]."'";
}
$q="SELECT to_char(data,'dd-mm-yyyy HH24:mi:ss'),te.nome,u.codigoemb, idequipamento,ip,status,saida,visto,idscript from evento e, tipoevento te, equipamento eq,unidade u where eq.idunidade=u.id and te.id=e.idtipoevento and e.idequipamento=eq.id and data > now() - interval '$HR hour' $porunid $filtro order by data desc";
$result=pg_exec($conn,$q);
$lines=pg_numrows($result);
$c="td_warn";
echo "<table width=100%>";
echo "<tr><td></td>";
echo "<td class=$c align=right>TEMPO</td><td class=$c align=center>EVENTO</td>";
echo "<td class=$c align=center>UNIDADE</td><td class=$c align=center>CHAVE EQP</td><td class=$c align=center>IP EQP</td>\n";
echo "<td class=$c align=center>SAIDA</td><td class=$c align=center>ID PLUGIN</td><td class=$c align=center>STATUS</td></tr>\n";
for($i=0;$i<$lines;$i++){
	$l=pg_fetch_row($result,$i);
    if(!$l[5]){
	$c="text_small";
	$img="";
    }
    else{
	$c="text_warn";
	$img="<img src=imagens/ledred.png height=10 width=10>";
    }
    echo "<tr><td align=center>$img</td>";
    echo "<td class=$c align=right>$l[0]</td><td class=$c align=center>$l[1]</td>\n";
    echo "<td class=$c align=center>$l[2]</td>\n";
    echo "<td class=$c align=center onClick=\"ddrivetip($l[3], 'ce' )\"><u>$l[3]</u></td>\n";
    echo "<td class=$c align=center>$l[4]</td>\n";
    echo "<td class=$c align=center>$l[6]</td>\n";
    echo "<td class=$c align=center onClick=\"ddrivetip($l[8], 'script' )\" ><u>$l[8]</u></td><td class=$c align=center>$l[5]</td></tr>\n";
}
echo "</table>";
?>
