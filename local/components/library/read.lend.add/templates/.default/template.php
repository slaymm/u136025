<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<table  class="simple-little-table" cellspacing='0' >

    <tbody>

    <tr >
        <form action="<?=POST_FORM_ACTION_URI?>" method="POST">

            <table class="simple-little-table" cellspacing='0'>
                <tbody>
                    <tr>
                        <td>Регистрация заказа на книгу</td>
                    </tr>

            </table>

            <td>   Выберете читателя <select  name = "UF_READ" >
                    <?foreach($arResult["READERS"] as $arItem1):?>
                    <option>
                            <tr>
                                <td><?=$arItem1['NAME'];?></td>
                            </tr>
                    </option>
                    <?endforeach;?>
                </select> </td>

            <td>   Выберете книгу <select  name = "UF_BOOK" >
                    <?foreach($arResult["BOOKS"] as $arItem2):?>
                        <option>
                        <tr>
                            <td><?=$arItem2['NAME'];?></td>
                        </tr>
                    </option>
                    <?endforeach;?>
                </select> </td>

            <td><br><br>Дата регистрации  <input  type="datetime" name = "UF_CREATED"
                                             value="<?=date($arParams["DATE_FORMAT"]);?>" >

                </input> </td>


            <td><br><br> <input  type="submit" name="Save" value="Отправить"> </td>
    </tr>

    </form>

    </tbody>
</table>


