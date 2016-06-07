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
connect();
beginhtml();
if($_GET["acao"]=="adicionarcategoria"){
	if($_POST["butincluircategoria"]){
		foreach($_POST as $i => $valor){
			if(!$valor){
				$mensagem="Preencha todos os campos";
				$incompleto="sim";
			}
		}
		if( !($_POST["categoria"])) {
			$mensagem="Preencha todos os campos";
			$incompleto="sim";		
		}
		$result=pg_exec($conn,"select id from perfil where nome='".$_POST['categoria']."'");
		$lines=pg_numrows($result);
		if($lines!=0){
			$linha=pg_fetch_row($result,0);
			$mensagem="Já existe uma cotegoria com esse nome,inclusão abortada";
		}else{
			if(!$incompleto){
				$cols=array("nome"=>$_POST['categoria'],"legenda"=>$_POST['descritivo'],"adcionais"=>$_POST['adcionais']);
				incluinatabela("perfil",$cols);
				$mensagem="Categoria incluida com sucesso";
				$voltar="gerenciainstalacao.php";
				$feito="ok";
			}
		}

	}
	if (!$feito){
		include "includes/fcadastracategoria.inc";
	}
	else include "includes/msg.inc";
}
elseif($_GET["acao"]=="alterarcategoria"){
	if($_POST["butincluircategoria"]){ 
		foreach($_POST as $i => $valor){
			if(!$valor){
				$mensagem="Preencha todos os campos";
				$incompleto="sim";
			}
		}
		if( !($_POST["categoria"])) {
			$mensagem="Preencha todos os campos";
			$incompleto="sim";		
		}		
		if(!$incompleto){
			$id=$_POST["id"];
			$q="update perfil set nome='".$_POST["categoria"]."',legenda='".$_POST["descritivo"]."',adcionais='".addslashes($_POST["adcionais"])."' where id='$id'";
			echo $q;
			pg_exec($conn,$q);
			$mensagem="Categoria alterada com sucesso";
			$feito="ok";
			$voltar="gerenciainstalacao.php";
		}
	}
	if (!$feito) include "includes/fcadastracategoria.inc";
	else include "includes/msg.inc";
}
elseif($_GET["acao"]=="adcionarparametro"){
	$mensagem="Adcionar Parametro Regional";
	if($_POST["butadcionar"]){
		if( !($_POST["nome"]) | !($_POST["shellvar"])) {
			$mensagem="Preencha todos os campos";
			$incompleto="sim";		
		}
		else{
			$result=pg_exec($conn,"select id from parametroslocais where nome='".$_POST["nome"]."'");
			$lines=pg_numrows($result);
			if($lines!=0){
				if($_POST["id"]){
					$q="update parametroslocais set nome='".$_POST['nome']."',shellvar='".$_POST["shellvar"]."'";
					$q=$q." where id='".$_POST["id"]."'";
					pg_exec($conn,$q);
					$_POST["nome"]="";
					$_POST["shellvar"]="";
					$_POST["id"]="";
					$mensagem="Parametro alterado com secesso";
				}else{
					$linha=pg_fetch_row($result,0);
					$mensagem="Já existe um parametro com esse nome! Inclusao abortada";
				}
			}else{
				$cols=array("nome"=>$_POST["nome"],"shellvar"=>$_POST["shellvar"]);
				incluinatabela("parametroslocais",$cols);
				$_POST["nome"]="";
				$_POST["shellvar"]="";
				$_POST["id"]="";
				$mensagem="Parametro incluido com sucesso";
			}
		}	
	}
	
	$DIR="template";
	include "includes/fcadastraparametrolocal.inc";
	exit;
}
else{
      $colunas=array("Nome","Descritivo");
      $vw_perfil="(select id,nome,legenda from perfil) as perfil";
      geralistavisao("Perfil de Instala&ccedil;&atilde;o",$colunas,"$vw_perfil","id","gerenciainstalacao.php?acao=alterarcategoria","");
	
}
endhtml();
?>
