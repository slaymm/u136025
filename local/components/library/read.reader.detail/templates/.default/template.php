<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();
?>
<?if($arResult['OK']):?>
    <? ShowMessage(
        array(
            'TYPE' => 'OK',
            'MESSAGE' => $arResult['OK'])
    );
    ?>
<?endif;?>
<?if($arResult['ERROR']):?>
    <?ShowMessage(array(
        'TYPE' => 'ERROR',
        'MESSAGE' => $arResult['ERROR']
    )
    );
    ?>
<?endif;?>
<table style="border-width: 2px; border-spacing: 10px; cellspacing: 4px">
    <tbody>
    <tr>
        <td><span >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </span></td>
        <td><span style="text-align: center; font-size: 150%">Список читателей</span></td>
    </tr>
    </tbody>
</table>
<form action="<?=POST_FORM_ACTION_URI?>"
      method="POST">

    <table style="border-width: 2px; border-spacing: 0px cellspacing: 4px">
        <tbody>
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <tr>
                <td><?=$arItem['PROPERTY_READ_FANAME_VALUE'];?><span>&nbsp&nbsp&nbsp&nbsp&nbsp</span></td>
                <td><?=$arItem['PROPERTY_READ_NAME_VALUE'];?><span>&nbsp&nbsp&nbsp&nbsp&nbsp</span></td></td>
                <td><?=$arItem['PROPERTY_READ_DADNAME_VALUE'];?><span>&nbsp&nbsp&nbsp&nbsp&nbsp</span></td></td>
                <td><?=$arItem['PROPERTY_LEND_ID_VALUE'];?><span>&nbsp&nbsp&nbsp&nbsp&nbsp</span></td></td>
                <td><?=$arItem['PROPERTY_ADRESS_VALUE'];?><span>&nbsp&nbsp&nbsp&nbsp&nbsp</span></td></td>
                <td><?=$arItem['PROPERTY_EMAIL_VALUE'];?><span>&nbsp&nbsp&nbsp&nbsp&nbsp</span></td></td>
        </tr>
        <?endforeach;?>
        </tbody>
    </table>
</form>