<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
###Инициализация глобальных переменных Битрикс###
global $DB;
/** @global CUser $USER */
global $USER;

\Bitrix\Main\Loader::includeModule('library.read');
use LIBRARY\READ;
###Проверка входных параметров на корректность и приведение их к нужному виду###

$arParams["USER_ID"] = $USER;
$arParams["USER_ID"] = intval($arParams["USER_ID"]);
if(!$arParams["USER_ID"])
{
    ShowError(GetMessage("EMPTY_USER"));
    @define("ERROR_404", "Y");
    if($arParams["SET_STATUS_404"]==="Y")
    {
        CHTTP::SetStatus("404 Not Found");
    };
    return array();
};

if($this->StartResultCache(false, array(
        (
        $arParams["CACHE_GROUPS"] === "N" ? false:
            $USER->GetGroups()
        ),
        $bUSER_HAVE_ACCESS
    )
)
)
{
    $arResult['ITEMS'] = READ\LendingManager::getRead($arParams["USER_ID"]); ###Кэширование значения элементов массив
    $this->SetResultCacheKeys(array(
            "ITEMS", "FIO_USER", "PROGRAM_DETAIL_PAGE_URL", "FORM_ACTION", "NAME" )
    );
    ###Подключение шаблона компонента###
    $this->IncludeComponentTemplate();
} ###Вывод элементов из кэша###
if(isset($arResult["ITEM"]))
{
    $this->SetTemplateCachedData();
    return $arResult["ITEM"];
}
