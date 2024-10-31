<?php
// ---------------- Get last saved hex colors //
$mybgcolor = "bgcolor.txt";
$bg = fopen($mybgcolor, 'r');
$BgHex = fread($bg, filesize($mybgcolor));
fclose($bg);

$myfontcolor = "fontcolor.txt";
$font = fopen($myfontcolor, 'r');
$FontHex = fread($font, filesize($myfontcolor));
fclose($font);
?>
<style>
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333;
}
a:link {
	color: #06C;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #06C;
}
a:hover {
	text-decoration: underline;
	color: #06C;
}
a:active {
	text-decoration: none;
	color: #06C;
}
.input{
	border-color: #BBBBBB;
    color: #464646;
	background-color: #FFFFFF;
	border-radius: 4px 4px 4px 4px;
    border-style: solid;
    border-width: 1px;
	font-size: 12px;
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
	line-height: 15px;
	margin: 1px;
    padding: 3px;
}
.input:hover{
	background-color:#E4E4E4 !important;
}	
</style>
<script language="JavaScript">
<!--
function disable(){
	for(var i=0;i<document.PQH.selected.length;i++){
		if(document.PQH.selected[i].checked!=true){
			document.PQH.my_field[i].disabled = true;
		}
		if(document.PQH.selected[i].checked==true){
			document.PQH.my_field[i].disabled = false;
		}
	}
}
function loading(){
	document.getElementById("UploadForm").style.display = "none"; 
	document.getElementById("Load").style.display = "block"; 
}
//-->
</script>
<div align="center" id="UploadForm">
<form name="PQH" enctype="multipart/form-data" method="post" action="upload.php" />
    <table border="0" cellspacing="5" cellpadding="0">
      <tr>
        <td colspan="2"><strong style="font-size:20px;">Post Quick Header</strong></td>
      </tr>
      <tr>
        <td colspan="2">Fill out the form below.</td>
      </tr>
      <tr>
        <td width="100" align="left" valign="top"><strong>Title: </strong></td>
        <td width="360"><input name="my_title" id="my_title" type="text" value="" size="32" maxlength="25" /></td>
      </tr>
      <tr>
        <td align="left" valign="top"><strong>Font Color:</strong></td>
        <td><input name="my_font" id="my_font" type="text" value="<?php echo $FontHex;?>" size="32" maxlength="6" />
        <br /><span style="font-size:10px;">(Do not use #, just the 6-digit hex)</span></td>
      </tr>
      <tr>
        <td align="left" valign="top"><strong>Image URL:</strong></td>
        <td><input name="selected" id="selected" value="1" onclick="disable()" type="radio"/><input type="text" size="32" name="my_field" id="my_field" value="" disabled="disabled"/></td>
      </tr>
      <tr>
        <td align="left" valign="top"><strong>Image File:</strong></td>
        <td><input name="selected" id="selected" value="2" onclick="disable()" type="radio"/><input type="file" size="32" name="my_field" id="my_field" value="" disabled="disabled"/></td>
      </tr>
      <tr>
        <td align="left" valign="top"><strong>Bg Color:</strong></td>
        <td align="left"><input name="my_bg" id="my_bg" type="text" value="<?php echo $BgHex;?>" size="32" maxlength="6" /><br /><span style="font-size:10px;">(Do not use #, just the 6-digit hex)</span></td>
      </tr>
      <tr>
        <td colspan="2" align="left">
          <input class="input" type='button' value='Cancel' onclick="parent.jQuery('#dialog_postquickheader').jqmHide();" >
          <input class="input" type="submit" id="Submit" name="Submit" onclick="loading()" value="Upload and Create Header"/>
        </td>
      </tr>
    </table>
</form>
</div>
<div align="center" id="Load" style="padding:20px; display:none">
	<img src="loading.gif" width="66" height="66" />
</div>
