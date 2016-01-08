<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
###Инициализация глобальных переменных Битрикс###
global $DB;
/** @global CUser $USER */
global $USER;

\Bitrix\Main\Loader::includeModule('library.read');
use LIBRARY\READ;

$arParams["USER_ID"] = $USER;
$arParams["USER_ID"] = intval($arParams["USER_ID"]);

$arResult['READERS']=READ\LendingManager::getRead($arParams['USER_ID']);
$arResult['BOOKS']=READ\LendingManager::getBook($arParams['USER_ID']);

if($_REQUEST['Save'])
{
    READ\LendingManager::AddLend($_REQUEST['UF_READ'], $_REQUEST['UF_BOOK'], $_REQUEST['UF_CREATED']);
    READ\LendingManager::ViewLend();
};

if(!$_REQUEST['UF_CREATED']) {
    $_REQUEST['UF_CREATED'] = date('d') . '.' . date('m') . '.' . date('Y');
};

$arParams["DATE_FORMAT"] = trim($arParams["DATE_FORMAT"]);
if(strlen($arParams["DATE_FORMAT"]) <= 0)
{
    $arParams["DATE_FORMAT"] = $DB->DateFormatToPHP(CSite::GetDateFormat("SHORT"));
};


$this->IncludeComponentTemplate();
?>