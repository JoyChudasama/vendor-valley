<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Vendor;

class UserVendorHelper
{
    public function __construct()
    {
    }

    public function setUpVendor(User $user)
    {
        if (!$user->getBecomeVendor() || $user->getVendor()) return;

        $vendor = new Vendor();
        $vendor->setName("{$user->getFirstName()}'s Business");
        $vendor->setUser($user);

        $user->setVendor($vendor);
    }
}
