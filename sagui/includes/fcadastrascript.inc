<HTML>
<HEAD>
<LINK href="default.css" type=text/css rel=StyleSheet>
</HEAD>
<BODY>
<form enctype="multipart/form-data" name=formincluiscript method=post action="patch.php?acao=adcionarscript">
<TABLE align="center" width="60%">
<TR>
    <TD colspan=4 class=warn><?echo $mensagem;?></TD>
</TR>
<TR>
    <TD colspan=2 class=td_label>Texto do Script:</TD>
    <TD class=td_label>Tipo:</TD>
	<TD class=td_label>
		<?
		if($_GET["tiposcript"]){
			$tiposcript=$_GET["tiposcript"];
		}elseif($_POST["tiposcript"]){
			$tiposcript=$_POST["tiposcript"];
		}
		if($tiposcript){ 
			echo $tiposcript;
			echo "<input type=hidden name=tiposcript value=$tiposcript>";
		}
		else{?>
		
			<select name=tiposcript>
			<option value="">Escolha um tipo</option>
			<option value=PATCH>PATCH</option>
			<option value=COLETA>COLETA</option>
			<option value=OUTROS>OUTROS</option>
		<?}?>
	
	</TD>		
		
</TR>
<TR>
<TD class=td_label colspan=4>
<textarea name="texto" rows=20 cols=80>
<?
	if ($_FILES['conteudo']['size']<=$max_script_size ){
			if($_FILES['conteudo']['tmp_name'])
				echo file_get_contents($_FILES['conteudo']['tmp_name'],$max_script_size);
			elseif($_POST["texto"])
				echo $_POST["texto"];
			else
				echo "escreva aqui ou realize um upload";
	}
	else{
		echo "o script excede o tamanho permitido";
	}
	

?>
</textarea>
</TR>
<TR>
<TD class=td_label align=right width="40%" colspan=2>
Arquivo:&nbsp;
<input type=text name=filename value="
<?
if($_FILES['conteudo']['name'])
	echo $_FILES['conteudo']['name'];
else
	echo $_POST['filename'];
?>
">
</TD>
<TD colspan=2 align=center class=td_label>
<input type="file" name="conteudo" size="30">
<input type="submit" name="butupload" value="Upload">
</TD>
</TR>
<TR>
<TD colspan=4 align=center class=td_label>
<input type="submit" name="butsave" value="Salvar">
</form>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>
