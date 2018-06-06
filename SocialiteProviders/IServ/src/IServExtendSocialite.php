<?php

namespace SocialiteProviders\IServ;

use SocialiteProviders\Manager\SocialiteWasCalled;

class IServExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('iserv', __NAMESPACE__.'\Provider');
    }
}
