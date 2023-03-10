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
    'settings'=>[
        [
            'field' => 'login',
            'label' => 'login',
            'rules' => 'trim|required',
            'errors' => [
                'required'=>'field required'
            ],
        ],
        [
            'field' => 'password',
            'label' => 'password',
            'rules' => 'trim',
            'errors' => [
                'required'=>'field required'
            ],
        ],
        [
            'field' => 'password_repeat',
            'label' => 'password_repeat',
            'rules' => 'trim|matches[password]',
            'errors' => [
                'matches'=>'passwords must match'
            ],
        ],
        [
            'field' => 'remember',
            'label' => 'remember',
            'rules' => '',
            'errors' => [],
        ],
    ],
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
    'attachment' => [
        [
            'field' => 'label',
            'label' => 'label',
            'rules' => 'trim|required',
            'errors' => [
                'required'=>'attachment label required',
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
