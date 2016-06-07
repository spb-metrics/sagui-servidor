<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>

<!--Formulario 1-->
<?
	$colunas=array("Tipos de Evento");
	geralistavisao("",$colunas,"tipoevento","id","cadtipoevento.php?acao=modificartipoevento","");
	if($_POST["id"]){
		$result=pg_exec($conn,"select nome from tipoevento where id='".$_POST["id"]."'");
		$linha=pg_fetch_row($result,0);
		$nome=$linha[0];
		$id=$_POST["id"];
	}
	else{
		$id="";
		$nome="";
	}
?>

<!--Formulario 2-->
<form name=cadastrarperfiluso method=post action=cadtipoevento.php?acao=cadastrartipoevento>
<input type=hidden name=id value="<?echo $id?>":;
<TABLE align="center" width="80%">
<TR>
    <TD colspan=2 class=warn><?echo $mensagem;?></TD>
</TR>

<TR>
    <TD colspan=2 align=center class=warn width=70%>
	Tipo de Evento
	</TD>
</TR>
<TR>
	<TD colspan=1 align=left class=td_label width=50%>
	Nome do Tipo de Evento: 
	</TD>
	<TD colspan=1 align=left width=50%>
	<input type=text name=nome size=50 value="<?echo $nome;?>">
	</TD>
</TR>
<TR>
	<TD colspan=2 align=left class=td_label width=50%>

		<input type=submit name=buttipoevento value=Incluir size=50>
		<input type=submit name=buttipoevento value=Deletar size=50>

	</TD>
</TR>
	
</table>
</form>
</body>
</html>