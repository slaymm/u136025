<?php
/**
 * Created by PhpStorm.
 * User: ������
 * Date: 23.11.2015
 * Time: 12:08
 */
?>
<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();?>
								</div>
							</div>
						</div>
					</div>
				</section>

				<div id="footer">
					<div class="container">
						<div class="row">
							<section class="3u 6u(narrower) 12u$(mobilep)">
								<h3>Ссылки на материалы</h3>
								<ul class="links">
									<li><a href="orioks.miet.ru">Портфоилио ОРИОКС</a></li>
									<li><a href="http://vk.com/ivanov_andrey_hmk">Проофиль ВК</a></li>
									<li><a href="http://orioks.miet.ru/st/resurs/?tpd=2555195&d=1624354">Ресурсы проета</a></li>
									<li><a href="#">Презентация</a></li>
								</ul>
							</section>
							<section class="3u 6u$(narrower) 12u$(mobilep)">
								<h3>Нормативные документы</h3>
								<ul class="links">
									<li><a href="http://orioks.miet.ru/oroks-miet/upload/ftp/pub/2015/12_3/567be8ff5ac8e/Ustav._Ivanov_Andrey._P31.docx">Устав проекта</a></li>
									<li><a href="http://acis.mit.edu/acis/sreq/sreq.book.html">Спецификация к ПО АКИС</a></li>
								</ul>
							</section>
							<section class="6u 12u(narrower)">
								<h3>Отправьте отзыв</h3>
									<div class="row 50%">
										<div class="6u 12u(mobilep)">
											<input type="text" name="name" id="name" placeholder="Имя" />
										</div>
										<div class="6u 12u(mobilep)">
											<input type="email" name="email" id="email" placeholder="Email" />
										</div>
									</div>
									<div class="row 50%">
										<div class="12u">
											<textarea name="message" id="message" placeholder="Отзыв" rows="5"></textarea>
										</div>
									</div>
									<div class="row 50%">
										<div class="12u">
											<ul class="actions">
												<li><input type="submit" class="button alt" value=Отправить отзыв" /></li>
											</ul>
										</div>
									</div>
								</form>
							</section>
						</div>
					</div>

					<?$APPLICATION->IncludeComponent("bitrix:photo.section", "social_icons", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "photos",	// Тип инфоблока
		"IBLOCK_ID" => "31",	// Инфоблок
		"SECTION_ID" => $_REQUEST["SECTION_ID"],	// ID раздела
		"SECTION_CODE" => "",	// Код раздела
		"SECTION_USER_FIELDS" => array(	// Свойства раздела
			0 => "",
			1 => "",
			2 => "",
		),
		"ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем фотографии
		"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки фотографий в разделе
		"FILTER_NAME" => "arrFilter",	// Имя массива со значениями фильтра для фильтрации элементов
		"FIELD_CODE" => array(	// Поля
			0 => "",
			1 => "ID",
			2 => "Название",
			3 => "Сортировка",
			4 => "Картинка",
			5 => "",
		),
		"PROPERTY_CODE" => array(	// Свойства
			0 => "URL",
			1 => "[URL] Ссылка",
			2 => "",
		),
		"PAGE_ELEMENT_COUNT" => "20",	// Количество элементов на странице
		"LINE_ELEMENT_COUNT" => "3",	// Количество фотографий, выводимых в одной строке таблицы
		"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
		"DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
		"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
		"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
		"PAGER_TITLE" => "Социальные сети",	// Название категорий
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
	),
	false
);?>

						<div class="copyright">
							<ul class="menu">
								<a>
								<li>&copy; Copyright. </li> <li>E-mail:
										<?$APPLICATION->IncludeComponent(
											"bitrix:main.include",
											"",
											Array(
												"COMPONENT_TEMPLATE" => ".default",
												"AREA_FILE_SHOW" => "file",
												"AREA_FILE_SUFFIX" => "inc",
												"EDIT_TEMPLATE" => "",
												"PATH" => SITE_TEMPLATE_PATH."/include_areas/email.php"
											)
										);?>
										</li>
							</ul>
						</div>

				</div>

		</div>

<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/include/js/jquery.min.js", true);?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/include/js/jquery.dropotron.min.js", true);?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/include/js/skel.min.js", true);?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/include/js/util.js", true);?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/include/js/ie/respond.min.js", true);?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/include/js/main.js", true);?>

	</body>
</html>
