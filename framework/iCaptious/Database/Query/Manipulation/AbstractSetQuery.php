<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 12/24/14
 * Time: 12:30 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iCaptious\Database\Query\Manipulation;

use iCaptious\Database\Query\Syntax\QueryPartInterface;

/**
 * Class AbstractSetQuery.
 */
abstract class AbstractSetQuery implements QueryInterface, QueryPartInterface
{
    /**
     * @var array
     */
    protected $union = [];

    /**
     * @param Select $select
     *
     * @return $this
     */
    public function add(Select $select)
    {
        $this->union[] = $select;

        return $this;
    }

    /**
     * @return array
     */
    public function getUnions()
    {
        return $this->union;
    }

    /**
     * @throws QueryException
     *
     * @return \iCaptious\Database\Query\Syntax\Table
     */
    public function getTable()
    {
        throw new QueryException(
            \sprintf('%s does not support tables', $this->partName())
        );
    }

    /**
     * @throws QueryException
     *
     * @return \iCaptious\Database\Query\Syntax\Where
     */
    public function getWhere()
    {
        throw new QueryException(
            \sprintf('%s does not support WHERE.', $this->partName())
        );
    }

    /**
     * @throws QueryException
     *
     * @return \iCaptious\Database\Query\Syntax\Where
     */
    public function where()
    {
        throw new QueryException(
            \sprintf('%s does not support the WHERE statement.', $this->partName())
        );
    }
}
