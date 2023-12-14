<?php

namespace PLUGIN_NAMESPACE\Deps\Laravel\SerializableClosure\Contracts;

/** @internal */
interface Signer
{
    /**
     * Sign the given serializable.
     *
     * @param  string  $serializable
     * @return array
     */
    public function sign($serializable);
    /**
     * Verify the given signature.
     *
     * @param  array  $signature
     * @return bool
     */
    public function verify($signature);
}
