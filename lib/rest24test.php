<?php

namespace Company\Rest24;

use \Bitrix\Main\UserTable as User;

class Rest24Test extends \Bitrix\Main\Engine\Controller
{
    public static function getUserNameVowels($query, $nav, \CRestServer $server)
    {
        $names = '';
        $result = User::getById($query['id']);
        while ($arUser = $result->fetch()) {
            $names = $arUser['NAME'] . $arUser['SECOND_NAME'] . $arUser['LAST_NAME'];
        }
        preg_match_all('/[aeiouаяуюоеёэиы]/i', $names, $matches);

        return array('yourquery' => $query, 'myresponse' => implode("", $matches[0]));
    }


    public static function OnRestServiceBuildDescription()
    {
        return array(
            'rest24test' => array(
                'get.username.vowels' => array(
                    'callback' => array(__CLASS__, 'getUserNameVowels'),
                    'options' => array(),
                ),
            )
        );
    }

}