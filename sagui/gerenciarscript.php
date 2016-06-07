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
<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<?
if(!$_POST["script"] && $_GET["script"]) $_POST["script"]=$_GET["script"];

if($_POST["butbloquear"]){
	pg_exec($conn,"BEGIN");
	$query="update scriptpatch set status='BLOQUEADO' where ";
	$query=$query."id='".$_POST["script"]."'";
	pg_exec($conn,$query);
	$query="update versaoscriptpatch set status='BLOQUEADO' where ";
	$query=$query."idscript='".$_POST["script"]."' and versao='".$_POST["versao"]."'";
	pg_exec($conn,$query);
	$cols=array("idusuario"=>$_SESSION["uid"],"status"=>"BLOQUEADO","idscript"=>$_POST["script"],"versao"=>$_POST["versao"]);
	incluinatabela("log_atividade_scripts",$cols);
	pg_exec($conn,"COMMIT");
	$mensagem="Script bloqueado com sucesso";
	$voltar="gerenciarscript.php?lista=".$_GET['lista'];
	include "includes/msg.inc";

}
elseif($_POST["butliberar"]){
	pg_exec($conn,"BEGIN");
	$query="update scriptpatch set status='LIBERADO' where ";
	$query=$query."id='".$_POST["script"]."'";
	$cols=array("idusuario"=>$_SESSION["uid"],"status"=>"LIBERADO","idscript"=>$_POST["script"],"versao"=>$_POST["versao"]);
	incluinatabela("log_atividade_scripts",$cols);
	pg_exec($conn,$query);	
	$query="update versaoscriptpatch set status='TROCADO' where ";
	$query=$query."status='LIBERADO' and idscript='".$_POST["script"]."'";
	pg_exec($conn,$query);
	$query="update versaoscriptpatch set status='LIBERADO' where ";
	$query=$query."idscript='".$_POST["script"]."' and versao='".$_POST["versao"]."'";
	pg_exec($conn,$query);
	pg_exec($conn,"COMMIT");
	$mensagem="Script liberado com sucesso";
	$voltar="gerenciarscript.php?lista=".$_GET['lista'];
	include "includes/msg.inc";
}
elseif($_POST["buteditscript"]){
	$result=pg_exec($conn,"select tipo from scriptpatch where id='".$_POST["script"]."'");
	if(pg_numrows($result)){
		$linha=pg_fetch_row($result);
		$_POST["tiposcript"]=$linha[0];
	}
	include "includes/fcadastrascript.inc";
}
elseif($_POST["versao"]){
	include "includes/liberascript.inc";
}
elseif(!$_POST["script"]) include "includes/listascript.inc";
else include "includes/mostrascript.inc";

?>
</body>
</HTML>
