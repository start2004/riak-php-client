<?php

namespace Start2004\Riak\Command\Builder;

use Start2004\Riak\Command;

/**
 * @author Luke Bakken <lbakken@basho.com>
 */
class UpdateHll extends Command\Builder implements Command\BuilderInterface
{
    use LocationTrait;

    /**
     * @var array
     */
    protected $add_all = [];

    /**
     * Similar to Vector Clocks, the context allows us to determine the state of a CRDT Hll
     *
     * @var string
     */
    protected $context = '';

    /**
     * @param mixed $element
     *
     * @return $this
     */
    public function add($element)
    {
        $this->add_all[] = (string)$element;

        return $this;
    }

    /**
     * @return array
     */
    public function getAddAll()
    {
        return $this->add_all;
    }

    /**
     * {@inheritdoc}
     *
     * @return Command\DataType\Hll\Store
     * @throws Exception
     */
    public function build()
    {
        $this->validate();

        return new Command\DataType\Hll\Store($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->required('Bucket');

        $count_add = \count($this->add_all);
        if ($count_add < 1) {
            throw new Exception('At least one element to add must be defined.');
        }
    }
}
