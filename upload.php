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
<?php
error_reporting(E_ALL);
include('class.upload.php');
$MyPluginsURL = $file=$_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/post-quick-header";

$dir_dest = $MyPluginsURL.'/uploaded_headers';
$dir_temp = $MyPluginsURL.'/tmp';
$dir_pics = $dir_dest;

if(isset($_POST['my_title'])&&$_POST['my_title']!=''){
	$MyTitle = preg_replace("/[^A-Za-z0-9_,.!?@:'\"\/\n ]/","", $_POST['my_title']);
	$FileName = str_replace(" ", "_", preg_replace("/[^A-Za-z0-9\-_ ]/","", $_POST['my_title']));
}else{
	$MyTitle = "Image";
	$FileName = "Image";
}

$FontColor = preg_replace("/[^A-Za-z0-9]/","", $_POST['my_font']);
$BGColor = preg_replace("/[^A-Za-z0-9]/","", $_POST['my_bg']);

$fontFile = "fontcolor.txt";
$ff = fopen($fontFile, 'w');
fwrite($ff, $FontColor);
fclose($ff);

$bgFile = "bgcolor.txt";
$bg = fopen($bgFile, 'w');
fwrite($bg, $BGColor);
fclose($bg);

if($_POST['selected']==1){
	$URL_file = $_POST['my_field'];
	$MyFile = "temp";
	copy($URL_file,$dir_temp."/".$MyFile);
	$newFile = $dir_temp."/".$MyFile;
}else if($_POST['selected']==2){
	$newFile = $_FILES['my_field'];
}

$handle = new upload($newFile);
if ($handle->uploaded) {
	$handle->file_new_name_body          = $FileName;
	$handle->file_name_body_pre          = 'header_';
	$handle->image_resize                = true;
	$handle->image_x                     = 500;
	$handle->image_y                     = 250;
	$handle->image_ratio_crop            = true;
	$handle->image_convert               = 'png';
	$handle->image_watermark             = 'img_includes/frame_500.png';
	$handle->image_watermark_position    = 'TL';
	$handle->image_text                  = strtoupper($MyTitle);
	$handle->image_text_padding_x        = 10;
	$handle->image_text_padding_y        = 22;
	$handle->image_text_font             = 'font/SimHei_17x48.gdf';
	$handle->image_text_position         = 'BL';
	$handle->image_text_color            = '#'.$FontColor;
	$handle->image_reflection_height     = '50px';
	$handle->image_reflection_opacity    = 60;
	$handle->image_reflection_space      = 2;
	$handle->image_background_color      = '#'.$BGColor;
	$handle->process($dir_dest);
	if ($handle->processed) {
		echo '<p align="center"><img src="uploaded_headers/'.$handle->file_dst_name.'" height="278" width="460"/><br />';
		echo '<input class="input" type="button" value="Insert Header" onclick="parent.insertHeader(\'wp-content/plugins/post-quick-header/uploaded_headers/'.$handle->file_dst_name.'\')"/>';
	} else {
		echo '<p>Unfortunately, we\'ve encountered an error while processing your file. <a href="form.php">Please try it again</a>.</p>';
	}
}
?>