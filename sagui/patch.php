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
if($_POST["erros"]){
	$where=" where idpatch='".$_POST["patch"]."'";
	$colunas=array("IP","Data da ocorrencia");
	echo "<HTML><HEAD><LINK href=\"default.css\" type=text/css rel=StyleSheet></HEAD><BODY>";
	geralistavisao("Lista de Maquinas",$colunas,"vw_lista_log_erro_patch_last","","",$where);
	echo "</BODY></HTML>";
}
elseif($_POST["acertos"]){
	$where=" where idpatch='".$_POST["patch"]."'";
	$colunas=array("IP","Data da ocorrencia");
	echo "<HTML><HEAD><LINK href=\"default.css\" type=text/css rel=StyleSheet></HEAD><BODY>";
	geralistavisao("Lista de Maquinas",$colunas,"vw_lista_log_ok_patch","","",$where);
	echo "</BODY></HTML>";

}
elseif($_GET["acao"]=="criarpatch"){
	if($_POST["butincluirpatch"]){ 
		foreach($_POST as $i => $valor){
			if(!$valor){
				$mensagem="Preencha todos os campos";
				$incompleto="sim";
			}
		}
		if( !($_POST["perfis"] && $_POST["unidades"] && $_POST["script"])) {
			$mensagem="Preencha todos os campos";
			$incompleto="sim";		
		}		
		if(!$incompleto){
			pg_exec($conn,"BEGIN");
			$result=pg_exec($conn,"select nextval('patch_id_seq')");
			$linha=pg_fetch_row($result,0);
			$id=$linha[0];
			$query="insert into patch (id,titulo,msg,idusuario,idscript) values ";
			$query=$query."('$id','".$_POST["titulo"]."','".$_POST["msg"]."','".$_SESSION['uid']."','".$_POST["script"]."')";
			pg_exec($conn,$query);
			foreach($_POST["perfis"] as $i => $valor){
				pg_exec($conn,"insert into patchperfil (idpatch,idperfil) values ('$id','$valor')");	
			}
			foreach($_POST["unidades"] as $i => $valor){
				pg_exec($conn,"insert into patchunidade (idpatch,idunidade) values ('$id','$valor')");
				if($valor==-1) break;
			}
			pg_exec($conn,"COMMIT");
			$mensagem="Patch incluido com sucesso";
			$feito="ok";
			$voltar="patch.php?acao=criarpatch";
			
		}
	}
	if (!$feito) include "includes/fcadastrapatch.inc";
	else include "includes/msg.inc";
}
elseif($_GET["acao"]=="alterarpatch"){
	if($_POST["butincluirpatch"]){ 
		foreach($_POST as $i => $valor){
			if(!$valor){
				$mensagem="Preencha todos os campos";
				$incompleto="sim";
			}
		}
		if( !($_POST["perfis"] && $_POST["unidades"] && $_POST["script"])) {
			$mensagem="Preencha todos os campos";
			$incompleto="sim";		
		}		
		if(!$incompleto){
			pg_exec($conn,"BEGIN");
			$id=$_POST["patch"];
			pg_exec($conn,"delete from patchperfil where idpatch='$id'");
			pg_exec($conn,"delete from patchunidade where idpatch='$id'");
			$q="update patch set idscript='".$_POST["script"]."',";
			$q=$q."msg='".$_POST["msg"]."',titulo='".$_POST["titulo"]."' where id='$id'";
			pg_exec($conn,$q);
			$mensagem="Patch alterado com sucesso";
			foreach($_POST["perfis"] as $i => $valor){
				pg_exec($conn,"insert into patchperfil (idpatch,idperfil) values ('$id','$valor')");	
			}
			foreach($_POST["unidades"] as $i => $valor){
				pg_exec($conn,"insert into patchunidade (idpatch,idunidade) values ('$id','$valor')");
				if($valor==-1) break;
			}
			pg_exec($conn,"COMMIT");
			$feito="ok";
			$voltar="gerenciar.php?lista=".$_GET['lista'];

		}
	}
	if (!$feito) include "includes/fcadastrapatch.inc";
	else include "includes/msg.inc";
}
elseif($_GET["acao"]=="adcionarscript"){
	if($_POST["butsave"]){ 
		if($_POST["filename"] && $_POST["texto"]){
			$query="select s.id,v.versao from scriptpatch s,versaoscriptpatch v ";
			$query=$query."where s.nome='".$_POST['filename']."' and s.id=v.idscript ";
			$query=$query."order by v.versao desc";
			$result=pg_exec($conn,$query);
			$lines=pg_numrows($result);
			if($lines==0){
				pg_exec($conn,"BEGIN");
			  	$cols=array("nome"=>$_POST['filename'],"status"=>"NOVO","tipo"=>$_POST['tiposcript']);
				incluinatabela("scriptpatch",$cols);
				$result=pg_exec($conn,"select id from scriptpatch where nome='".$_POST['filename']."'");
				$linha=pg_fetch_row($result,0);
				$query="insert into versaoscriptpatch (idscript,idusuario,conteudo) "; 
				$query=$query."values ('$linha[0]','".$_SESSION['uid']."','".addslashes($_POST['texto'])."')";
				pg_exec($conn,$query);
				$cols=array("idusuario"=>$_SESSION["uid"],"status"=>"NOVO","idscript"=>$linha[0],"versao"=>"1");
				incluinatabela("log_atividade_scripts",$cols);
				if (pg_exec($conn,"COMMIT")){
						$_POST["filename"]="";
						$_POST["texto"]="";
						//$_POST["tiposcript"]="";
						$mensagem="Script incluido com sucesso";
				}
			}
			else{
				$linha=pg_fetch_row($result,0);
				$versao=$linha[1]+1;
				$cols=array("idscript"=>$linha[0],"idusuario"=>$_SESSION['uid'],"conteudo"=>addslashes($_POST['texto']),"versao"=>$versao);
				incluinatabela("versaoscriptpatch",$cols);
				if (pg_exec($conn,$query)){
						$_POST["filename"]="";
						$_POST["texto"]="";
						//$_POST["tiposcript"]="";
						$mensagem="Script incluido com sucesso sob a versao $versao";
				}
				$cols=array("idusuario"=>$_SESSION["uid"],"status"=>"NOVO","idscript"=>$linha[0],"versao"=>"$versao");
				incluinatabela("log_atividade_scripts",$cols);

			}
		}
		else $mensagem="Voce precisa preencher todos os campos";
	}elseif($_POST["butupload"]){
			$result=pg_exec($conn,"select id,tipo from scriptpatch where nome='".$_FILES['conteudo']['name']."'");
			$lines=pg_numrows($result);
			if($lines!=0){
				$linha=pg_fetch_row($result,0);
				$mensagem="Já existe um script com esse nome";
				$_POST["tiposcript"]=$linha[1];
			}
	}
	include "includes/fcadastrascript.inc";
	exit;
}
?>
