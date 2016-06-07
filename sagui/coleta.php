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

$ip = $_SERVER['REMOTE_ADDR'];
$idunidade=unidade($ip);
if(! $_GET){
	$query="select a.nome,s.nome,a.id from atributo a,scriptpatch s where a.idscript=s.id and s.status='LIBERADO'";
	$result=pg_exec($conn,$query);
	$lines=pg_num_rows($result);
	$get="";
	for($i=0;$i<$lines;$i++){
		$linha = pg_fetch_row($result,$i);
		echo "$linha[0]=`\$CLIENT \"http://\$SAGUISERVER/sagui/arquivos.php?arquivo=$linha[1]\" | dos2unix | sh`\n";
		$get=$get."$linha[2]=\$$linha[0]&";
	}
	echo  "\$CLIENT http://\$SAGUISERVER/sagui/coleta.php?\"$get"."chave=\$CHAVE\"";
}
elseif($_GET["chave"]){
	$chave=$_GET["chave"];
	foreach($_GET as $i => $valor){
		if($i=="chave") continue;
		if(!$valor) $valor="FALHOU";
		//$result=pg_exec($conn,$query);		
		$cols=array("idequipamento"=>$chave,"idatributo"=>$i,"value"=>$valor);
		if(! incluinatabela("coleta",$cols)){
			//Na coleta o id do script que coleta o mac DEVE SER SEMPRE 3
			$cols2=array("id"=>$chave,"ip"=>$ip,"mac"=>$_GET["3"],"idunidade"=>$idunidade);
			incluinatabela("equipamento",$cols2);
			incluinatabela("coleta",$cols);
		}
		
	}
	//registra o acesso do equipamento
	$cols=array("idequipamento"=>$chave);
	incluinatabela("ligou",$cols);
}
elseif($_GET["acao"]=="getchave" && $_GET["mac"] ){
	$mac=$_GET["mac"];
	$result=pg_exec($conn,"select id,ip from equipamento where mac='$mac'");
	$lines=pg_numrows($result);
	if($lines==1){
		
		$linha=pg_fetch_row($result,0);
		if($linha[1]!=$ip){
			pg_exec($conn,"update equipamento set ip='$ip',idunidade='$idunidade' where  mac='$mac'");
		}
		//ALARM
		echo "echo $linha[0]\n";
		//Se for diferente:?
	}
	elseif($lines==0){
		$result=pg_exec($conn,"select nextval('equipamento_id_seq')");
		$linha=pg_fetch_row($result,0);
	
		if(!$idunidade){
			exit;
		}
		$cols=array("id"=>$linha[0],"ip"=>$ip,"mac"=>$mac,"idunidade"=>$idunidade);
		incluinatabela("equipamento",$cols);
		echo "echo $linha[0]\n";
	}
	//ALARM
	//se tiver mais de uma chave associada ao MAC?
}

?>
