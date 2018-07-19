<?php
/**
 * Created by PhpStorm.
 * User: maste
 * Date: 10.07.2018
 * Time: 16:58
 */

namespace my\module;

use Bitrix\Main\Entity;

class RegionTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return "mymodule_region";
    }

    public static function getMap()
    {
        return array(
            //id
            new Entity\IntegerField("ID", [
                'primary' => true,
                'autocomplete' => true
            ]),
            //назвени региона
            new Entity\StringField("NAME", [
                'required' => true
            ]),
            //регион
            new Entity\IntegerField("CODE_REG", [
                'required' => true
            ]),
        );
    }

}