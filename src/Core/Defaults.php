<?php

namespace Ligdicash\Core\Defaults;

function get_platform_url($platform)
{
    if ($platform === 'live') {
        return 'https://app.ligdicash.com/pay/v01/';
    } else {
        return 'https://test.ligdicash.com/pay/v01/';
    }
}