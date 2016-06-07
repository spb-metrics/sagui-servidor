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
beginhtml();
if($_GET["acao"]=="adcionarunidade"){
	if($_POST["butadcionar"]){
		//checa se algum campo estatico esta vazio
		foreach($_POST as $i => $valor){
			if(!$valor){
				$mensagem="Preencha todos os campos $i";
				$incompleto="sim";
			}
		}
		//checa se algum campo dinamico esta vazio		
		foreach($_POST["val"] as $i => $valor){
			if(!$valor){
				$mensagem="Preencha todos os campos $i";
				$incompleto="sim";
			}		
		}
		//checa se alguma rede ja pertenca a outra unidade
		if($_POST["mudar"]) {
			$andu=" and id<>'".$_POST["id"]."'";
			$ande=" and r.idunidade<>'".$_POST["id"]."'";
		}
		$rede = strtok($_POST["redes"]," \n\t");
		while ($rede) {
			$result=pg_exec($conn,"select u.nome from unidade u, rede r where r.ippart='".trim($rede)."' and u.id=r.idunidade $ande");
			$lines=pg_numrows($result);
			if($lines!=0){
				$linha=pg_fetch_row($result,0);
				$mensagem="A rede $rede ja perternce unidade $linha[0],operacao abortada!";
				$incompleto="sim";
				break;
			}
			$rede = strtok(" \n\t");
		}				
		//checa se ja existe outra unidade com este nome
		$result=pg_exec($conn,"select id from unidade where nome='".$_POST['nome']."' $andu");
		$lines=pg_numrows($result);
		if($lines!=0){
			$linha=pg_fetch_row($result,0);
			$mensagem="Já existe uma Unidade com esse nome,inclusão abortada";
		}else{
			if(!$incompleto){
				pg_exec($conn,"BEGIN");
				if($_POST["mudar"]) {
					$id=$_POST["id"];
					pg_exec($conn,"update unidade set nome='".$_POST["nome"]."',codigoemb='".$_POST["codigoemb"]."' where id='$id'");
					pg_exec($conn,"delete from unidadeparametroslocais where idunidade='$id'");
					pg_exec($conn,"delete from rede where idunidade='$id'");
				}
				else{
					$result=pg_exec($conn,"select nextval('unidade_id_seq')");
					$linha=pg_fetch_row($result,0);
					$id=$linha[0];
					$cols=array("id"=>$id,"nome"=>$_POST['nome'],"codigoemb"=>$_POST["codigoemb"]);
					incluinatabela("unidade",$cols);

				}
				$rede = strtok($_POST["redes"]," \n\t");
				while ($rede) {
					$cols=array("idunidade"=>$id,"ippart"=>trim($rede));
					incluinatabela("rede",$cols);
   					$rede = strtok(" \n\t");
				}				
				foreach($_POST["val"] as $i => $valor){
					$cols=array("idunidade"=>$id,"idparametro"=>$i,"valor"=>$valor);
					incluinatabela("unidadeparametroslocais",$cols);			
				}
				pg_exec($conn,"COMMIT");
				$mensagem="Unidade Cadastrada com sucesso";
				$feito="ok";
				$voltar="gerenciaunidade.php";

			}
		}

	}
	if (!$feito) include "includes/fcadastraunidade.inc";
	else include "includes/msg.inc";
}

elseif($_GET["acao"]=="verunidade"){
	if (!$feito) include "includes/mostraunidade.inc";
}
else{
	$colunas=array("Unidade","Sigla");
	geralistavisao("Lista de Unidades",$colunas,"unidade","id","gerenciaunidade.php?acao=verunidade","");

}
endhtml();
?>
