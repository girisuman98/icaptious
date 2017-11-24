<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 9/12/14
 * Time: 7:15 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iCaptious\Database\Query\Builder\Syntax;

use iCaptious\Database\Query\Builder\GenericBuilder;
use iCaptious\Database\Query\Manipulation\Minus;

/**
 * Class MinusWriter.
 */
class MinusWriter
{
    /**
     * @var GenericBuilder
     */
    protected $writer;

    /**
     * @param GenericBuilder $writer
     */
    public function __construct(GenericBuilder $writer)
    {
        $this->writer = $writer;
    }

    /**
     * @param Minus $minus
     *
     * @return string
     */
    public function write(Minus $minus)
    {
        $first = $this->writer->write($minus->getFirst());
        $second = $this->writer->write($minus->getSecond());

        return $first."\n".Minus::MINUS."\n".$second;
    }
}
