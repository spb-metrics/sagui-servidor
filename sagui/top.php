<?
/*
SERPRO - Serviço Federal de Processamento de Dados, Brasil

Este arquivo é parte do programa SAGÜI -Sistema de Apoio à Gerência Unificada de Informações

O SAGÜI é um software livre; você pode redistribui-lo e/ou modifica-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença, ou (na sua opnião) qualquer versão.

Este programa é distribuido na esperança que possa ser util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "LICENCA.txt", junto com este programa, se não, escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


session_start();
include "includes/functions.php";
if(!isset($_SESSION['login'])) sair();
connect();
?>
<HTML><HEAD><TITLE></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<STYLE type=text/css>BODY {
	FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; BACKGROUND-COLOR: #eeeeee; TEXT-DECORATION: none
}
A {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000099; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
</STYLE>

<BODY>

<FONT size=3>SAGUI <B>Gerenciamento Unificado de Informa&ccedil;&otilde;es</B></FONT><BR>
|
<?
$q="select m.id,m.nome,m.href,m.target from menu m,perfildeusomenu pm where m.id=pm.idmenu ";
$q=$q." and pm.idperfildeuso='".$_SESSION['perfildeuso']."' order by nome ";
$result=pg_exec($conn,$q);
$lines=pg_numrows($result);
if($lines==0){
	mensagem('Problemas no perfil de uso');
	sair();
}
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);
	echo "<A href=$linha[2]?esq=menu.php?menuid=$linha[0] target=$linha[3]>$linha[1]</A> | "; 
}
?>

</BODY></HTML>
