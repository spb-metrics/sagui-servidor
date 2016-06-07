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
$voltar="cadmenu.php?acao=operar";
connect();
if($_GET["acao"]=="criarmenu"){
	if($_POST["butincluirmenu"]){ 
		foreach($_POST as $i => $valor){
			if(!$valor){
				$mensagem="Preencha todos os campos";
				$incompleto="sim";
			}
		}
		if(!$incompleto){
			if($_POST['tipo'] == 'submenu'){
				$q="insert into submenu (nome,descricao,href) values ";
				$q=$q."('".$_POST["nome"]."','".$_POST["desc"]."','".$_POST["href"]."')";
				pg_exec($conn,$q);
				$mensagem="Submenu incluido com sucesso";
				$feito="ok";
			}
			elseif($_POST['tipo'] == 'menu'){
				pg_exec($conn,"BEGIN");			
				$result=pg_exec($conn,"select nextval('menu_id_seq')");
				$linha=pg_fetch_row($result,0);
				$id=$linha[0];
				$q="insert into menu (id,nome,descricao,href,target) values ";
				$q=$q."('$id','".$_POST["nome"]."','".$_POST["desc"]."','".$_POST["href"]."','".$_POST["target"]."')";
				pg_exec($conn,$q);
				if($_POST["submenus"])
					foreach($_POST["submenus"] as $i => $valor){
						pg_exec($conn,"insert into menusubmenu (idmenu,idsubmenu) values ('$id','$valor')");
					}
				if($_POST["perfisdeuso"])
					foreach($_POST["perfisdeuso"] as $i => $valor){
						pg_exec($conn,"insert into perfildeusomenu (idmenu,idperfildeuso) values ('$id','$valor')");
					}
				pg_exec($conn,"COMMIT");			
				$mensagem="Menu incluido com sucesso";
				$feito="ok";
			}
		}
	}
	if (!$feito) include "includes/fcadastramenu.inc";
	else include "includes/msg.inc";
}
elseif($_GET["acao"]=="operar"){

	if($_POST["butincluirmenu"]){ 
		foreach($_POST as $i => $valor){
			if(!$valor){
				$mensagem="Preencha todos os campos";
				$incompleto="sim";
			}
		}
		if(!$incompleto){
			$id=$_POST["menu"];
			if($_POST['tipo'] == 'submenu'){
				$q="update submenu set nome='".$_POST["nome"]."',descricao='".$_POST["desc"]."',";
				$q=$q."href='".$_POST["href"]."' where id='$id'";
				pg_exec($conn,$q);
				$mensagem="Submenu Alterado com sucesso";
				$feito="ok";
			}
			elseif($_POST['tipo'] == 'menu'){
				pg_exec($conn,"BEGIN");
				pg_exec($conn,"delete from menusubmenu where idmenu='$id'");
				pg_exec($conn,"delete from perfildeusomenu where idmenu='$id'");
				$q="update menu set nome='".$_POST["nome"]."',descricao='".$_POST["desc"]."',";
				$q=$q."target='".$_POST["target"]."',href='".$_POST["href"]."' where id='$id'";
				pg_exec($conn,$q);
				if($_POST["submenus"])
					foreach($_POST["submenus"] as $i => $valor){
						pg_exec($conn,"insert into menusubmenu (idmenu,idsubmenu) values ('$id','$valor')");
					}
				if($_POST["perfisdeuso"])
					foreach($_POST["perfisdeuso"] as $i => $valor){
						pg_exec($conn,"insert into perfildeusomenu (idmenu,idperfildeuso) values ('$id','$valor')");
					}				
				pg_exec($conn,"COMMIT");
				$mensagem="Menu Alterado com sucesso";
				$feito="ok";
				
			}		
			$voltar="cadmenu.php?acao=operar";

		}
	}
	if(!$_POST["menu"]) include "includes/listamenu.inc";
	elseif($_POST["menu"] && !$_POST["butok"] && !$feito) include "includes/mostramenu.inc";
	elseif (!$feito && $_POST["menu"]) include "includes/fcadastramenu.inc";
	elseif($feito) include "includes/msg.inc";
}
elseif($_GET["acao"]=="remover"){
	if($_POST['tipo'] == 'submenu'){
		pg_exec($conn,"delete from submenu where id='".$_POST['menu']."'");
		$mensagem="Submenu removido com sucesso";
		$feito="ok";
	}
	elseif($_POST['tipo'] == 'menu'){
		pg_exec($conn,"delete from menu where id='".$_POST['menu']."'");
		$mensagem="Menu removido com sucesso";
		$feito="ok";
	}
	if ($feito)  include "includes/msg.inc";
}
?>
