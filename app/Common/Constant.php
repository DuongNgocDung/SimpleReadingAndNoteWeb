<?php
namespace App\Common;

class Constant {
    const USER_ROLES = [
        'guest'   => 0,
        'admin'   => 1,
        'manager' => 2,
        'user'    => 3
    ];

    const OS_TYPES = [
        'web'     => 'web',
        'ios'     => 'ios',
        'android' => 'android'
    ];

    const REQUEST_FAIL = 0;
    const REQUEST_SUCCESS = 1;
}