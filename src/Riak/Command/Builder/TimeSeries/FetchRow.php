<?php

namespace OpenAdapter\Riak\Command\Builder\TimeSeries;

use OpenAdapter\Riak\Command;

/**
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class FetchRow extends Command\Builder implements Command\BuilderInterface
{
    use TableTrait;
    use KeyTrait;

    /**
     * {@inheritdoc}
     *
     * @return Command\TimeSeries\Store
     * @throws Command\Builder\Exception
     */
    public function build()
    {
        $this->validate();

        return new Command\TimeSeries\Fetch($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->required('Key');
        $this->required('Table');
    }
}
