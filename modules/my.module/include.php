<?php
/**
 * Created by PhpStorm.
 * User: maste
 * Date: 13.07.2018
 * Time: 16:29
 */

//namespace my\module\MyModuleAgent;

use my\module\MyModuleIndexTable;
use Bitrix\Main\Type;
use my\module\events\EventsMyModule;

Class MyModuleAgent
{
    function AddEntity()
    {
        $date = date('Y-m-d H:i:s');
        $result = MyModuleIndexTable::add([
            'TITLE' => 'Запись добавлена Агентом на Хитах',
            'DATE_CREATE' => new Type\DateTime($date, 'Y-m-d H:i:s'),
        ]);
        if ($result->isSuccess()){
            $resId = $result->isSuccess();
            EventsMyModule::OnEntytiAddLog('Добавлена запись '.$result->getId().' Агентом');
        } else {
            $error = $result->getErrorMessages();
            EventsMyModule::OnEntytiAddLog('При добавлении записи Агентом произошла ошибка '.$error);
        }
        return "MyModuleAgent::AddEntity();";
    }
}

