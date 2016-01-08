<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
    "PARAMETERS" => array(
        "mykonstr" => array(
            "PARENT" => "BASE",
            "NAME" => 'Выбор конструкции',
            "TYPE" => "LIST",
            'VALUES' => array(
                "ADDzai" => "Добавлени заявки",
                "ADDstr" => "Добавление статьи"
            )
        ),
        "USER_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("USER"),
            "TYPE" => "STRING",
            "DEFAULT" => '$_REQUEST["USER_ID"]',
        ),
        "ACTIVE_DATE_FORMAT" => array(
            "PARENT" => "BASE", "
             NAME" => GetMessage("ACTIVE_DATE_FORMAT"),
            "TYPE" => "STRING", "DEFAULT" => 'd.m.Y', ),
        )
);
?>