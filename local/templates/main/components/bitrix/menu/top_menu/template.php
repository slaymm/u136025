<nav id="nav">
	<?if (!empty($arResult)):?>
	<ul>
		<?foreach($arResult as $key => $arItem):?>
			<?if($arItem['DEPTH_LEVEL'] != 1){ continue; } ?>
			<?if($arItem['DEPTH_LEVEL'] == 1):?>
				<li <?if($arItem["SELECTED"]):?>class="current"<?endif;?>><a href="#"><?=$arItem["TEXT"];?></a>
			<?endif;?>
		</li>
		<?endforeach;?>

	</ul>
	<?endif?>
</nav>