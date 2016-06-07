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
if($_POST["butalterarsenha"]){ 
	foreach($_POST as $i => $valor){
		if(!$valor){
			$mensagem="Preencha todos os campos";
			$incompleto="sim";
		}
	}
	if(!$incompleto){
		$result=pg_exec($conn,"select senha from usuario where login='".$_SESSION["login"]."'");
		$linha=pg_fetch_row($result,0);
		if($linha[0]!=sha1($_POST["senhaatual"])){
			$mensagem="Senha atual não confere";
		}elseif($_POST["senha"]!=$_POST["csenha"]){
			$mensagem="Senhas nao conferem";
		}
		else{	
			$q="update usuario set senha='".sha1($_POST["senha"])."' where login='".$_SESSION["login"]."'";
			pg_exec($conn,$q);
			$mensagem="Senha alterada com sucesso";
			include "includes/msg.inc";
			exit;
		}
	}
}
?>
<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<form name=cadastrausuario method=post action=senha.php>
<TABLE align="center" width="70%">
<TR>
    <TD colspan=4 class=warn><?echo $mensagem;?></TD>
</TR>
<TR>
    <TD class=td_label align=right  colspan=1>Senha Atual:</TD>
    <TD class=td_label colspan=3><input type=password name=senhaatual size=50></TD>
</TR>		
<TR>
    <TD class=td_label align=right  colspan=1>Nova Senha:</TD>
    <TD class=td_label colspan=3><input type=password name=senha size=50></TD>
</TR>		
<TR>
    <TD class=td_label align=right  colspan=1>Confirma:</TD>
    <TD class=td_label colspan=3><input type=password name=csenha size=50></TD>
</TR>			
<TR>
    <TD class=td_label align=right align=center colspan=4>
    <input type=submit name=butalterarsenha value=Incluir size=50>
</TD>
</TR>
</table>
</form>
</body>
</html>
