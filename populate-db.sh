#!/bin/bash
php bin/console app:create-10-users-with-vendor
php bin/console doctrine:fixtures:load --no-interaction --purge-exclusions=user --purge-exclusions=vendor  --purge-exclusions=user_customer