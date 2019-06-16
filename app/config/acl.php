<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/13/19
 * Time: 3:54 PM
 */

$config['acl'] = [
	'enabled'=>TRUE,
	'default_redirect'=>'/',
	'rules'=>[
//		'controller1'=>[
//			'action1'=>[
//				'allow'=>['group1', 'group2', 'group3'],
//				'redirect'=>'controller/action'
//			],
//			'action2'=>...
//		],
		'home'=>[
			'index'=>[
				'allow'=>['GUEST'],
                'redirect'=>'chat',
			],
		],
        'chat'=>[
            'index'=>[
                'allow'=>['MEMBER', 'ADMIN'],
            ],
            'settings'=>[
                'allow'=>['MEMBER', 'ADMIN'],
            ],
            'upload'=>[
                'allow'=>['MEMBER', 'ADMIN'],
            ],
            'logout'=>[
                'allow'=>['MEMBER', 'ADMIN'],
            ],
        ],
        'api'=>[
            'get'=>[
                'allow'=>['MEMBER', 'ADMIN'],
                'redirect'=>'api/error'
            ],
            'put'=>[
                'allow'=>['MEMBER', 'ADMIN'],
                'redirect'=>'api/error'
            ],
        ]
	],
];
