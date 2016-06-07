<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>

<form name=cadastrapatch method=post action=gerenciainstalacao.php?acao=<?echo $_GET["acao"];?>>

<?
if($_POST["id"] && !$feito){
	$result=pg_exec($conn,"select nome,legenda,adcionais from perfil where id='".$_POST["id"]."'");
	$linha=pg_fetch_row($result,0);
	$categoria=$linha[0];
	$descritivo=$linha[1];
	$adcionais=$linha[2];
	echo "<input type=hidden name=id value=".$_POST["id"].">";
}
else{
	$categoria=$_POST["categoria"];
	$descritivo=$_POST["descritivo"];
	$adcionais=$_POST["adcionais"];

}
?>
<TABLE align="center" width="60%">
<TR>
    <TD colspan=4 class=warn><?echo $mensagem;?></TD>
</TR>
<TR>
    <TD class=td_label align=right  colspan=1>Categoria:</TD>
    <TD class=td_label colspan=3><input size=50 type=text name=categoria value="<?echo $categoria;?>"></TD>
</TR>
<TR>
    <TD class=td_label align=right  colspan=1>Descritivo:</TD>
    <TD class=td_label colspan=3><input size=50 type=text name=descritivo value="<?echo $descritivo;?>"></TD>
</TR>
<TR>
    <TD colspan=4 class=td_label align=center>PACOTES ADCIONAIS</TD>
</TR>	
<TR>
    <TD colspan=4 class=warn align=center>
	<textarea name=adcionais rows=10 cols=50><?echo $adcionais?></textarea>
	</TD>
</TR>
<TR>
    <TD class=td_label align=right align=center colspan=4>
    <input type=submit name=butincluircategoria value=Incluir size=50></TD>
</TR>
</table>
</form>
</body>
</html>
