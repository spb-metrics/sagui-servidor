<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>

<form name=cadastrapatch method=post action=patch.php?acao=<?echo $_GET["acao"];?>>

<?
if($_POST["patch"] && !$feito){
	$result=pg_exec($conn,"select idunidade from patchunidade where idpatch='".$_POST["patch"]."'");
	$lines=pg_numrows($result);
	$a=array();
	for($i=0;$i<$lines;$i++){
		$linha=pg_fetch_row($result,$i);
		$b=array($i => $linha[0]);
		$a=$a+$b;
	}
	$unidades=$a;
	$result=pg_exec($conn,"select idperfil from patchperfil where idpatch='".$_POST["patch"]."'");
	$lines=pg_numrows($result);
	$a=array();
	for($i=0;$i<$lines;$i++){
		$linha=pg_fetch_row($result,$i);
		$b=array($i => $linha[0]);
		$a=$a+$b;
	}
	$perfis=$a;
	$result=pg_exec($conn,"select idscript,titulo,msg from patch where id='".$_POST["patch"]."'");
	$lines=pg_numrows($result);
	$linha=pg_fetch_row($result,0);
	$script=$linha[0];
	$msg=$linha[2];
	$titulo=$linha[1];
	echo "<input type=hidden name=patch value=".$_POST["patch"].">";
}
else{
	$script=$_POST["script"];
	$unidades=$_POST["unidades"];
	$perfis=$_POST["perfis"];
	$titulo=$_POST['titulo'];
	$msg=$_POST['msg'];
}
?>
<TABLE align="center" width="70%">
<TR>
    <TD colspan=4 class=warn><?echo $mensagem;?></TD>
</TR>
<TR>
    <TD colspan=4 class=td_label>Instru&ccedil;&otilde;es:<BR>
	1) Escolha o(s) perfis asssociados ao patch, use SHIFT ou CTRL para escolher mais de um.<BR>
	2) Escolha a(s) unidades onde o patch ser&aacute; aplicado, use SHIFT ou CTRL para escolher mais de um.<BR>
	3) Escolha uma script a ser executado.<BR>
	4) Informe para que serve o script.<BR>
	5) Informe a mensagem a ser mostrada ao usuario.<BR>
	Todos os campos devem ser preenchidos.<BR>
	</TD>
</TR>
<TR>
    <TD width="30%" align=center class=td_label width=50%>
	Escolha os Perfis Associados:<BR>
	<select name=perfis[] multiple  size=6>
<?
$result=pg_exec($conn,"select id,nome from perfil order by nome");
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);
	$selected='';
	if(in_array($linha[0],$perfis))  $selected='selected';	
	echo "<option value=\"$linha[0]\" $selected>$linha[1]</option>\n";
}
?>
	</select>
	</TD>
    <TD colspan=2 align=center class=td_label width=50%>
	Escolha onde sera aplicado:<BR>
	<select name=unidades[] multiple  size=6>
	
<?
$result=pg_exec($conn,"select id,nome from unidade order by nome");
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);		
	$selected='';
	if(in_array($linha[0],$unidades))	$selected='selected';
	echo "<option value=\"$linha[0]\" $selected>$linha[1]</option>\n";
}
?>
	</select>

	</TD>
	
	<TD width="30%" class=td_label width=50% align=center>
	Escolha um arquivo:<BR>
	<select name=script  size=6>
<?
$result=pg_exec($conn,"select id,nome from scriptpatch where tipo='PATCH' order by nome");
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);
	$selected='';
	if ($script==$linha[0]) $selected="selected";
	echo "<option value=\"$linha[0]\" $selected>$linha[1]</option>\n";
}
?>
	</select>
	</TD>
	
</TR>
<TR>
    <TD colspan=4 class=warn></TD>
</TR>
</table>
<TABLE align="center" width="70%">
<TR>
    <TD class=td_label align=right  colspan=1>Corre&ccedil;&atilde;o:</TD>
    <TD class=td_label colspan=3><input type=text name=titulo value="<?echo $titulo;?>" size=50></TD>
</TR>
<TR>
    <TD class=td_label align=right colspan=1>Mensagem ao Usu&aacute;rio:</TD>
    <TD class=td_label colspan=3><input type=text name=msg size=50 value="<?echo $msg;?>"></TD>
</TR>
<TR>
    <TD class=td_label align=right align=center colspan=4>
    <input type=submit name=butincluirpatch value=Incluir size=50></TD>
</TR>
</table>
</form>
</body>
</html>
