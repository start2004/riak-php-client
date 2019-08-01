<?php

namespace OpenAdapter\Riak\Command\Builder\TimeSeries;

/**
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
trait RowsTrait
{
    /**
     * Stores the rows
     *
     * @var array $rows
     */
    protected $rows = [];

    /**
     * @return array $rows
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Attach the provided rows to the Command
     *
     * @param array $rows
     *
     * @return $this
     */
    public function withRows($rows)
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * @param \OpenAdapter\Riak\TimeSeries\Cell[] $row
     *
     * @return RowsTrait
     */
    public function withRow(array $row)
    {
        $this->rows[] = $row;

        return $this;
    }
}
