<?
/*
SERPRO - Serviço Federal de Processamento de Dados, Brasil

Este arquivo é parte do programa SAGÜI -Sistema de Apoio à Gerência Unificada de Informações

O SAGÜI é um software livre; você pode redistribui-lo e/ou modifica-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença, ou (na sua opnião) qualquer versão.

Este programa é distribuido na esperança que possa ser util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "LICENCA.txt", junto com este programa, se não, escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

 

if($_GET['tipoPesquisa']=='ce'){
        $chave=$_GET['idElemento']; 
	$filtro=$filtro." and idequipamento='$chave' ";

}
elseif($_GET['tipoPesquisa']=='script'){
	$idscript=$_GET['idElemento'];
	$filtro=$filtro." and idscript='$idscript' ";
}

include "includes/functions.php";
connect();
if($chave){        
	$q="(SELECT vc.idequipamento as id,a.nome,c.value,to_char(c.data,'DD/MM/YYYY HH24:MI') from (SELECT idatributo,idequipamento,max(id) as id from coleta  group by idatributo,idequipamento) as vc, atributo a, coleta c  where c.id=vc.id and a.id=c.idatributo) as tabela";
	$cols=array("nome","value","data");
        geralistamulti("Dados do Equipamento - $chave",$cols,$q,"","painelevento.php?".$_SERVER['QUERY_STRING'],"where id ='$chave'");
}
elseif($idscript){
	$q="(select s.id,s.nome,case when s.tipo = 'PATCH' and s.id not in (select idscript from patch) then 'SCRIPT' else s.tipo end,max(v.versao),u.nome,u.email from scriptpatch s, versaoscriptpatch v, usuario u where s.id=v.idscript and v.idusuario=u.id group by s.id,s.nome,s.tipo,u.nome,u.email) as view";
	
		
	$cols=array("nome","tipo","ultima-versao","Autor","contato");
        geralistamulti("Dados do Plugin - $idscript",$cols,$q,"","painelevento.php?".$_SERVER['QUERY_STRING'],"where id=$idscript");
}
	$result=pg_exec($conn,"select idscript from patch where idscript='$idscript'");
        $lines=pg_numrows($result);
	if($lines){
			
		$q="(select idscript,sequencial,titulo from patch) as view";
		$cols=array("sequencial","titulo");
		geralistamulti("Patch Associado",$cols,$q,"","painelevento.php?".$_SERVER['QUERY_STRING'],"where idscript=$idscript");
	}

?>
<center>
<u>Fechar</u>
</center>
