<?php
$config['upload'] = [
    "IMG" => [
        'upload_path' => FCPATH."assets/files/image/",
        'allowed_types' => 'gif|gifv|webm|ico|jpg|jpeg|svg|png|psd|tiff|tif|mp4',
        'file_ext_tolower' => TRUE,
        'encrypt_name' => TRUE,
        'max_size' => 25600,
    ],
    "DOC" => [
        'upload_path' => FCPATH."assets/files/document/",
        'allowed_types' => 'pdf|doc|docx|zip|csv|sql|ods|xls|xlsx|odt|txt',
        'file_ext_tolower' => TRUE,
        'encrypt_name' => TRUE,
        'max_size' => 25600,
    ],
];
