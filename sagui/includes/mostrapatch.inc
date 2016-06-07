<?
$query="select  p.id,p.sequencial,p.titulo,p.msg,u.nome,to_char(p.data,'DD/MM/YYYY HH24:MI'),s.nome,s.id ";
$query=$query."from patch p,scriptpatch s,usuario u where u.id=p.idusuario ";
$query=$query." and p.idscript=s.id and p.id='".$_POST["patch"]."'";
$result=pg_exec($conn,$query);
$linha=pg_fetch_row($result,$i);
?>
<form name="formassocia" method="post" action="patch.php?acao=alterarpatch">
<TABLE align="center" width="60%">
<TR><TD class=td_header align="center" colspan=8>Dados do Patch</TD></TR>
<TR>
<TD class=td_header align="center" colspan=2>Sequencial</TD>
<TD class=td_header align="center" colspan=2>Script Associado</TD>
<TD class=td_header align="center" colspan=2>Autor</TD>
<TD class=td_header align="center" colspan=2>Data e hora</TD>
</TR>
<TR>
<TD class=td_info align="center" colspan=2><?echo $linha[1];?></TD>
<TD class=td_info align="center" colspan=2>
<a href=gerenciarscript.php?script=<?echo $linha[7];?>>
<?echo $linha[6];?>
</a>
</TD>
<TD class=td_info align="center" colspan=2><?echo $linha[4];?></TD>
<TD class=td_info align="center" colspan=2><?echo $linha[5];?></TD>
</TR>
<TR><TD class=td_header  colspan=8>Titulo:</TD></TR>
<TR><TD class=td_info colspan=8><?echo $linha[2];?></TD></TR>
<TR><TD class=td_header colspan=8>Mensagem ao usuario:</TD></TR>
<TR><TD class=td_info colspan=8><?echo $linha[3];?></TD></TR>
<TR><TD class=td_header colspan=8>Unidades onde ser&aacute; aplicado:</TD></TR>
<TR><TD class=td_info colspan=8>
<?
$result=pg_exec($conn,"select u.nome from unidade u,patchunidade pu where pu.idunidade=u.id and pu.idpatch='".$_POST["patch"]."'");
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
$linha=pg_fetch_row($result,$i);
	echo $linha[0]."<BR>";
}
?></TD></TR>

<TR><TD class=td_header colspan=8>Perfis associados:</TD></TR>
<TR><TD class=td_info colspan=8>
<?
$result=pg_exec($conn,"select p.nome from perfil p,patchperfil pp where pp.idperfil=p.id and pp.idpatch='".$_POST["patch"]."'");
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
$linha=pg_fetch_row($result,$i);
	echo $linha[0]."<BR>";
}
$result=pg_exec($conn,"select count(distinct l.ip) from logpatch l,patch p where p.id='".$_POST["patch"]."' and l.sequencial=p.sequencial and status='ERRO'");
if($lines=pg_numrows($result)) $erro=pg_fetch_row($result,0);
?>
<?
$result=pg_exec($conn,"select count(distinct l.ip) from logpatch l,patch p where p.id='".$_POST["patch"]."' and l.sequencial=p.sequencial and status='OK'");
if($lines=pg_numrows($result)) $linha=pg_fetch_row($result,0);
?>
<TR><TD class=td_header align="center" colspan=4>Acertos <?echo $linha[0]?>
<input type=image src=imagens/lupa.png name=acertos value=1 onclick="submit()"?>
</TD>
<TD class=td_header align="center" colspan=4>Erros <?echo $erro[0]?>
<input type=image src=imagens/lupa.png name=erros value=1 onclick="submit()"?>                                              </TD>
</TR>
<TR><TD class=td_header align="center" colspan=8>
<input type=hidden name=patch value=<?echo $_POST["patch"];?>>
<input type=submit name=butalterarpatch value="Alterar Patch">
</TD></TR>
</form>
</TD>
</TR>
<TR>
</TABLE>
