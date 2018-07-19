<?php
/**
 * Created by PhpStorm.
 * User: maste
 * Date: 10.07.2018
 * Time: 16:58
 */

namespace my\module;

use Bitrix\Main\Entity;

class CityTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return "mymodule_city";
    }

    public static function getMap()
    {
        return array(
            //id
            new Entity\IntegerField("ID", [
                'primary' => true,
                'autocomplete' => true
            ]),
            //назвени города
            new Entity\StringField("NAME", [
                'required' => true
            ]),
            //регион
            new Entity\IntegerField("NUM_REG", [
                'required' => true
            ]),

            //получаем название региона
            new Entity\ReferenceField("REGION",
                '\my\module\RegionTable',
                ['=this.NUM_REG' => 'ref.CODE_REG']
            ),


        );
    }

}