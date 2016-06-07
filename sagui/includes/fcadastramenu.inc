<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<form name=cadastramenu method=post action=cadmenu.php?acao=<?echo $_GET["acao"];?>>
<? if(! $_POST['tipo'] ){ ?>
<TABLE align="center" width="70%">
<TR>
<TD colspan=2 align=center class=td_label><input type=radio name=tipo value=menu onclick=submit()>Criar menu</TD>
<TD colspan=2 align=center class=td_label><input type=radio name=tipo value=submenu onclick=submit()>Criar submenu</TD>
</TR>
</table>
</BODY>
</html>
<?exit;}?>
<input type=hidden name=tipo value=<?echo $_POST["tipo"]?>>
<?

if($_POST["menu"] && !$feito){
	$result=pg_exec($conn,"select idsubmenu from menusubmenu where idmenu='".$_POST["menu"]."'");
	$lines=pg_numrows($result);
	$a=array();
	for($i=0;$i<$lines;$i++){
		$linha=pg_fetch_row($result,$i);
		$b=array($i => $linha[0]);
		$a=$a+$b;
	}
	$submenus=$a;
	$result=pg_exec($conn,"select idperfildeuso from perfildeusomenu where idmenu='".$_POST["menu"]."'");
	$lines=pg_numrows($result);
	$a=array();
	for($i=0;$i<$lines;$i++){
		$linha=pg_fetch_row($result,$i);
		$b=array($i => $linha[0]);
		$a=$a+$b;
	}
	$perfisdeuso=$a;
	if($_POST['tipo']=="menu")
		$result=pg_exec($conn,"select id,nome,descricao,href,target from menu where id='".$_POST["menu"]."'");
	else
		$result=pg_exec($conn,"select id,nome,descricao,href,target from submenu where id='".$_POST["menu"]."'");
	$lines=pg_numrows($result);
	$linha=pg_fetch_row($result,0);
	$nome=$linha[1];
	$desc=$linha[2];
	$href=$linha[3];
	$target=$linha[4];
	echo "<input type=hidden name=menu value=".$_POST["menu"].">";
}
else{
	$nome=$_POST["nome"];
	$desc=$_POST["desc"];
	$href=$_POST["href"];
	$target=$_POST['target'];
	$msg=$_POST['msg'];
}
?>
<TABLE align="center" width="70%">
<TR>
    <TD colspan=4 class=warn><?echo $mensagem;?></TD>
</TR>
<? if($_POST['tipo']=="menu"){?>
<TR>
    <TD  colspan=4 align=center class=td_label width=50%>
	Escolha os Submenus Associados as este menu:<BR>
	<select name=submenus[] multiple  size=6>
<?
$result=pg_exec($conn,"select id,nome,descricao from submenu");
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);
	$selected='';
	if(in_array($linha[0],$submenus))  $selected='selected';	
	echo "<option value=\"$linha[0]\" $selected>$linha[1] - $linha[2]</option>\n";
}
?>
	</select>
	</TD>
</tr>
<tr>
    <TD colspan=6 align=center class=td_label width=50%>
	Escolha os Perfis de uso associados a este menu:<BR>
	<select name=perfisdeuso[] multiple  size=6>
	
<?

$result=pg_exec($conn,"select id,descricao from perfildeuso order by id");
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
    <TD class=td_label align=right colspan=1>Descri&ccedil;&atilde;o:</TD>
    <TD class=td_label colspan=3><textarea name=desc rows=4 cols=50><?echo $desc;?></textarea></TD>
</TR>
<TR>
    <TD class=td_label align=right  colspan=1>target:</TD>
    <TD class=td_label colspan=3><input type=text name=target value="<?echo $target;?>" size=50></TD>
</TR>

<?} // if menu
else{
?>	
<TR>
    <TD class=td_label align=right colspan=1>Descri&ccedil;&atilde;o:</TD>
    <TD class=td_label colspan=3><input type=text name=desc value="<?echo $desc;?>" size=50></TD>
</TR>

<?}?>

<TR>
    <TD class=td_label align=right  colspan=1>Nome:</TD>
    <TD class=td_label colspan=3><input type=text name=nome value="<?echo $nome;?>" size=50></TD>
</TR>
<TR>
    <TD class=td_label align=right colspan=1>href:</TD>
    <TD class=td_label colspan=3><input type=text name=href size=50 value="<?echo $href;?>"></TD>
</TR>
<TR>
    <TD class=td_label align=right align=center colspan=4>
    <input type=submit name=butincluirmenu value=Incluir size=50></TD>
</TR>
</table>
</form>
</body>
</html>
