<?php

namespace App\Faker;

use App\Repository\UserRepository;
use App\Repository\VendorRepository;
use Faker\Provider\Base as BaseProvider;

final class EntityProvider extends BaseProvider
{
    public function __construct(private VendorRepository $vendorRepository)
    {
    }

    public function getRandomVendor()
    {
        return $this->getRandomElement($this->vendorRepository->findAll());
    }

    private function getRandomElement(array $array)
    {
        if ($array) {
            $randomKey = array_rand($array);

            return $array[$randomKey];
        }
    }
}
