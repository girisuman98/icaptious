<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/3/14
 * Time: 12:07 AM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iCaptious\Database\Query\Manipulation;

/**
 * Interface QueryInterface.
 */
interface QueryInterface
{
    /**
     * @return string
     */
    public function partName();

    /**
     * @return \iCaptious\Database\Query\Syntax\Table
     */
    public function getTable();

    /**
     * @return \iCaptious\Database\Query\Syntax\Where
     */
    public function getWhere();

    /**
     * @return \iCaptious\Database\Query\Syntax\Where
     */
    public function where();
}
