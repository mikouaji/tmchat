<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/15/19
 * Time: 12:11 PM
 */
$config = [
	'error_prefix'=>'<small class="bg-danger p-1">',
	'error_suffix'=>'</small>',
    'login' => [
        [
            'field' => 'login',
            'label' => 'login',
            'rules' => 'trim|required',
            'errors' => [
                'required'=>'field required',
            ],
        ],
        [
            'field' => 'password',
            'label' => 'password',
            'rules' => 'trim|required',
            'errors' => [
                'required'=>'field required'
            ],
        ],
    ],
    'addTopic' => [
        [
            'field' => 'name',
            'label' => 'name',
            'rules' => 'trim|required|uniqueTopicName',
            'errors' => [
                'required'=>'field required',
                'uniqueTopicName'=>'this topic already exists',
            ],
        ],
    ],
];
