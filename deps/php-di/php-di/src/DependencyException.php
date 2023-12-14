<?php

declare (strict_types=1);
namespace Devkit\Plugin\Deps\DI;

use Psr\Container\ContainerExceptionInterface;
/**
 * Exception for the Container.
 * @internal
 */
class DependencyException extends \Exception implements ContainerExceptionInterface
{
}
