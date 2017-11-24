<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/11/14
 * Time: 1:51 AM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iCaptious\Database\Query\Builder\Syntax;

use iCaptious\Database\Query\Builder\GenericBuilder;
use iCaptious\Database\Query\Manipulation\Insert;
use iCaptious\Database\Query\Manipulation\QueryException;

/**
 * Class InsertWriter.
 */
class InsertWriter
{
    /**
     * @var GenericBuilder
     */
    protected $writer;

    /**
     * @var ColumnWriter
     */
    protected $columnWriter;

    /**
     * @param GenericBuilder    $writer
     * @param PlaceholderWriter $placeholder
     */
    public function __construct(GenericBuilder $writer, PlaceholderWriter $placeholder)
    {
        $this->writer = $writer;
        $this->columnWriter = WriterFactory::createColumnWriter($this->writer, $placeholder);
    }

    /**
     * @param Insert $insert
     *
     * @throws QueryException
     *
     * @return string
     */
    public function write(Insert $insert)
    {
        $columns = $insert->getColumns();

        if (empty($columns)) {
            throw new QueryException('No columns were defined for the current schema.');
        }

        $columns = $this->writeQueryColumns($columns);
        $values = $this->writeQueryValues($insert->getValues());
        $table = $this->writer->writeTable($insert->getTable());
        $comment = AbstractBaseWriter::writeQueryComment($insert);

        return $comment."INSERT INTO {$table} ($columns) VALUES ($values)";
    }

    /**
     * @param $columns
     *
     * @return string
     */
    protected function writeQueryColumns($columns)
    {
        return $this->writeCommaSeparatedValues($columns, $this->columnWriter, 'writeColumn');
    }

    /**
     * @param $collection
     * @param $writer
     * @param string $method
     *
     * @return string
     */
    protected function writeCommaSeparatedValues($collection, $writer, $method)
    {
        \array_walk(
            $collection,
            function (&$data) use ($writer, $method) {
                $data = $writer->$method($data);
            }
        );

        return \implode(', ', $collection);
    }

    /**
     * @param $values
     *
     * @return string
     */
    protected function writeQueryValues($values)
    {
        return $this->writeCommaSeparatedValues($values, $this->writer, 'writePlaceholderValue');
    }
}
