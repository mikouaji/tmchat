<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/15/19
 * Time: 12:11 PM
 */
$config = [
	'error_prefix'=>'<div class="small text-danger">',
	'error_suffix'=>'</div>',
    'login' => [
        [
            'field' => 'login',
            'label' => 'login',
            'rules' => 'trim|required',
            'errors' => [
                'required'=>'Field required.',
            ],
        ],
        [
            'field' => 'password',
            'label' => 'password',
            'rules' => 'trim|required',
            'errors' => [
                'required'=>'Field required.'
            ],
        ],
    ],
];
