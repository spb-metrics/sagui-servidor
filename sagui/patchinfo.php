<?
/*
SERPRO - Serviço Federal de Processamento de Dados, Brasil

Este arquivo é parte do programa SAGÜI -Sistema de Apoio à Gerência Unificada de Informações

O SAGÜI é um software livre; você pode redistribui-lo e/ou modifica-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença, ou (na sua opnião) qualquer versão.

Este programa é distribuido na esperança que possa ser util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "LICENCA.txt", junto com este programa, se não, escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

 

//ESTE ARQUIVO DEVE SUBSTITUIR O ATUAL DOWNPATCH.PHP
include "includes/functions.php";
connect();
if (! $_GET["homologa"] | $_GET["homologa"]!="yes" ) $status="and s.status='LIBERADO'";
if(! $_GET["ip"]) $_GET["ip"] = $_SERVER['REMOTE_ADDR'];
if($_GET["perfil"]){
	$query="select pt.sequencial from patchperfil pp,perfil p,patch pt,patchunidade pu,scriptpatch s ";
	$query=$query."where p.id=pp.idperfil and pp.idpatch=pt.id and ";
	$query=$query."pt.id=pu.idpatch and pu.idunidade='-1' and ";
	$query=$query."p.nome='".$_GET["perfil"]."' and pt.idscript=s.id ";
	$query=$query." $status order by sequencial";
	$result=pg_exec($conn,$query);
	$lines=pg_numrows($result);
	if ($lines==0){
		echo "echo \"Perfil nao cadastrado\"\n";
		echo "exit 1\n";
		exit;
	}
	for($i=0;$i<$lines;$i++){
		$linha=pg_fetch_row($result,$i);
		$NACIONAIS=$NACIONAIS."$linha[0] ";
	}
	echo "export NACIONAIS=\"".trim($NACIONAIS)."\"\n";
	$ip=$_GET["ip"];
	
	
	$idunidade=unidade($ip);
	//checar se a unidade existe se nao alarme.
	$REGIONAL=nomeunidade($idunidade);
	$query="select pt.sequencial from patchperfil pp,perfil p,patch pt,patchunidade pu,scriptpatch s ";
	$query=$query."where p.id=pp.idperfil and pp.idpatch=pt.id and ";
	$query=$query."pt.id=pu.idpatch and pu.idunidade='$idunidade' and ";
	$query=$query."p.nome='".$_GET["perfil"]."' and pt.idscript=s.id ";
	$query=$query."$status order by sequencial";
	$result=pg_exec($conn,$query);
	$lines=pg_numrows($result);
	for($i=0;$i<$lines;$i++){
		$linha=pg_fetch_row($result,$i);
		$REGIONAIS=$REGIONAIS."$linha[0] ";
	}
	echo "export REGIONAL=\"".trim($REGIONAL)."\"\n";
	echo "export REGIONAIS=\"".trim($REGIONAIS)."\"\n";
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//automatizar a determinação do servidor sagui
	echo "export SAGUISERVER=10.200.105.236\n";
//automatizar a determinação do client patch
	echo "export CLIENT=\"links --dump --source \"\n";
}
elseif($_GET["sequencial"]){
	$query="select v.conteudo,v.versao,p.msg,p.titulo,s.nome,v.status,s.id from patch p,scriptpatch s,versaoscriptpatch v ";
	$query=$query."where p.idscript=s.id and s.id=v.idscript $status ";
	$query=$query." and v.status=s.status and p.sequencial='".$_GET["sequencial"]."' order by versao desc";
	$result=pg_exec($conn,$query);
	$lines=pg_numrows($result);
	if($lines==0) echo "echo -n \"patch desativado ou inexistente\";exit 1\n";
	else{
		$linha=pg_fetch_row($result,0);
		if($_GET["info"]){
			echo "#PATCH-SEQ:".$_GET["sequencial"]."\n#TITULO:$linha[3]";
			echo "\n#SCRIPT:$linha[4]\n#VERSAO:$linha[1] #STATUS:$linha[5]\n#--SCRIPT-LIST----\n";
			echo utf8_decode($linha[0]);
		}else{
			echo ". /etc/sysconfig/sagui-clients\n";
			echo ". \$SAGUIDIR/sagui_functions\n";
			echo "IDSCRIPT=$linha[6]\n";
			echo "echo -n \"--> seq id ".$_GET["sequencial"].":$linha[2]\"\n";
			echo "exec &> /tmp/patch.tmp.log\n";
			echo utf8_decode($linha[0]);
			echo "\ncat /tmp/patch.tmp.log >> \$SAGUILOG\n";

		}
	}

}
?>
