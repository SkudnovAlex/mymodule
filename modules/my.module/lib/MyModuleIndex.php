<?php
/**
 * Created by PhpStorm.
 * User: maste
 * Date: 10.07.2018
 * Time: 16:58
 */

namespace my\module;

use Bitrix\Main\Entity;

class MyModuleIndexTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return "mymodule_index";
    }

    public static function getMap()
    {
        return array(
            //id
            new Entity\IntegerField("ID", [
                'primary' => true,
                'autocomplete' => true
            ]),
            //title
            new Entity\StringField("TITLE", [
                'required' => true
            ]),
            //date create
            new Entity\DatetimeField("DATE_CREATE"),
        );
    }

}