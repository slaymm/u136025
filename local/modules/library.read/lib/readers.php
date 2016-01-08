<?php
namespace LIBRARY\READ;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages( FILE );

class ReadersTable extends Entity\DataManager
{
    public static function getFilePath()
    {
        return FILE;
    }

    /*Название таблицы HL в БД*/
    public static function getTableName()
    {
        return 't reader';
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
            'UF_ID_LEND' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => Loc::getMessage('LEND_ENTITY_ID_FIELD')
            ),
            'UF_FANAME' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => Loc::getMessage('LEND_ENTITY_UF_READ_FIELD')
            ),
            'UF_NAME' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => Loc::getMessage('LEND_ENTITY_UF_READ_FIELD')
            ),
            'UF_DADNAME' => array(
                'data_type' => 'string',
                'title' => Loc::getMessage('LEND_ENTITY_UF_READ_FIELD')
            ),
            'UF_ADRESS' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => Loc::getMessage('LEND_ENTITY_UF_READ_FIELD')
            ),
            'UF_EMAIL' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => Loc::getMessage('LEND_ENTITY_UF_READ_FIELD')
            ),
            new Entity\ReferenceField(
                'UF_ID_LEND',
                'Bitrix\Iblock\ElementTable', array('=this.UF_ID_LEND' => 'ref.ID')
            )
        );
    }
}