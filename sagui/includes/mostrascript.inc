<?
$query="select  s.id,s.nome,v.versao,v.status,u.nome,to_char(v.data,'DD/MM/YYYY HH24:MI') ";
$query=$query."from scriptpatch s,versaoscriptpatch v,usuario u where u.id=v.idusuario ";
$query=$query." and v.idscript=s.id and v.idscript='".$_POST["script"]."' order by v.versao desc";
$result=pg_exec($conn,$query);
$lines=pg_numrows($result);
?>
<form name="formscript" method="post" action="gerenciarscript.php">
<input type=hidden name=script value="<?echo $_POST["script"]?>">
<TABLE align="center" width="80%">
<TR><TD class=td_header align="center" colspan=8>
<?$linha=pg_fetch_row($result,0);?>
Versoes do Script <?echo $linha[1];?>
</TD></TR>
<TR>
<TD class=td_header align="center" colspan=1>Versao</TD>
<TD class=td_header align="center" colspan=2>Status</TD>
<TD class=td_header align="center" colspan=2>Autor</TD>
<TD class=td_header align="center" colspan=2>Data e hora</TD>
<TD class=td_header align="center" colspan=1></TD>
</TR>
<?
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);
?>
<TR>
<TD class=td_info align="center" colspan=1><?echo $linha[2];?></TD>
<TD class=td_info align="center" colspan=2><?echo $linha[3];?></TD>
<TD class=td_info align="center" colspan=2><?echo $linha[4];?></TD>
<TD class=td_info align="center" colspan=2><?echo $linha[5];?></TD>
<TD class=td_info align="center" colspan=1>
<input type=image src=imagens/lupa.png name=versao value="<?echo $linha[2];?>" onclick="submit()">
</TD>
</TR>
<?}?>
</form>
<form name="formpatch" method="post" action="gerenciar.php">
<TR><TD class=td_header colspan=8>Patches associados:</TD></TR>
<TD class=td_header align="center" colspan=3>Sequencial</TD>
<TD class=td_header align="center" colspan=4>Titulo</TD>
<TD class=td_header align="center" colspan=1></TD>

<?
$result=pg_exec($conn,"select id,sequencial,titulo from patch where idscript='".$_POST["script"]."'");
$lines=pg_numrows($result);
if (!$lines=pg_numrows($result))
	echo "<TR><TD class=td_info colspan=8 align=center>Nenhum registro encontrado</td>\n";

for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);
	echo "<TR><TD class=td_info colspan=3 align=center>$linha[1]</td>\n";
	echo "<TD class=td_info colspan=4>$linha[2]</td>";
	echo "<TD class=td_info colspan=1 align=center>";
	echo "<input type=image src=imagens/lupa.png name=patch value=$linha[0] onclick=\"submit()\">";
	echo "</td>";
}
?>
</form>
<TR><TD class=td_header colspan=8>Ocorrencias</TD></TR>
<TD class=td_header align="center" colspan=1>Versao</TD>
<TD class=td_header align="center" colspan=2>Status</TD>
<TD class=td_header align="center" colspan=2>Por</TD>
<TD class=td_header align="center" colspan=3>Data e hora</TD>
<?
$result=pg_exec($conn,"select l.versao,l.status,u.nome,to_char(l.data,'DD/MM/YYYY HH24:MI') as data from log_atividade_scripts l, usuario u where idscript='".$_POST["script"]."' and l.idusuario=u.id order by data");
if (!$lines=pg_numrows($result))
	echo "<TR><TD class=td_info colspan=8 align=center>Nenhum registro encontrado</td>\n";

for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);
	echo "<TR><TD class=td_info colspan=1 align=center>$linha[0]</td>\n";
	echo "<TD class=td_info colspan=2 align=center>$linha[1]</td>";
	echo "<TD class=td_info colspan=2 align=center>$linha[2]</td>";
	echo "<TD class=td_info colspan=3 align=center>$linha[3]</td></tr>";
}
?>
</TABLE>
