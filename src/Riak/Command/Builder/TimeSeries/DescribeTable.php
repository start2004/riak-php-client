<?php

namespace Start2004\Riak\Command\Builder\TimeSeries;

use Start2004\Riak\Command;

/**
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class DescribeTable extends Command\Builder\TimeSeries\Query
{
    /**
     * Which table do you want to describe?
     *
     * @param $table
     *
     * @return $this
     */
    public function withTable($table)
    {
        if ($table) {
            $this->query = "DESCRIBE {$table}";
        }

        return $this;
    }
}
