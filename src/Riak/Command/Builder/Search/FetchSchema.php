<?php

namespace Start2004\Riak\Command\Builder\Search;

use Start2004\Riak\Command;

/**
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class FetchSchema extends Command\Builder implements Command\BuilderInterface
{
    protected $schema_name = '';

    /**
     * @return string
     */
    public function getSchemaName()
    {
        return $this->schema_name;
    }

    /**
     * {@inheritdoc}
     *
     * @return Command\Search\Schema\Fetch;
     * @throws Command\Builder\Exception
     */
    public function build()
    {
        $this->validate();

        return new Command\Search\Schema\Fetch($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->required('SchemaName');
    }

    public function withName($name)
    {
        $this->schema_name = $name;

        return $this;
    }
}
