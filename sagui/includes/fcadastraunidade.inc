<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<form name=formincluiunidade method=post action="gerenciaunidade.php?acao=<?echo $_GET["acao"]?>">	

<?
	if($_POST["id"]){
		echo "<input type=hidden name=id value=".$_POST["id"].">";
		echo "<input type=hidden name=mudar value=sim>";
		$result=pg_exec($conn,"select nome,codigoemb from unidade where id='".$_POST["id"]."'");
		$linha=pg_fetch_row($result,0);
		$nome=$linha[0];
		$codigoemb=$linha[1];
		$result=pg_exec($conn,"select ippart from rede where idunidade='".$_POST["id"]."'");
		$lines=pg_numrows($result);
		for($i=0;$i<$lines;$i++){
			$linha=pg_fetch_row($result,$i);
			$redes=$redes.$linha[0]."\n";
		}
		$result=pg_exec($conn,"select idparametro,valor from unidadeparametroslocais where idunidade='".$_POST["id"]."'");
		$lines=pg_numrows($result);
		for($i=0;$i<$lines;$i++){
			$linha=pg_fetch_row($result,$i);
			$val[$linha[0]]=$linha[1];
		}
		
	}
	else{
		$nome=$_POST["nome"];
		$codigoemb=$_POST["codigoemb"];
		$redes=$_POST["redes"];
		$val=$_POST["val"];
		
	}
	
?>
<TABLE align="center" width="60%">
<TR>
    <TD colspan=4 class=warn><?echo $mensagem;?></TD>
</TR>
<TR>
<TD align=center class=td_label>Unidade:</TD>
<TD align=center class=td_label><input type="text" name="nome" value="<?echo $nome?>" size="30"></TD>
<TD align=center class=td_label>Codigo:</TD>
<TD align=center class=td_label><input type="text" name="codigoemb" value="<?echo $codigoemb?>" size="10"></TD>

</TR>
<TR>
    <TD align=center colspan=4 class=td_label>REDES (a parte de rede do endereco IP)</TD>
</TR>
<TR>
    <TD align=center colspan=4 class=td_label>
	<textarea name=redes rows=5 cols=50><?echo $redes?></textarea></TD>
</TR>
<TR>
    <TD align=center colspan=4 class=td_label>PARAMETROS PARA REDE LOCAL</TD>
</TR>
	<?
	$result=pg_exec($conn,"select id,nome,shellvar from parametroslocais");
	$lines=pg_numrows($result);
	for($i=0;$i<$lines;$i++){
		$linha=pg_fetch_row($result,$i);
		echo "<TR>";
		echo "<TD colspan=2 align=right class=td_label>$linha[1]</td>\n";
		echo "<TD colspan=2 align=left class=td_label>\n";
		$idpar=$linha[0];
		echo "<input type=text name=val[$idpar] value=$val[$idpar]></td>\n";
		echo "</TR>";
	}	
	?>

<TR><TD colspan=4 align=center class=td_label>
<input type="submit" name="butadcionar" value="Adcionar">
</TD>
</tr>
</TABLE>
</form>
</BODY>
</HTML>
