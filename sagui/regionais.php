<?
/*
SERPRO - Serviço Federal de Processamento de Dados, Brasil

Este arquivo é parte do programa SAGÜI -Sistema de Apoio à Gerência Unificada de Informações

O SAGÜI é um software livre; você pode redistribui-lo e/ou modifica-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença, ou (na sua opnião) qualquer versão.

Este programa é distribuido na esperança que possa ser util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "LICENCA.txt", junto com este programa, se não, escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
 
<HTML><HEAD><TITLE>.:SAGUI:.</TITLE><LINK href="default.css" type=text/css rel=StyleSheet></HEAD><BODY>
<?
include "includes/functions.php";
connect();
echo "<table width=100%>";
echo "<tr><td align=center>UNIDADES</td></tr>";
echo "<tr><td><A HREF=painelevento.php?".$_SERVER['QUERY_STRING']." target=\"evento\">--->TODAS</A></td></tr>";
$result=pg_exec($conn,"select id,nome from unidade where id<>-1 order by nome");
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);
	echo "<tr><td><A HREF=painelevento.php?idunidade=$linha[0]&unidade=$linha[1]&".$_SERVER['QUERY_STRING']." target=\"evento\">$linha[1]</A></td></tr>";
}
echo "</table>";
?>
