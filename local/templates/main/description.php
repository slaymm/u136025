<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 23.11.2015
 * Time: 13:30
 */
?>
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? IncludeTemplateLangFile(__FILE__);
$arTemplate = Array
( "NAME" => GetMessage("TEMPLATE_DESCRIPTION_NAME"),
    "DESCRIPTION" => GetMessage("TEMPLATE_DESCRIPTION_DESC")
);
?>