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
<HTML><HEAD><TITLE>.:SAGUI:.</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<LINK href="default.css" type=text/css rel=StyleSheet></HEAD>
<BODY>
<?
$q="select s.nome,s.href,s.target from submenu s,menusubmenu ms where s.id=ms.idsubmenu ";
$q=$q."and ms.idmenu='".$_GET['menuid']."' order by s.nome";
$result=pg_exec($conn,$q);
$lines=pg_numrows($result);
if($lines==0){
	sair();
}
?>
<TABLE align="center" width="100%">
<?
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);

?>
<TR>
<TD class=td_label align=right width="30%" colspan=1>
<a href="<?echo $linha[1]?>" target="<?echo $linha[2]?>"><?echo $linha[0]?></a>
</TD>
</TR>
<?}?>
</table>
</BODY>
</HTML>
<?

?>
