<?php

declare (strict_types=1);
namespace PLUGIN_NAMESPACE\Deps\Invoker;

use PLUGIN_NAMESPACE\Deps\Invoker\Exception\InvocationException;
use PLUGIN_NAMESPACE\Deps\Invoker\Exception\NotCallableException;
use PLUGIN_NAMESPACE\Deps\Invoker\Exception\NotEnoughParametersException;
/**
 * Invoke a callable.
 * @internal
 */
interface InvokerInterface
{
    /**
     * Call the given function using the given parameters.
     *
     * @param callable|array|string $callable Function to call.
     * @param array $parameters Parameters to use.
     * @return mixed Result of the function.
     * @throws InvocationException Base exception class for all the sub-exceptions below.
     * @throws NotCallableException
     * @throws NotEnoughParametersException
     */
    public function call($callable, array $parameters = []);
}
