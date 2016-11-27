<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
date_default_timezone_set('Europe/Warsaw');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'API APP YII',
	'language'=>'pl',

	// preloading 'log' component
	'preload'=>array(
		'bootstrap',
		'log'
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.bootstrap.*',
		'ext.mpgii.*',
		'ext.bootstrap.widgets.*',
	),
	'theme'=>'classic',
	'defaultController'=>'api',
	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'xsw23edc',
			'generatorPaths' =>array('ext.mpgii'),
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),
		),
	),

	// application components
	'components'=>array(
		'request'=>array(
            'enableCookieValidation'=>true,
        ),
        'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				//API RULES
				'' => 'api/index',
				'cities'=>'api/cities',

        		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'sqlite:protected/data/api.db',
			'tablePrefix' => 'tbl_',
		),
		'bootstrap'=>array(
            'class'=>'ext.bootstrap.components.Bootstrap',
            'responsiveCss'=>true
        ),

		'errorHandler'=>array(
			'errorAction'=>'api/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
				// array(
				// 	'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
				// 	'ipFilters' => array('127.0.0.1'),// Access is restricted by default to the localhost
				// ),
			),
		),
	),
);