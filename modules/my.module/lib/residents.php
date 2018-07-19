<?php
/**
 * Created by PhpStorm.
 * User: maste
 * Date: 10.07.2018
 * Time: 16:58
 */

namespace my\module;

use Bitrix\Main\Entity;

class ResidentsTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return "mymodule_residents";
    }

    public static function getMap()
    {
        return array(
            //id
            new Entity\IntegerField("ID", [
                'primary' => true,
                'autocomplete' => true
            ]),
            //имя жителя
            new Entity\StringField("NAME", [
                'required' => true
            ]),
            //фамилия жителя
            new Entity\StringField("LAST_NAME"),
            //город
            new Entity\IntegerField("CITY", [
                'required' => true
            ]),
            //получаем название города
            new Entity\ReferenceField("CITY_NAME",
                '\my\module\CityTable',
                ['=this.CITY' => 'ref.ID']
            ),
            //получаем название региона
            new Entity\ReferenceField("REGION",
                '\my\module\RegionTable',
                ['=this.CITY_NAME.NUM_REG' => 'ref.CODE_REG']
            )
        );
    }

}