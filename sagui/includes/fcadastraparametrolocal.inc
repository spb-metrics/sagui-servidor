<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<?
	$colunas=array("Parametro","Shellvar");
	geralistavisao("Lista de Parametros",$colunas,"parametroslocais","id","gerenciainstalacao.php?acao=adcionarparametro","");
	if($_POST["id"]){
		$result=pg_exec($conn,"select nome,shellvar from parametroslocais where id='".$_POST["id"]."'");
		$linha=pg_fetch_row($result,0);
		$nome=$linha[0];
		$shellvar=$linha[1];
		$id=$_POST["id"];
	}
	else{
		$nome=$_POST["nome"];
		$shellvar=$_POST["shellvar"];
	}
	
?>
<form enctype="multipart/form-data" name=formincluiks method=post action="gerenciainstalacao.php?acao=<?echo $_GET["acao"]?>">
<input type=hidden name=id value="<?echo $id?>":;
<TABLE align="center" width="80%">
<TR>
    <TD colspan=5 class=warn><?echo $mensagem;?></TD>
</TR>
<TR>
<TD align=center class=td_label>Nome:</TD>
<TD align=center class=td_label><input type="text" name="nome" value="<?echo $nome?>" size="30"></TD>
<TD align=center class=td_label>Variavel Shell:</TD>
<TD align=center class=td_label><input type="text" name="shellvar" value="<?echo $shellvar?>" size="30"></TD>
<TD align=center class=td_label>
<input type="submit" name="butadcionar" value="Adcionar">
</TD>
</form>
</TR>
</TABLE>
</BODY>
</HTML>
