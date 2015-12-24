<?if (!empty($arResult)):?>
<ul class="icons">
	<?foreach($arResult as $key => $arItem):?>
			<li><a href="<?=$arItem["LINK"];?>"><span class="icon"><?=$arItem["NAME"];?></span></a>
			</li>
			</ul>
		<?endforeach;?>
<?endif;?>