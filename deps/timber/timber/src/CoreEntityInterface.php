<?php

namespace PLUGIN_NAMESPACE\Deps\Timber;

/**
 * Interface CoreEntityInterface
 * @internal
 */
interface CoreEntityInterface
{
    /**
     * Gets the underlying WordPress Core object.
     *
     * @since 2.0.0
     *
     * @return object|null
     */
    public function wp_object();
    /**
     * Checks whether the current user can edit the object.
     *
     * @return bool
     */
    public function can_edit() : bool;
}
