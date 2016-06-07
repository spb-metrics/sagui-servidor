<html><HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<body>
<form name="formalista" method="post" action="cadusuario.php?acao=alterarusuario">
<TABLE align="center" width="80%">
<TR><TD class=td_label align="center" colspan=5>Lista de Patches</TD></TR>
<TR>
<TD class=td_label align="center" ></TD>
<TD class=td_label align="center" >Login</TD>
<TD class=td_label align="center" >Nome</TD>
<TD class=td_label align="center" >Perfil</TD>
<TD class=td_label align="center" >status</TD>
</TR>
<?
$q="select u.id,u.login,u.nome,p.descricao,u.status from usuario u,perfildeuso p ";
$q=$q." where p.id=u.idperfildeuso order by u.nome desc";
$result=pg_exec($conn,$q);
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
$linha=pg_fetch_row($result,$i);
?>
<TR>
<TD class=td_label align="center" width="5%">
<?
echo "<input type=radio name=idusuario value=\"$linha[0]\" onclick=\"submit()\">";
?>
</TD>
<TD class=td_label ><?echo $linha[1]?></TD>
<TD class=td_label ><?echo $linha[2]?></TD>
<TD class=td_label ><?echo $linha[3]?></TD>
<TD class=td_label ><?echo $linha[4]?></TD>
</TR>
<?
}
?>
</TABLE>
</form>
</body>
</html>
