<?php

namespace Start2004\Riak\Command\Builder;

use Start2004\Riak\Command;

/**
 * Used to increment counter objects in Riak by the provided positive / negative integer
 *
 * <code>
 * $command = (new Command\Builder\IncrementCounter($riak))
 *   ->buildLocation($user_name, 'user_visit_count', 'visit_counters')
 *   ->build();
 *
 * $response = $command->execute();
 *
 * $counter = $response->getCounter();
 * </code>
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class IncrementCounter extends Command\Builder implements Command\BuilderInterface
{
    use LocationTrait;

    /**
     * @var int|null
     */
    protected $increment = null;

    /**
     * {@inheritdoc}
     *
     * @return Command\DataType\Counter\Store
     * @throws Exception
     */
    public function build()
    {
        $this->validate();

        return new Command\DataType\Counter\Store($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->required('Bucket');
        $this->required('Increment');
    }

    /**
     * @param int $increment
     *
     * @return $this
     */
    public function withIncrement($increment = 1)
    {
        $this->increment = $increment;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getIncrement()
    {
        return $this->increment;
    }
}
