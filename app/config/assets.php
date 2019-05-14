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
	'version'=>'0.0.1',
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
					'url'=>'https://use.fontawesome.com/releases/v5.8.2/css/all.css',
					'integrity'=>'sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay',
					'crossorigin'=>'anonymous',
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
