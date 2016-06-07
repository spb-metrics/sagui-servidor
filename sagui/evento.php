<?
/*
SERPRO - Serviço Federal de Processamento de Dados, Brasil

Este arquivo é parte do programa SAGÜI -Sistema de Apoio à Gerência Unificada de Informações

O SAGÜI é um software livre; você pode redistribui-lo e/ou modifica-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença, ou (na sua opnião) qualquer versão.

Este programa é distribuido na esperança que possa ser util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "LICENCA.txt", junto com este programa, se não, escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

 

include "includes/functions.php";
connect();
if($_GET["chave"]){
	$chave=$_GET["chave"];
	$STATUS=$_GET["status"];
	$idscript=$_GET["idscript"];
	$saida=$_GET["saida"];
	$tipoevento=$_GET["tipoevento"];
	if(!$tipoevento){
		$tipoevento=0;
	}
	$q="insert into evento (idequipamento,idtipoevento,status,saida,idscript)";
	$q=$q. " values ('$chave','$tipoevento','$STATUS','$saida','$idscript')";
	$result=pg_exec($conn,$q);

//ENVIO DO LOG PARA O SYSLOG solicitacao da GS.

	if ( ($tipoevento == 2) && ($STATUS != 0) ){
		define_syslog_variables();
		openlog("SAGUI", LOG_PID | LOG_PERROR, LOG_LOCAL0);
		$access = date("Y/m/d H:i:s");
	   	syslog(LOG_WARNING, "$chave | $access | {$_SERVER['REMOTE_HOST']} | {$_SERVER['REMOTE_ADDR']} | $saida ");
		//ID|DATAHORA|NOMEHOST|IPHOST|MENSAGEM
	}


}
?>
