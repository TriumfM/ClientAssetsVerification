<?php

namespace App\Filters;


class FilterConstants
{

    const CLIENT_INCLUDES = ['brands', 'campaigns'];
    const BRAND_INCLUDES = ['client', 'campaigns'];
    const BRAND_EXACT = ['client_id'];
    const CLIENT_EXACT = ['id'];
    const CAMPAIGN_INCLUDES = ['brand', 'client'];

}
