<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/6/19
 * Time: 3:07 PM
 */

$config['assets']=[
	'minifyCSS'=>TRUE,
	'minifyJS'=>FALSE,
	'requireJS'=>TRUE,
	'version'=>'0.24.5',
	'styles'=>[
		'default'=>[
			'dir'=>'assets/css',
			'local'=>[
				[
					'url'=>'bootstrap.min.css',
					'integrity'=>NULL,
					'crossorigin'=>NULL,
				],
				[
					'url'=>'style.css',
					'integrity'=>NULL,
					'crossorigin'=>NULL,
				],
			],
			'remote'=>[
				[
					'url'=>'https://fonts.googleapis.com/css?family=Cutive+Mono',
					'integrity'=>NULL,
					'crossorigin'=>NULL,
				],
			],
		],
		'editor'=>[
			'dir'=>"assets/css",
			'local'=>[],
			'remote'=>[],
		],
	],
	'scripts'=>[
		'default'=>[
			'dir'=>'assets/js',
			'local'=>[
				[
					'url'=>'lib/require.js',
					'main'=>'../assets/js/common',
				],
			],
			'remote'=>[

			],
		],
	],
];
