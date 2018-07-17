<?php
/**
 * Created by PhpStorm.
 * User: maste
 * Date: 13.07.2018
 * Time: 15:40
 */

namespace my\module\events;

use Bitrix\Main\Entity;
use CEventLog;

class EventsMyModule extends Entity\DataManager
{
    public static function OnEntytiAddLog($title){
        CEventLog::Add([
            'SEVERITY' => 'INFO',
            'AUDIT_TYPE_ID' => 'OnEntytiAdd',
            'MODULE_ID' => 'my.module',
            'DESCRIPTION' => $title,
        ]);
    }
}