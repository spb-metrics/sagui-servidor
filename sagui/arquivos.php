<?
/*
SERPRO - Serviço Federal de Processamento de Dados, Brasil

Este arquivo é parte do programa SAGÜI -Sistema de Apoio à Gerência Unificada de Informações

O SAGÜI é um software livre; você pode redistribui-lo e/ou modifica-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença, ou (na sua opnião) qualquer versão.

Este programa é distribuido na esperança que possa ser util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "LICENCA.txt", junto com este programa, se não, escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

 

include "includes/functions.php";
connect();
$rede=$_GET["rede"];
//if (! $_GET["homologa"] | $_GET["homologa"]!="yes" ) 
$status="and v.status='LIBERADO'";
$query="select v.versao,v.conteudo,s.id from versaoscriptpatch v,scriptpatch s where ";
$query=$query."s.nome='".$_GET["arquivo"]."' and v.idscript=s.id $status order by v.versao desc";
$result=pg_exec($conn,$query);
$lines=pg_num_rows($result);
if($lines>0){
	$linha = pg_fetch_row($result,0);
	echo "IDSCRIPT=$linha[2]\n";
	echo $linha[1];
}
else
	echo "echo Arquivo n�o existe ou n�o esta liberado\n";
?>
