<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<?	
$query="select  v.conteudo,s.nome,v.versao,v.status,u.nome,to_char(v.data,'DD/MM/YYYY HH24:MI') ";
$query=$query."from scriptpatch s,versaoscriptpatch v,usuario u where u.id=v.idusuario ";
$query=$query." and v.idscript=s.id and v.idscript='".$_POST["script"]."' and v.versao='".$_POST["versao"]."'";
$result=pg_exec($conn,$query);
$linha=pg_fetch_row($result,0);
?>
<form name=liberascript method=post action="gerenciarscript.php">
<input type=hidden name=script value="<?echo $_POST["script"]?>">
<input type=hidden name=versao value="<?echo $_POST["versao"]?>">
<input type=hidden name=filename value="<?echo $linha[1];?>">	
<TABLE align="center" width="60%">
<TR>
    <TD colspan=8 class=td_label>Texto do Script <?echo $linha[1];?>:</TD>
</TR>
<TR>
<TD class=td_label colspan=8>
<textarea name="texto" rows=20 cols=80 READONLY>
<?echo $linha[0];?>
</textarea>
</TR>
<TR>
<TD class=td_label align=right >Versao:</td>
<TD class=td_normal align=left ><?echo $linha[2];?></TD>
<TD class=td_label align=right >Autor:</td>
<TD class=td_normal align=left ><?echo $linha[4];?></TD>
<TD class=td_label align=right >Data:</td>
<TD class=td_normal align=left ><?echo $linha[5];?></TD>
<TD class=td_label align=right >Status:</td>
<TD class=td_info align=left ><?echo $linha[3];?></TD>
</TR>
<tr>
<TD colspan=8 align=center class=td_label>
<? if($linha[3]!="LIBERADO"){ ?>
	<input type="submit" name="butliberar" value="Liberar Script">
<? }else{ ?>
	<input type="submit" name="butbloquear" value="bloquear Script">
<?}?>
&nbsp;&nbsp;&nbsp;
<input type="submit" name="buteditscript" value="Editar">
</TD>
</TR>
</form>
</TABLE>
</BODY>
</HTML>
