<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?$APPLICATION->IncludeComponent(
    "bitrix:map.google.view",
    "",
    Array(
        "COMPONENT_TEMPLATE" => ".default",
        "INIT_MAP_TYPE" => "ROADMAP",
        "MAP_DATA" => "a:3:{s:10:\"google_lat\";d:55.985287925784625;s:10:\"google_lon\";d:37.20227090116861;s:12:\"google_scale\";i:14;}",
        "MAP_WIDTH" => "600",
        "MAP_HEIGHT" => "500",
        "CONTROLS" => array("SMALL_ZOOM_CONTROL", "TYPECONTROL", "SCALELINE"),
        "OPTIONS" => array("ENABLE_SCROLL_ZOOM", "ENABLE_DBLCLICK_ZOOM", "ENABLE_DRAGGING", "ENABLE_KEYBOARD"),
        "MAP_ID" => ""
    )
);?><br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>