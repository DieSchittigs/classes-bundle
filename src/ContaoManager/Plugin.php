<?php

declare(strict_types=1);

namespace DieSchittigs\ContaoClassesBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {

        return [
            BundleConfig::create('DieSchittigs\ContaoClassesBundle\ContaoClassesBundle')
                ->setLoadAfter(['Contao\CoreBundle\ContaoCoreBundle', 'DieSchittigs\ContaoWrapperBundle\ContaoWrapperBundle'])
        ];
    }
}
