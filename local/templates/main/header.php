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
						<nav id="nav">
							<ul>
								<li><a href="index.html">Home</a></li>
								<li>
									<a href="#">Dropdown</a>
									<ul>
										<li><a href="#">Lorem dolor</a></li>
										<li><a href="#">Magna phasellus</a></li>
										<li><a href="#">Etiam sed tempus</a></li>
										<li>
											<a href="#">Submenu</a>
											<ul>
												<li><a href="#">Lorem dolor</a></li>
												<li><a href="#">Phasellus magna</a></li>
												<li><a href="#">Magna phasellus</a></li>
												<li><a href="#">Etiam nisl</a></li>
												<li><a href="#">Veroeros feugiat</a></li>
											</ul>
										</li>
										<li><a href="#">Veroeros feugiat</a></li>
									</ul>
								</li>
								<li><a href="left-sidebar.html">Left Sidebar</a></li>
								<li class="current"><a href="index.html">Right Sidebar</a></li>
								<li><a href="two-sidebar.html">Two Sidebar</a></li>
								<li><a href="no-sidebar.html">No Sidebar</a></li>
							</ul>
						</nav>

				</div>
				<section class="wrapper style1">
					<div class="container">
						<div class="row 200%">
							<div class="8u 12u(narrower)">
                                <div id="content">
