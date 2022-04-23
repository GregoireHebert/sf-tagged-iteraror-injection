<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class TaggedServiceInjectorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $tags = $container->findTags();
        $converter = new CamelCaseToSnakeCaseNameConverter();

        foreach ($tags as $tag) {
            if (!str_starts_with($tag, 'app.')) {
                continue;
            }

            $name = $converter->denormalize(str_replace('.', '_', $tag)).'Services';
            $taggedServices = array_map(fn($serviceId) => new Reference($serviceId), array_keys($container->findTaggedServiceIds($tag)));

            $container->register($name, InjectableTaggedServices::class)
                ->setArguments([$taggedServices])
            ;

            $container->registerAliasForArgument($name, TaggedServicesInterface::class);
        }
    }
}