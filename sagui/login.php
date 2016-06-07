<?
/*
SERPRO - Serviço Federal de Processamento de Dados, Brasil

Este arquivo é parte do programa SAGÜI -Sistema de Apoio à Gerência Unificada de Informações

O SAGÜI é um software livre; você pode redistribui-lo e/ou modifica-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença, ou (na sua opnião) qualquer versão.

Este programa é distribuido na esperança que possa ser util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "LICENCA.txt", junto com este programa, se não, escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
 
<?session_start();?>
<HTML><HEAD><TITLE>.:SAGUI:.</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<?

include "includes/functions.php";
connect();

if($_POST['login'] && $_POST['senha']){
	$result=pg_exec($conn,"select id,login,nome,senha,idperfildeuso from usuario where login='".$_POST['login']."' and status='HABILITADO'");
	$lines=pg_numrows($result);
	if($lines>0){
		$linha=pg_fetch_row($result,0);
		$_SESSION['uid']=$linha[0];
		$_SESSION['login']=$linha[1];		
		$_SESSION['nome']=$linha[2];
		$_SESSION['perfildeuso']=$linha[4];
		if($linha[3] != sha1($_POST["senha"])){
			mensagem('Login Incorreto');
			sair();
		}
	}
	else{
		mensagem('Login Incorreto');
		sair();
	}
}
else {
	sair();
	mensagem('Login Incorreto');
}

?>
<FRAMESET border=1 frameSpacing=4 rows=100,* frameBorder=0>
<FRAME name=top src="top.php" scrolling=no>
<FRAME name=main  src="main.html"><NOFRAMES>
<BODY>
</BODY>
</NOFRAMES></FRAMESET>
</HTML>
