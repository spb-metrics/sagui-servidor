<?
/*
SERPRO - Serviço Federal de Processamento de Dados, Brasil

Este arquivo é parte do programa SAGÜI -Sistema de Apoio à Gerência Unificada de Informações

O SAGÜI é um software livre; você pode redistribui-lo e/ou modifica-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença, ou (na sua opnião) qualquer versão.

Este programa é distribuido na esperança que possa ser util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "LICENCA.txt", junto com este programa, se não, escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


$histsize=$_GET['histsize'];
$refresh=$_GET['refresh'];
$evento=$_GET['evento'];
$status=$_GET['status'];
$idscript=$_GET['idscript'];
$chave=$_GET['chave'];
$query1="chave=$chave&idscript=$idscript&status=$status&evento=$evento&refresh=$refresh&histsize=$histsize";
?>
<FRAMESET cols="20%, 80%">
  <FRAME src="regionais.php?<?echo $query;?>">
  <FRAME name="evento" src="painelevento.php?<?echo $_SERVER['QUERY_STRING']?>">
  </FRAMESET>
  <NOFRAMES>
  </NOFRAMES>
</FRAMESET>
