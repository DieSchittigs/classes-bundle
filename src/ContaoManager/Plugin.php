<?php

declare(strict_types=1);

namespace DieSchittigs\ClassesBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use DieSchittigs\ClassesBundle\ContaoClassesBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoClassesBundle::class)
                ->setLoadAfter([
                    'Contao\CoreBundle\ContaoCoreBundle'
                ]),
        ];
    }
}
