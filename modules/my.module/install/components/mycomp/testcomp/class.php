<?php
/**
 * Created by PhpStorm.
 * User: maste
 * Date: 10.07.2018
 * Time: 15:13
 */
use Bitrix\Main\Loader;
use my\module\MyModuleIndexTable;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Data\Cache;


class ModuleClass extends CBitrixComponent {

    var $cssBootstrap = '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">';
    var $jsBootstrap = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>';
    var $cacheTime = "3600";

    public function checkModules ()
    {
        if(!Loader::includeModule('my.module')){
            ShowError('Модуль не загружен');
            return false;
        };
        return true;
    }

    public function executeComponent()
    {
        if ($this->checkModules()) {

            Asset::getInstance()->addString($this->cssBootstrap);
            Asset::getInstance()->addString($this->jsBootstrap);

            $сache = Cache::createInstance();
            if ($сache->initCache($this->cacheTim))
            {
                $result = $сache->getVars();
                $this->arResult = $result;
            }
            elseif ($сache->startDataCache())
            {

                $nav = new \Bitrix\Main\UI\PageNavigation("nav-more-news");
                $nav->allowAllRecords(true)
                    ->setPageSize(5)
                    ->initFromUri();

                $obRes = MyModuleIndexTable::getList([
                    'select' => ['*'],
                    'order' => ['ID' => 'DESC'],
                    "count_total" => true,
                    "offset" => $nav->getOffset(),
                    "limit" => $nav->getLimit(),
                ]);

                $nav->setRecordCount($obRes->getCount());

                while ($res = $obRes->fetch()) {
                    $this->arResult[] = [
                        'ID' => $res['ID'],
                        'TITLE' => $res['TITLE'],
                        'DATE_CREATE' => $res['DATE_CREATE']->toString(),
                    ];
                }


                $сache->endDataCache($this->arResult);

            }

            $this->includeComponentTemplate();

        }
    }

}