<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<form name=cadastramenu method=post action=gerenciarcoleta.php?acao=<?echo $_GET["acao"];?>>
<?
if($_POST["atributo"] && !$feito){
	$q="select s.id,s.nome from scriptpatch s,atributo a where s.id=a.idscript and a.id='".$_POST["atributo"]."'";
	$result=pg_exec($conn,$q);
	$lines=pg_numrows($result);
	$a=array();
	for($i=0;$i<$lines;$i++){
		$linha=pg_fetch_row($result,$i);
		$b=array($i => $linha[0]);
		$a=$a+$b;
	}
	$perfisdeuso=$a;
	$result=pg_exec($conn,"select id,nome,obs from atributo where id='".$_POST["atributo"]."'");	
	$lines=pg_numrows($result);
	$linha=pg_fetch_row($result,0);
	$nome=$linha[1];
	$obs=$linha[2];
	echo "<input type=hidden name=atributo value=".$_POST["atributo"].">";
}
else{
	$nome=$_POST["nome"];
	$obs=$_POST["obs"];
}
?>
<TABLE align="center" width="70%">
<TR>
    <TD colspan=4 class=warn><?echo $mensagem;?></TD>
</TR>

<tr>
    <TD colspan=1 align=right class=td_label width=50%>
	Script de coleta:
	</td>
	<TD colspan=3 align=left class=td_label width=50%>
	<select name=scriptcoleta>
	<option value="">Escolha um script</option>
	
<?

$result=pg_exec($conn,"select id,nome from scriptpatch where tipo='COLETA' order by id");
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);		
	$selected='';
	if(in_array($linha[0],$perfisdeuso))	$selected='selected';
	echo "<option value=\"$linha[0]\" $selected>$linha[1]</option>\n";
}
?>
	</select>

	</TD>
</TR>
<TR>
    <TD class=td_label align=right  colspan=1>Nome:</TD>
    <TD class=td_label colspan=3><input type=text name=nome value="<?echo $nome;?>" size=50></TD>
</TR>
    <TD class=td_label align=right colspan=1>Observa&ccedil;&atilde;o:</TD>
    <TD class=td_label colspan=3><textarea name=obs rows=4 cols=50><?echo $obs;?></textarea></TD>
</TR>
<TR>
    <TD class=td_label align=right align=center colspan=4>
    <input type=submit name=butincluircoleta value=Incluir size=50></TD>
</TR>
</table>
</form>
</body>
</html>
