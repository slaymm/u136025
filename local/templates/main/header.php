<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 23.11.2015
 * Time: 12:08
 */
?>
<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();?>
<?IncludeTemplateLangFile(__FILE__);?>
<!DOCTYPE HTML>
<html lang="<?=LANGUAGE_ID?>">
	<head>
		<title><?$APPLICATION->ShowTitle();?>Library</title>
		<?$APPLICATION->ShowHead();?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/include/js/ie/html5shiv.js", true);?>
		<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/include/css/main.css",true);?>
		<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/include/css/ie8.css",true);?>
		<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/include/css/ie9.css",true);?>
	</head>
	<body>
	<?$APPLICATION->ShowPanel();?>
		<div id="page-wrapper">
				<div id="header">
					<?if(!CSite::InDir('/')):?><a href="/"><?endif;?>
					<h1><?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"COMPONENT_TEMPLATE" => ".default",
								"AREA_FILE_SHOW" => "file",
								"AREA_FILE_SUFFIX" => "inc",
								"EDIT_TEMPLATE" => "",
								"PATH" => SITE_TEMPLATE_PATH."/include_areas/logo.php"
							)
						);?>
					</h1>
						<?if(!CSite::InDir('/')):?></a><?endif;?>
					<?$APPLICATION->IncludeComponent("bitrix:menu", "top_menu", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
		"MENU_CACHE_TYPE" => "A",	// Тип кеширования
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
			0 => "",
		),
		"MAX_LEVEL" => "2",	// Уровень вложенности меню
		"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
		"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	),
	false
);?>
				</div>
				<section class="wrapper style1">
					<div class="container">
						<div class="row 200%">
							<div class="8u 12u(narrower)">
                                <div id="content">
