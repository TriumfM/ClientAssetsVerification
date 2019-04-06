<?php

namespace App\Filters;


class FilterConstants
{

    const CLIENT_INCLUDES = ['brands', 'campaigns'];
    const BRAND_INCLUDES = ['client', 'campaigns'];
    const CAMPAIGN_INCLUDES = ['brand', 'client'];

}