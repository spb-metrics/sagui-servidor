<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<?
if( $_POST['tipo'] == "menu" ){
	$query1="select id,nome,descricao,href,target from menu where id='".$_POST["menu"]."'";
	$titulo="Menu";
	$subtitulo="Submenus";
	$query2="select s.id,s.nome,s.descricao,s.href,s.target from submenu s,menusubmenu m ";
	$query2=$query2."where s.id=m.idsubmenu and m.idmenu='".$_POST["menu"]."'";	
}
elseif( $_POST['tipo'] == "submenu" ){
	$query1="select id,nome,descricao,href,target from submenu where id='".$_POST["menu"]."'";
	$query2="select  m.id,m.nome,m.descricao,m.href,m.target from menu m,menusubmenu ms ";
	$query2=$query2."where m.id=ms.idmenu and ms.idsubmenu='".$_POST["menu"]."'";
	$titulo="Submenu";
	$subtitulo="Menus";
}

$result=pg_exec($conn,$query1);
$linha=pg_fetch_row($result,0);
?>
<TABLE align="center" width="60%">
<TR><TD class=td_header align="center" colspan=8>
<?echo "$titulo $linha[1]";?>
</TD></TR>
<TR>
<TD class=td_header align="center" colspan=3>Descricao</TD>
<TD class=td_header align="center" colspan=2>Href</TD>
<TD class=td_header align="center" colspan=2>Target</TD>
<TD class=td_header align="center" colspan=1></TD>
</TR>
<TR>

<TR>
<TD class=td_info align="center" colspan=3><?echo $linha[2];?></TD>
<TD class=td_info align="center" colspan=2><?echo $linha[3];?></TD>
<TD class=td_info align="center" colspan=2><?echo $linha[4];?></TD>
<TD class=td_info align="center" colspan=1>
<form name="formmenu" method="post" action="cadmenu.php?acao=operar">
<input type="hidden" name=tipo value=<?echo $_POST["tipo"]?>>
<input type="hidden" name=menu value="<?echo $linha[0];?>">
<input type="submit" name=butok value="Alterar">
</form>
<BR>
<form name="formmenu" method="post" action="cadmenu.php?acao=remover">
<input type="hidden" name=tipo value=<?echo $_POST["tipo"]?>>
<input type="hidden" name=menu value="<?echo $linha[0];?>">
<input type="submit" name=butok value="Remover">
</form>
</TD>
</TR>
<TR><TD class=td_header colspan=8><?echo $subtitulo;?> associados:</TD></TR>
<TD class=td_header align="center" colspan=3>Nome</TD>
<TD class=td_header align="center" colspan=4>Descricao</TD>
<TD class=td_header align="center" colspan=1></TD>

<?

$result=pg_exec($conn,$query2);
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);
	echo "<TR><TD class=td_info colspan=4>$linha[1]</td>\n";
	echo "<TD class=td_info colspan=4>$linha[2]</td>";
//	echo "<TD class=td_info colspan=1>";
//	echo "<input type=radio name=menu value=$linha[0] onclick=\"submit()\">";
//	echo "</td>";
}
?>

</TD></TR>
</TABLE>
</form>
</body>
</HTML>
