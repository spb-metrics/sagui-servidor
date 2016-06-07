<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<form name="formlista" method="post" action="cadmenu.php?acao=operar">
<input type=hidden name=tipo value=<?echo $_POST["tipo"]?>>
<? if(! $_POST['tipo'] ){ ?>
<TABLE align="center" width="70%">
<TR>
<TD colspan=2 align=center class=td_label><input type=radio name=tipo value=menu onclick=submit()>Menu</TD>
<TD colspan=2 align=center class=td_label><input type=radio name=tipo value=submenu onclick=submit()>Submenu</TD>
</TR>
</table>
</BODY>
</html>
<?
exit;
}
if( $_POST['tipo'] == "menu" ){
	$visao="(select id,nome,descricao,href,target from menu order by id) as view";
	$titulo="Menus";
}
elseif( $_POST['tipo'] == "submenu" ){
	$visao="(select id,nome,descricao,href,target from submenu order by id) as view";
	$titulo="Submenus";
}
$colunas=array("Nome","Descricao","Href","Target");
geralistavisao($titulo,$colunas,$visao,"menu","gerenciarmenu.php","");
?>

</TABLE>
</form>
</body>
</HTML>
