<?php
namespace LIBRARY\READ;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages( FILE );

class LendingTable extends Entity\DataManager
{
    public static function getFilePath()
    {
        return FILE;
    }

    /*Название таблицы HL в БД*/
    public static function getTableName()
    {
        return 't lending';
    }

    /*Описание полей сущности (соответсвуют полям HL DepartmentKPI)*/
    public static function getMap()
    {
        return array(
            'UF_ID' => array(
                'data_type' => 'integer',
                'required' => true,
                'autocomplete' => true,
                'title' => Loc::getMessage('LEND_ENTITY_ID_FIELD')
            ),
            'UF_READ' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => Loc::getMessage('LEND_ENTITY_UF_READ_FIELD')
            ),
            'UF_BOOK' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' =>
                    Loc::getMessage('LEND_ENTITY_UF_READ_FIELD')
            ),
            'UF_CREATED' => array(
                'data_type' => 'date',
                'required' => true,
                'title' => Loc::getMessage('LEND_ENTITY_UF_CREATED_FIELD')
            ),

            new Entity\ReferenceField(
                'UF_READ',
                'Bitrix\Iblock\ElementTable', array('=this.UF_READ' => 'ref.ID')
            ),
            new Entity\ReferenceField(
                'UF_BOOK',
                'Bitrix\Iblock\ElementTable', array('=this.UF_BOOK' => 'ref.ID')
            ),
            new Entity\ReferenceField(
                'UF_ID',
                'Bitrix\Iblock\ElementTable', array('=this.UF_ID' => 'ref.ID')
            )
        );
    }
}
