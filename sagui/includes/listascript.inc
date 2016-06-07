<form name="formscript" method="post" action="gerenciarscript.php?lista=<?echo $_GET["lista"];?>">
<TABLE align="center" width="60%">
<TR><TD class=td_label align="center" colspan=4>Lista de Scripts
<select name=statustolist onchange="submit()">
<option value="TODOS">TODOS</option>
<?
$result=pg_exec($conn,"select distinct status from scriptpatch");
$lines=pg_numrows($result);
for($i=0;$i<$lines;$i++){
	$linha=pg_fetch_row($result,$i);
	$selected='';
	if($_POST["statustolist"]==$linha[0] && $_POST["statustolist"]!="TODOS"){
		$selected="selected";
		$where="where status='$linha[0]'";
	}
	echo "<option value=\"$linha[0]\" $selected>$linha[0]</option>";
}
?>
</select>
</TD></TR></table>
<?
if($_GET["lista"]){
	if($where)	$where = $where." and tipo='".$_GET["lista"]."'";
	else $where = " where tipo='".$_GET["lista"]."'";
}
	
$colunas=array("Nome","Status","Tipo");
geralistavisao("Lista de Scripts",$colunas,"vw_lista_scripts","script","gerenciarscript.php",$where);
?>
