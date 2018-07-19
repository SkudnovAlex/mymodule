<?

IncludeModuleLangFile(__FILE__);

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Base;
use my\module\MyModuleIndex;

Class my_module extends CModule
{

    var $MODULE_ID = "my.module";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $errors;

    function __construct()
    {
        $arModuleVersion = array();
        $this->MODULE_VERSION = "1.0.0";
        $this->MODULE_VERSION_DATE = "10.07.2018";
        $this->MODULE_NAME = "Пример модуля D7";
        $this->MODULE_DESCRIPTION = "Тестовый модуль";
        $this->PARTNER_NAME = "Александр Скуднов";
        $this->PARTNER_URI = "http://yandex.ru/";
        $this->patch = "/local/modules/my.module";
    }

    function DoInstall()
    {
        RegisterModule($this->MODULE_ID);
        $this->InstallDB();
        $this->InstallFiles();

        RegisterModuleDependences($this->MODULE_ID, "OnEntytiAddLog", $this->MODULE_ID, 'my\module\events\EventsMyModule', "OnEntytiAddLog");

        CAgent::AddAgent(
            "MyModuleAgent::AddEntity();",
            $this->MODULE_ID,
            "N",
            60);
        return true;
    }

    function DoUninstall()
    {
        global $APPLICATION;
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();
        echo "<pre>"; print_r($request['step']); echo "</pre>";
        if ($request['step'] < 2) {
            $APPLICATION->IncludeAdminFile('Удаление модуля', __DIR__.'/unstep1.php');
        }
        elseif ($request['step'] == 2) {

            $this->UnInstallFiles();

            UnRegisterModuleDependences($this->MODULE_ID, "OnEntytiAddLog", $this->MODULE_ID, 'my\module\events\EventsMyModule', "OnEntytiAddLog");

            CAgent::RemoveAgent("MyModuleAgent::AddEntity();", $this->MODULE_ID);

            if ($request['savedata'] != "Y") $this->UnInstallDB();

            UnRegisterModule($this->MODULE_ID);
            $APPLICATION->IncludeAdminFile('Удаление модуля', __DIR__.'/unstep2.php');
            return true;
        }
    }

    function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);

        $db = Application::getConnection();
        if (!$db->isTableExists(Base::getInstance('\my\module\MyModuleIndex')->getDBTableName()))
        {
            Base::getInstance('\my\module\MyModuleIndex')->createDbTable();
        }

        if (!$db->isTableExists(Base::getInstance('\my\module\region')->getDBTableName()))
        {
            Base::getInstance('\my\module\region')->createDbTable();
        }

        if (!$db->isTableExists(Base::getInstance('\my\module\city')->getDBTableName()))
        {
            Base::getInstance('\my\module\city')->createDbTable();
        }

        if (!$db->isTableExists(Base::getInstance('\my\module\residents')->getDBTableName()))
        {
            Base::getInstance('\my\module\residents')->createDbTable();
        }

        //вставляем записи
        global $DB;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . "/local/modules/my.module/install/db/insert.sql");
        if (!$this->errors) {
            return true;
        } else
            return $this->errors;

    }

    function UnInstallDB()
    {
        Loader::includeModule($this->MODULE_ID);
        $db = Application::getConnection();
        $db->queryExecute('drop table if exists '.Base::getInstance('\my\module\MyModuleIndex')->getDBTableName());
        $db->queryExecute('drop table if exists '.Base::getInstance('\my\module\region')->getDBTableName());
        $db->queryExecute('drop table if exists '.Base::getInstance('\my\module\city')->getDBTableName());
        $db->queryExecute('drop table if exists '.Base::getInstance('\my\module\residents')->getDBTableName());
        Option::delete($this->MODULE_ID);
    }

    function InstallFiles()
    {
        CopyDirFiles(
            __DIR__."/components/",
            Application::getDocumentRoot()."/local/components/",
            true,
            true
        );

        return true;
    }

    function UnInstallFiles()
    {
        Directory::deleteDirectory(
            Application::getDocumentRoot()."/local/components/".$this->MODULE_ID
        );
        return true;
    }
}
?>

