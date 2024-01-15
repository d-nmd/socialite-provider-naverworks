<?php

namespace SocialiteProviders\NaverWorks;

use SocialiteProviders\Manager\SocialiteWasCalled;

class NaverWorksExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled): void
    {
        $socialiteWasCalled->extendSocialite('naverworks', Provider::class);
    }
}
