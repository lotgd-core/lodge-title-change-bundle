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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('lotgd_lodge_title_change');

        $treeBuilder->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('cost')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('first')
                            ->defaultValue(5000)
                            ->info('How many donator points needed to get first title change?')
                        ->end()
                        ->integerNode('other')
                            ->defaultValue(25)
                            ->info('How many additional donator points needed for subsequent title changes?')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('allowed')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('bold')
                            ->defaultValue(true)
                            ->info('Can use bold for title changes?')
                        ->end()
                        ->booleanNode('italic')
                            ->defaultValue(true)
                            ->info('Can use italic for title changes?')
                        ->end()
                        ->booleanNode('blank')
                            ->defaultValue(true)
                            ->info('Can use blank title?')
                        ->end()
                        ->booleanNode('spaces')
                            ->defaultValue(true)
                            ->info('Can use spaces for title changes?')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
