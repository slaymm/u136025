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

						<ul class="icons">
							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>
							<li><a href="#" class="icon fa-linkedin"><span class="label">LinkedIn</span></a></li>
							<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
						</ul>

						<div class="copyright">
							<ul class="menu">
								<a>
								<li>&copy; Copyright. </li><li>E-mail: <?$APPLICATION->IncludeComponent(
											"bitrix:main.include",
											"",
											Array(
												"COMPONENT_TEMPLATE" => ".default",
												"AREA_FILE_SHOW" => "file",
												"AREA_FILE_SUFFIX" => "inc",
												"EDIT_TEMPLATE" => "",
												"PATH" => SITE_TEMPLATE_PATH."/include_areas/email.php"
											)
										);?></li>
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
?>