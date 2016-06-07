<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>

<!--Formulario 1-->
<?
	$colunas=array("Lista de Perfis de Uso");
	geralistavisao("",$colunas,"perfildeuso","id","cadperfildeuso.php?acao=modificarperfildeuso","");
	if($_POST["id"]){
		$result=pg_exec($conn,"select descricao from perfildeuso where id='".$_POST["id"]."'");
		$linha=pg_fetch_row($result,0);
		$descricao=$linha[0];
		$id=$_POST["id"];
	}
	else{
		$id="";
		$descricao="";
	}
?>

<!--Formulario 2-->
<form name=cadastrarperfiluso method=post action=cadperfildeuso.php?acao=cadastrarperfildeuso>
<input type=hidden name=id value="<?echo $id?>":;
<TABLE align="center" width="80%">
<TR>
    <TD colspan=2 class=warn><?echo $mensagem;?></TD>
</TR>

<TR>
    <TD colspan=2 align=center class=warn width=70%>
	Perfil de Uso
	</TD>
</TR>
<TR>
	<TD colspan=1 align=left class=td_label width=50%>
	Nome do Perfil: 
	</TD>
	<TD colspan=1 align=left width=50%>
	<input type=text name=descricao size=50 value="<?echo $descricao;?>">
	</TD>
</TR>
<TR>
	<TD colspan=2 align=left class=td_label width=50%>

		<input type=submit name=butperfildeuso value=Incluir size=50>
		<input type=submit name=butperfildeuso value=Deletar size=50>

	</TD>
</TR>
	
</table>
</form>
</body>
</html>