<?php

namespace Start2004\Riak\Command\Builder\TimeSeries;

use Start2004\Riak\Command;

/**
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class StoreRows extends Command\Builder implements Command\BuilderInterface
{
    use TableTrait;
    use RowsTrait;

    /**
     * {@inheritdoc}
     *
     * @return Command\TimeSeries\Store
     * @throws Command\Builder\Exception
     */
    public function build()
    {
        $this->validate();

        return new Command\TimeSeries\Store($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->required('Rows');
        $this->required('Table');
    }
}
