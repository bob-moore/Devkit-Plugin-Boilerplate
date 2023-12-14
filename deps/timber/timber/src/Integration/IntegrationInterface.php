<?php

namespace PLUGIN_NAMESPACE\Deps\Timber\Integration;

/**
 * Timber\Integration\IntegrationInterface
 *
 * This is for integrating external plugins into Timber
 * @internal
 */
interface IntegrationInterface
{
    public function should_init() : bool;
    public function init() : void;
}
