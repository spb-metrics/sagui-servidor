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

if($_GET["acao"]=="cadastrarperfildeuso"){

	if(!$_POST["descricao"]){
			$mensagem="Preencha o campo";
			$incompleto="sim";
	}
	//Fornecido pela fcadastrarperfildeuso
	if(($_POST["butperfildeuso"]=="Incluir") && !$incompleto){
		
		$q = "select id from perfildeuso where descricao='".$_POST['descricao']."'";
		$result=pg_exec($conn,$q);
		$lines=pg_numrows($result);
		if($lines!=0){
			$linha=pg_fetch_row($result,0);
			$mensagem="Já existe uma cotegoria com esse nome, inclusão abortada";
		}
		else {
			//Inserir no banco as informa��es do perfil de uso
			$q="insert into perfildeuso (descricao) values ";
			$q=$q."('".$_POST["descricao"]."')";
			pg_exec($conn,$q);
			$mensagem="Perfil de uso incluido com sucesso";
			$feito="ok";
			$voltar="cadperfildeuso.php?acao=cadastrarperfildeuso";
		}
	}

	else if (($_POST["butperfildeuso"]=="Deletar")&& !$incompleto) {

		$q = "select id from perfildeuso where descricao='".$_POST['descricao']."'";
		$result=pg_exec($conn,$q);
		$lines=pg_numrows($result);
		if($lines!=0){
			$linha=pg_fetch_row($result,0);
			pg_exec($conn,"delete from perfildeuso where id='".$_POST["id"]."'");
			$mensagem="Perfil de uso excluido com sucesso";
			$feito="ok";
			$voltar="cadperfildeuso.php?acao=cadastrarperfildeuso";
		}
		else
			$mensagem="Não existe uma cotegoria com esse nome, exclusão abortada";
	}

	if (!$feito) include "includes/fcadastrarperfildeuso.inc";
	//Imprime alguma mensagem gerada com um link de retorno
	else include "includes/msg.inc";
	exit;
}
else{
		include "includes/fcadastrarperfildeuso.inc";
}
?>