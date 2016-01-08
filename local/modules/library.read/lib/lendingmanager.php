<?php
namespace LIBRARY\READ;
use Bitrix\Main\Application;
use Bitrix\Main\Entity;
use Bitrix\Main\Entity\Event;
use Bitrix\Main\Localization\Loc;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\UserTable;
use \Bitrix\Main\Type\DateTime;
Loc::loadMessages(__FILE__);

class LendingManager
{
    const IBLOCK_CODE_LEND = 'lend';
    const IBLOCK_CODE_READ = 'read';
    const IBLOCK_CODE_BOOK = 'book';
    const HBLOCK_CODE_LEND = 't lend';

    public static function getRead(
        $arOrder = array('SORT' => 'ASC'),
        $arFilter = array(),
        $arGroupBy = false,
        $arNavStartParams = false,
        $arSelectFields = array('ID', 'NAME', 'PROPERTY_READ_NAME', 'PROPERTY_READ_FANAME',
            'PROPERTY_READ_DADNAME', 'PROPERTY_LEND_ID', 'PROPERTY_ADRESS', 'PROPERTY_EMAIL')
    )
    {
        $elements = array();
        //Получаем ID инфоблока KPI по его символьному коду
        $rsIblock = \CIBlock::GetList(
            array(),
            array(
                'CODE' => self::IBLOCK_CODE_READ,
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
        while ($arElements = $rsElements->Fetch()) { //Получение информации о файле с регламентом расчета показателя: ссылка на файл на сервере, название файла и т.д.
            foreach ($arElements['PROPERTY_READ'] as $key => $idFileRead) {
                $arElements['PROPERTY_READ'][$key] = \CFile::GetFileArray($idFileRead);
            }
            $elements[] = $arElements;
        }
        return $elements;
    }


    public static function getBook(
        $arOrder = array('SORT' => 'ASC'),
        $arFilter = array(),
        $arGroupBy = false,
        $arNavStartParams = false,
        $arSelectFields = array('ID', 'NAME', 'PROPERTY_ID_LEND', 'PROPERTY_NAME_BOOK',)
    )
    {
        $elements = array();
        //Получаем ID инфоблока KPI по его символьному коду
        $rsIblock = \CIBlock::GetList(
            array(),
            array(
                'CODE' => self::IBLOCK_CODE_BOOK,
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
        while ($arElements = $rsElements->Fetch()) { //Получение информации о файле с регламентом расчета показателя: ссылка на файл на сервере, название файла и т.д.
            foreach ($arElements['PROPERTY_READ'] as $key => $idFileBook) {
                $arElements['PROPERTY_READ'][$key] = \CFile::GetFileArray($idFileBook);
            }
            $elements[] = $arElements;
        }
        return $elements;
    }


    public static function AddLend($Reader, $Book, $Created)
    {
        global $USER;
        $arValue = array(
            'UF_ID' => $USER->GetID(),
            'UF_READ' => $Reader,
            'UF_BOOK' => $Book,
            'UF_CREATED' => $Created
        );

        LendingTable::add($arValue);

    }

    public static function ViewLend()
    {
        $results = \CIBlock::GetList(
            array(),
            array(
                'CODE' => self::HBLOCK_CODE_LEND,
                'SITE_ID' => SITE_ID)
        );
        while($arElements = $results->Fetch()) {
            $elements[] = $arElements;
        }
        return $elements;
    }
}