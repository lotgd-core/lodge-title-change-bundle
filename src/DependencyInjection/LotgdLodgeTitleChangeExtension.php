<?php

/**
 * This file is part of "LoTGD Bundle Lodge Title Change".
 *
 * @see https://github.com/lotgd-core/lodge-title-change-bundle
 *
 * @license https://github.com/lotgd-core/lodge-title-change-bundle/blob/master/LICENSE.txt
 * @author IDMarinas
 *
 * @since 0.1.0
 */

namespace Lotgd\Bundle\LodgeTitleChangeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class LotgdLodgeTitleChangeExtension extends ConfigurableExtension
{
    public function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new PhpFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));

        $loader->load('services.php');

        // dump($mergedConfig);

        $container->setParameter('lotgd_bundle.lodge_title_change.cost.first', $mergedConfig['cost']['first']);
        $container->setParameter('lotgd_bundle.lodge_title_change.cost.other', $mergedConfig['cost']['other']);
        $container->setParameter('lotgd_bundle.lodge_title_change.allowed.bold', $mergedConfig['allowed']['bold']);
        $container->setParameter('lotgd_bundle.lodge_title_change.allowed.italic', $mergedConfig['allowed']['italic']);
        $container->setParameter('lotgd_bundle.lodge_title_change.allowed.blank', $mergedConfig['allowed']['blank']);
        $container->setParameter('lotgd_bundle.lodge_title_change.allowed.spaces', $mergedConfig['allowed']['spaces']);
    }
}
