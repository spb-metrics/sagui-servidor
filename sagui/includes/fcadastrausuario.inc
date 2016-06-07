<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<form name=cadastrausuario method=post action=cadusuario.php?acao=<?echo $_GET["acao"];?>>
<?
if($_POST["idusuario"] && !$feito){
	$q="select nome,login,email,idperfildeuso,status from usuario where id='".$_POST["idusuario"]."'";
	$result=pg_exec($conn,$q);
	$lines=pg_numrows($result);
	$linha=pg_fetch_row($result,0);
	$nome=$linha[0];
	$login=$linha[1];
	$email=$linha[2];
	$idperfildeuso=$linha[3];
	$status=$linha[4];
	echo "<input type=hidden name=idusuario value=".$_POST["idusuario"].">";
}
else{
	$nome=$_POST["nome"];
	$login=$_POST["login"];
	$email=$_POST["email"];
	$idperfildeuso=$_POST["idperfildeuso"];
}
?>
<TABLE align="center" width="70%">
<TR>
    <TD colspan=4 class=warn><?echo $mensagem;?></TD>
</TR>

<tr>
    <TD colspan=1 align=right class=td_label width=50%>
	Perfil Associado:
	</td>
	<TD colspan=3 align=left class=td_label width=50%>
	<select name=idperfildeuso>
	<option value="">Escolha um perfil</option>
	
<?

$result=pg_exec($conn,"select id,descricao from perfildeuso");
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);		
	$selected='';
	if($linha[0]==$idperfildeuso)	$selected='selected';
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
<TR>
    <TD class=td_label align=right  colspan=1>Login:</TD>
    <TD class=td_label colspan=3><input type=text name=login value="<?echo $login;?>" size=50></TD>
</TR>	
<TR>
    <TD class=td_label align=right  colspan=1>Email:</TD>
    <TD class=td_label colspan=3><input type=text name=email value="<?echo $email;?>" size=50></TD>
</TR>		
<TR>
    <TD class=td_label align=right  colspan=1>senha:</TD>
    <TD class=td_label colspan=3><input type=password name=senha size=50></TD>
</TR>		
<TR>
    <TD class=td_label align=right  colspan=1>confirma:</TD>
    <TD class=td_label colspan=3><input type=password name=csenha size=50></TD>
</TR>			
<TR>
    <TD class=td_label align=right align=center colspan=4>
<?if($_GET["acao"]=="alterarusuario"){
	if($status=="HABILITADO"){?>
    <input type=submit name=butdesativarusuario value=Desativar size=50>&nbsp;&nbsp;&nbsp;
<?}else{?>
	<input type=submit name=butdesativarusuario value=Ativar size=50>&nbsp;&nbsp;&nbsp;
<?}
}?>
    <input type=submit name=butincluirusuario value=Incluir size=50>

</TD>
</TR>

</table>
</form>
</body>
</html>
