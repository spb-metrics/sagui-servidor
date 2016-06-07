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
if($_GET["acao"]){
	$id=$_POST["idusuario"];
	if($_POST["butincluirusuario"]){ 

		foreach($_POST as $i => $valor){
			if($i=="senha" || $i=="csenha")
				continue;
			if(!$valor){
				$mensagem="Preencha todos os campos";
				$incompleto="sim";
			}
		}
		if(!$incompleto){
			//checar se a senha e a confirmação batem
			if($_POST["senha"]!=$_POST["csenha"]){
				$mensagem="Senha nao confere";
			}
			elseif($_GET["acao"]=="criarusuario"){
				$result=pg_exec($conn,"select id from usuario where login='".$_POST["login"]."'");
				if(pg_numrows($result)){
					$mensagem="Login existente: escolha outro";
				}else{
					$q="insert into usuario (login,nome,senha,email,idperfildeuso) values ";
					$q=$q."('".$_POST["login"]."','".$_POST["nome"]."','".sha1($_POST["senha"])."','".$_POST["email"]."','".$_POST["idperfildeuso"]."')";
					pg_exec($conn,$q);
					$mensagem="Usuario incluido com sucesso";
					$feito="ok";
					$voltar="cadusuario.php?acao=criarusuario";
					$_POST["idusuario"]=="";
				}
			}
			elseif($_GET["acao"]=="alterarusuario"){
				//se a senha estiver vazia n�o deve alterar no banco
				if($_POST['senha'])
					$sqlsenha="senha='".sha1($_POST["senha"])."',";
					
				$q="update usuario set nome='".$_POST["nome"]."',$sqlsenha";
				$q=$q."login='".$_POST["login"]."',email='".$_POST["email"]."'";
				$q=$q.",idperfildeuso='".$_POST["idperfildeuso"]."'  where id='$id'";
				echo $q;
				pg_exec($conn,$q);
				$mensagem="Usuario alterado com sucesso";
				$feito="ok";
				$voltar="cadusuario.php";
				$_POST["idusuario"]=="";
			}
			
		}
		
	}
	if($_POST["butdesativarusuario"]){
				if($_POST["butdesativarusuario"]=="Ativar"){
					$mensagem="Usuario ativado com sucesso";
					$q="update usuario set status='HABILITADO' where id='$id'";
				}
				else{
					$q="update usuario set status='DESABILITADO' where id='$id'";
					$mensagem="Usuario desativado com sucesso";
				}

				pg_exec($conn,$q);
				$feito='ok';
				$voltar="cadusuario.php";
				$_POST["idusuario"]=="";

	}
	if (!$feito) include "includes/fcadastrausuario.inc";
	else include "includes/msg.inc";
	exit;
}
elseif(!$_POST["acao"]){
	include "includes/listausuario.inc";
}
?>
