<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class LogsAndNotifications extends BaseConfig
{    
	public $NotificationChanels			= "telegram, slack"; // this variable is a string to able to override it in .env file. Put all options per coma"
    public $TelegramApiToken     		= "5946341267:AAEzD3rt9Uq30QPjzofcAidCTMY2JMZGzhw";
	public $TelegramChatIds				= ""; // 875248296 (@scanterkk), 544010066 (@samba33)
}