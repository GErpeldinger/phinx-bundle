<?php
/**
 * Released under the MIT License.
 *
 * Copyright (c) 2017 Miha Vrhovnik <miha.vrhovnik@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Umanit\PhinxBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('umanit_phinx');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('migration_base_class')->info('Replace default migration class')->end()
                ->arrayNode('adapters')
                    ->info('Replace or add migration adapters')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('paths')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('migrations')->defaultValue('%kernel.project_dir%/src/Resources/db/migrations')->end()
                        ->scalarNode('seeds')->defaultValue('%kernel.project_dir%/src/Resources/db/seeds')->end()
                    ->end()
                ->end()
                ->arrayNode('environment')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('table_prefix')->end()
                        ->scalarNode('table_suffix')->end()
                        ->scalarNode('migration_table')->end()
                        ->arrayNode('connection')
                            ->children()
                                ->scalarNode('dsn')
                                    ->isRequired()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
