<?$file = $_REQUEST["file"];
$file = preg_replace("#[\\\\\\/]+#", "/", $file);
$file = preg_replace("#\\.+[\\\\\\/]#", "", $file);

if(($p = strpos($file, "\0"))!==false)
	$file = substr($file, 0, $p);

if (strpos($file, "/vote/")!==false)
{
	if (strpos($file, "/bitrix/modules/vote/install/templates/vote/")===0 ||
		strpos($file, "/bitrix/templates/")===0) @include($_SERVER["DOCUMENT_ROOT"]."/".$file);
}
?>
