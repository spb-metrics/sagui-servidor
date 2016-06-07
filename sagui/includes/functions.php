<?
$max_script_size=16024;
$max_pkt_size=200000000;
$httpclient="links --source ";
//$server="10.200.105.236";

function connect(){
        global $conn;
        if(! $conn = pg_connect("dbname=sagui")){
                mensagem("Conexão Falhou!!",2,"center");
                return 0;
        }
        return 1;

}
function mensagem($msg){
	echo "<script language=\"javascript\">alert(\"$msg\")</script>"; 
	return(1);
}
function incluinatabela($tabela,$colunas){
	global $conn;
	foreach($colunas as $i => $valor){
		$campos=$campos.",".$i;
		$valores=$valores.",'".$valor."'";
	}
	$query="insert into $tabela (".substr($campos,1).") values (".substr($valores,1).")";
	if (pg_exec($conn,$query))
		return 1;
	
	else
		return 0;
}
function sair(){
	echo "<script language=\"javascript\">window.parent.location=\"index.html\"</script>";
///	echo "<script language=\"javascript\">window.history.back();</script>";
}
function geralistavisao($titulo,$colunas,$visao,$chave,$post,$where){
        global $conn;
        echo "<form name=formalista method=post action=$post>\n";
        echo "<TABLE align=center width=80%><TR>\n";
        echo "<TD class=td_label align=center >$titulo</TD></TR></table>\n";

        echo "<TABLE align=center width=80%><TR>\n";
        if($chave)
        echo "<TD class=td_label align=center ></TD>\n";
        foreach($colunas as $i => $valor){
                echo "<TD class=td_label align=center>$valor</TD>\n";
        }
        echo "</TR>\n";
        $result=pg_exec($conn,"select * from $visao $where ");
        $lines=pg_numrows($result);
        for($i=0;$i<$lines;$i++){
                $linha=pg_fetch_row($result,$i);
                echo "<TR>";

                if($linha[0]=="-1") continue;//Inibe a exibição de TODAS(ID=-1) para a lista de unidades
                foreach($linha as $j => $valor){
                        if($j=="0"){
                                if(!$chave) continue;
                                echo "<TD class=td_label align=center width=5%>\n";
                                echo "<input type=image src=imagens/info.png name=$chave value=$linha[0] onclick=\"submit()\"></TD>\n";
                        }
                        else echo "<TD class=td_label align=center>$valor</TD>\n";
                }
                echo "</TR>";
        }
        echo "</TABLE></form>";
}
function geralistavisao2($titulo,$colunas,$visao,$chave,$post,$where,$limit,$offset){
        global $conn;
        echo "<form name=formalista method=post action=$post>\n";
        echo "<TABLE align=center width=80%><TR>\n";
        echo "<TD class=td_label align=center >$titulo</TD></TR></table>\n";

        echo "<TABLE align=center width=80%><TR>\n";
        if($chave)
        echo "<TD class=td_label align=center ></TD>\n";
        foreach($colunas as $i => $valor){
                echo "<TD class=td_label align=center>$valor</TD>\n";
        }
        echo "</TR>\n";
        $result=pg_exec($conn,"select * from $visao $where limit $limit offset $offset");
        $lines=pg_numrows($result);
        for($i=0;$i<$lines;$i++){
                $linha=pg_fetch_row($result,$i);
                echo "<TR>";

                if($linha[0]=="-1") continue;//Inibe a exibição de TODAS(ID=-1) para a lista de unidades
                foreach($linha as $j => $valor){
                        if($j=="0"){
                                if(!$chave) continue;
                                echo "<TD class=td_label align=center width=5%>\n";
                                echo "<input type=image src=imagens/info.png name=$chave value=$linha[0] onclick=\"submit()\"></TD>\n";
                        }
                        else echo "<TD class=td_label align=center>$valor</TD>\n";
                }
                echo "</TR>";
        }
	echo "</TABLE>";
	echo "<table align=center>\n";
	echo "<TR><TD class=td_label align=right><input type=submit value=\"<<\"</a></td>\n";
	echo "<TD class=td_label align=left><input type=submit value=\">>\"></a></td></tr></table>\n";

        echo "</form>";
}
function geralistamulti($titulo,$colunas,$visao,$chave,$post,$where){
	global $conn;
	echo "<form name=formalista method=post action=$post>\n";
	echo "<TABLE align=center width=80%><TR>\n";
	echo "<TD class=td_label align=center >$titulo</TD></TR></table>\n";	
	
	echo "<TABLE align=center width=80%><TR>\n";
	if($chave)
	echo "<TD class=td_label align=center ></TD>\n";	
	foreach($colunas as $i => $valor){
		echo "<TD class=td_label align=center>$valor</TD>\n";
	}
	echo "</TR>\n";
	//echo "select * from $visao $where";
	$result=pg_exec($conn,"select * from $visao $where ");
	$lines=pg_numrows($result);
	for($i=0;$i<$lines;$i++){
		$linha=pg_fetch_row($result,$i);
		echo "<TR>";
		
		if($linha[0]=="-1") continue;//Inibe a exibição de TODAS(ID=-1) para a lista de unidades
		foreach($linha as $j => $valor){
			if($j=="0"){
				if(!$chave) continue;
				echo "<TD class=td_label align=center width=5%>\n";
				echo "<input type=checkbox name=$chave"."["."$i"."]"." value=$linha[0]></TD>\n";
			}
			else echo "<TD class=td_label align=center>$valor</TD>\n";
		}
		echo "</TR>";
	}
	echo "</TABLE>\n";
	if($chave){
		echo "<TABLE align=center width=80%><TR>\n";
		echo "<TD class=td_label align=center><input type=submit name=butmulti value=OK></td></tr></table>\n";
	}
	echo "</form>";
}
function unidade($ip){
	global $conn;
	$poct=strtok($ip, ".");
	$soct=strtok(".");
	$toct=strtok(".");
	$busca="$poct"."."."$soct"."."."$toct";
	$result=pg_exec($conn,"select idunidade from rede where ippart='$busca'");
	$lines=pg_num_rows($result);
	if($lines==0){
		$busca="$poct"."."."$soct";
		$result=pg_exec($conn,"select idunidade from rede where ippart='$busca'");
		$lines=pg_num_rows($result);
	}
	if($lines==1){
		$linha = pg_fetch_row($result,0);
		return($linha[0]);
	}
	return(0);
}
function nomeunidade($id){
	global $conn;
	$result=pg_exec($conn,"select nome from unidade where id='$id'");
	$linha = pg_fetch_row($result,0);
	return($linha[0]);
}
function beginhtml(){
	echo "<HTML><HEAD><TITLE>.:SAGUI:.</TITLE><LINK href=\"default.css\" type=text/css rel=StyleSheet></HEAD><BODY>";
}
function endhtml(){
	echo "</BODY><HTML>";
}
?>
