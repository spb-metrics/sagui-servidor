<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<?
	
	if($_POST["id"]){
		$result=pg_exec($conn,"select nome,codigoemb from unidade where id='".$_POST["id"]."'");
		$linha=pg_fetch_row($result,0);
		$nome=$linha[0];
		$codigoemb=$linha[1];
		$result=pg_exec($conn,"select ippart from rede where idunidade='".$_POST["id"]."'");
		$lines=pg_numrows($result);
		for($i=0;$i<$lines;$i++){
			$linha=pg_fetch_row($result,$i);
			$redes=$redes.$linha[0]."<BR>";
		}
		$result=pg_exec($conn,"select idparametro,valor from unidadeparametroslocais where idunidade='".$_POST["id"]."'");
		$lines=pg_numrows($result);
		for($i=0;$i<$lines;$i++){
			$linha=pg_fetch_row($result,$i);
			$val[$linha[0]]=$linha[1];
		}
		
	}
	
?>
<form name=formmostraunidade method=post action="gerenciaunidade.php?acao=adcionarunidade">
<input type=hidden name=id value=<?echo $_POST["id"]?>>
<TABLE align="center" width="60%">
<TR>
    <TD colspan=4 class=warn><?echo $mensagem;?></TD>
</TR>
<TR>
<TD align=center class=td_label>Unidade:</TD>
<TD align=center class=td_info><?echo $nome?></TD>
<TD align=center class=td_label>Codigo:</TD>
<TD align=center class=td_info><?echo $codigoemb?></TD>

</TR>
<TR>
    <TD align=center colspan=4 class=td_label>REDES (a parte de rede do endereco IP)</TD>
</TR>
<TR>
    <TD align=center colspan=4 class=td_info>
	<?echo $redes?></TD>
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
		$idpar=$linha[0];
		echo "<TD colspan=2 align=left class=td_info>$val[$idpar]</td>\n";
		echo "</TR>";
	}	
	?>

<TR>
<TD colspan=4 align=center class=td_label>
<input type="submit" name="butmudar" value="Modificar">
</TD>
</tr>
</TABLE>
</form>
</BODY>
</HTML>
