<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Devkit\Plugin\Deps\Twig\TokenParser;

use Devkit\Plugin\Deps\Twig\Parser;
/**
 * Base class for all token parsers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @internal
 */
abstract class AbstractTokenParser implements TokenParserInterface
{
    /**
     * @var Parser
     */
    protected $parser;
    public function setParser(Parser $parser) : void
    {
        $this->parser = $parser;
    }
}
