<?php

declare(strict_types=1);

use App\Application\Entity\CertificationEntity;
use App\Application\Repository\CertificationRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        CertificationEntity::class => \DI\autowire(CertificationRepository::class),
    ]);
};
