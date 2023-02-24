<?
//подключаем основные классы для работы с модулем
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
//в данном модуле создадим адресную книгу, и здесь мы подключаем класс, который создаст нам эту таблицу

Loc::loadMessages(__FILE__);
//в названии класса пишем название директории нашего модуля, только вместо точки ставим нижнее подчеркивание
class company_rest24 extends CModule
{
    public function __construct()
    {
        $arModuleVersion = array();
				//подключаем версию модуля (файл будет следующим в списке)
        include __DIR__ . '/version.php';
				//присваиваем свойствам класса переменные из нашего файла
        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
				//пишем название нашего модуля как и директории
        $this->MODULE_ID = 'company.rest24';
        // название модуля
        $this->MODULE_NAME = Loc::getMessage('MYMODULE_MODULE_NAME');
        //описание модуля
        $this->MODULE_DESCRIPTION = Loc::getMessage('MYMODULE_MODULE_DESCRIPTION');
        //используем ли индивидуальную схему распределения прав доступа, мы ставим N, так как не используем ее
        $this->MODULE_GROUP_RIGHTS = 'N';
        //название компании партнера предоставляющей модуль
        $this->PARTNER_NAME = Loc::getMessage('MYMODULE_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = 'https://вашсайт';//адрес вашего сайта
    }
    //здесь мы описываем все, что делаем до инсталляции модуля, мы добавляем наш модуль в регистр и вызываем метод создания таблицы
    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $eventManager = \Bitrix\Main\EventManager::getInstance(); 
		$eventManager ->registerEventHandler(
			'rest',
			'OnRestServiceBuildDescription',
			$this->MODULE_ID,
			'Company\Rest24\Rest24Test',
			'OnRestServiceBuildDescription'
		);
    }

    public function doUninstall()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance(); 

		$eventManager ->unRegisterEventHandler(
			'rest',
			'OnRestServiceBuildDescription',
			$this->MODULE_ID,
            'Company\Rest24\Rest24Test',
			'OnRestServiceBuildDescription'
		);
		ModuleManager::unRegisterModule($this->MODULE_ID);
    }

}