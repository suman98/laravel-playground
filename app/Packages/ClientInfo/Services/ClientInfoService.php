<?php

namespace App\Packages\ClientInfo\Services;

use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Request;

class ClientInfoService
{
    public function getData()
    {
        return [
            'ip' => Request::ip(),
            'device' => Agent::device(),
            'platform' => Agent::platform(),
            'platform_version' => Agent::version(Agent::platform()),
            'browser' => Agent::browser(),
            'browser_version' => Agent::version(Agent::browser()),
            'is_mobile' => Agent::isMobile(),
            'is_tablet' => Agent::isTablet(),
            'is_desktop' => Agent::isDesktop(),
            'is_phone' => Agent::isPhone(),
            'is_robot' => Agent::isRobot(),
            'robot' => Agent::robot(),
            'languages' => Agent::languages(),
            'user_agent' => Agent::getUserAgent(),
        ];
    }
}
