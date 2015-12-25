<nav id="nav">
	<?if (!empty($arResult)):?>
	<ul>
		<?foreach($arResult as $key => $arItem):?>
			<?if($arItem['DEPTH_LEVEL'] != 1){ continue; } ?>
			<?if($arItem['DEPTH_LEVEL'] == 1):?>
		<li <?if($arItem["SELECTED"]):?>class="current"<?endif;?>><a href="#"><?=$arItem["TEXT"];?></a>
			<?endif;?>
			<ul>
				<?foreach($arResult as $keyInner => $arItemInner):?>
				<?if($keyInner <= $key) { continue; } ?>
				<?if($arItemInner['DEPTH_LEVEL'] == 2):?>
				<li><a href="<?=$arItemInner["LINK"];?>"><?=$arItemInner["TEXT"];?></a></li>

				<?endif;?>
				<?if($arItemInner['DEPTH_LEVEL'] != 2){ break; } ?>
				<?endforeach;?>
			<?if($arItem['DEPTH_LEVEL'] == 1):?>
			</ul>
			<?endif;?>
		</li>
		<?endforeach;?>

	</ul>
	<?endif?>
</nav>