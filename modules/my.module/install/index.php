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
        $this->UnInstallDB();
        $this->UnInstallFiles();

        UnRegisterModuleDependences($this->MODULE_ID, "OnEntytiAddLog", $this->MODULE_ID, 'my\module\events\EventsMyModule', "OnEntytiAddLog");

        CAgent::RemoveAgent("MyModuleAgent::AddEntity();", $this->MODULE_ID);

        UnRegisterModule($this->MODULE_ID);
        return true;
    }

    function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);

        $db = Application::getConnection();
        if (!$db->isTableExists(Base::getInstance('\my\module\MyModuleIndex')->getDBTableName()))
        {
            Base::getInstance('\my\module\MyModuleIndex')->createDbTable();
        }

//        global $DB;
//        $this->errors = false;
//        $this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . "/local/modules/my.module/install/db/install.sql");
//        if (!$this->errors) {
//
//            return true;
//        } else
//            return $this->errors;

    }

    function UnInstallDB()
    {
        Loader::includeModule($this->MODULE_ID);
        $db = Application::getConnection();
        $db->queryExecute('drop table if exists '.Base::getInstance('\my\module\MyModuleIndex')->getDBTableName());
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

