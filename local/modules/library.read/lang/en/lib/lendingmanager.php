<?php
namespace LIBRARY\READ;
use Bitrix\Main\Application;
use Bitrix\Main\Entity;
use Bitrix\Main\Entity\Event;
use Bitrix\Main\Localization\Loc;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\UserTable;
Loc::loadMessages(__FILE__);

class LendingManager{
    const IBLOCK_CODE_LEND = 'lend';
    const IBLOCK_CODE_READ = 'read';

    public static function getLend(
        $arOrder = array('SORT' => 'ASC'),
        $arFilter = array(),
        $arGroupBy = false,
        $arNavStartParams = false,
        $arSelectFields = array('ID', 'NAME')
)
{
    $elements = array();
    //Получаем ID инфоблока KPI по его символьному коду
    $rsIblock = \CIBlock::GetList(
    array(),
    array(
        'CODE' => self::IBLOCK_CODE_LEND,
        'SITE_ID' => SITE_ID)
    );
    $arIblock = $rsIblock->GetNext();
    $arFilter['IBLOCK_ID'] = $arIblock['ID'];
    $rsElements = \CIBlockElement::GetList(
        $arOrder,//массив полей сортировки элементов и её направления
        $arFilter, //массив полей фильтра элементов и их значений
        $arGroupBy, //массив полей для группировки элементов
        $arNavStartParams, //параметры для постраничной навигации и ограничения количества выводимых элементов
        $arSelectFields //массив возвращаемых полей элементов
        );
    while($arElements = $rsElements->Fetch())
    { //Получение информации о файле с регламентом расчета показателя: ссылка на файл на сервере, название файла и т.д.
    foreach($arElements['PROPERTY_ID_LEND'] as $key => $idFileLending)
    {
        $arElements['PROPERTY_ID_LEND'][$key] = \CFile::GetFileArray($idFileLending);
    }
        $elements[] = $arElements;
    }
    return $elements;
}
    public static function GetReaders($idReader)
    {
        if(!$idReader)
        {
            return array();
        }
         $arReaders = UserTable::getList(array(
        'select' => array( 'UF_READ' ),
        'filter' => array( 'ID' => $idReader )
        )
    )->fetch();
//Получаем список всех KPI данных подразделений
        return self::getLend(
            array('NAME' => 'asc'),
            array('PROPERTY_READER_ID' => $arReaders),
            false,
            false,
            array('ID', 'NAME', 'PROPERTY_NAME')
        );
    }
}