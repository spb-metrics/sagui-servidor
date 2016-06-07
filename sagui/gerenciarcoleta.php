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
if($_GET["acao"]=="criarcoleta"){
	if($_POST["butincluircoleta"]){
		foreach($_POST as $i => $valor){
			if(!$valor){
				$mensagem="Preencha todos os campos";
				$incompleto="sim";
			}
		}
		if( !($_POST["scriptcoleta"])) {
			$mensagem="Preencha todos os campos";
			$incompleto="sim";		
		}		
		if(!$incompleto){
			if($_POST["atributo"]){
				$q="update atributo set nome='".$_POST["nome"]."',obs='".$_POST["obs"]."'";
				$q=$q.",idscript='".$_POST["scriptcoleta"]."' where id='".$_POST["atributo"]."'";
				pg_exec($conn,$q);
				$mensagem="Atributo Alterado com sucesso";
				$feito="ok";
			}
			else{
				$query="insert into atributo(nome,obs,idscript) values ";
				$query=$query."('".$_POST["nome"]."','".$_POST["obs"]."','".$_POST["scriptcoleta"]."')";
				pg_exec($conn,$query);
				$mensagem="Atributo incluido com sucesso";
				$feito="ok";
			}
			
			$_POST["nome"]="";
			$_POST["obs"]="";
		}
	}
	
	include "includes/fcadastracoleta.inc";
}
elseif(!$_POST["atributo"]){
$colunas=array("Informacao","Script","Status");
geralistavisao("Lista de dados a coletar",$colunas,"vw_lista_atributos","atributo","gerenciarcoleta.php?acao=criarcoleta",$where);
}
else include "includes/mostrapatch.inc";
?>
</body>
</HTML>
