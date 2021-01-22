<?php

namespace Start2004\Riak\Command\Builder;

use Start2004\Riak\Command;

/**
 * Used to fetch map objects from Riak
 *
 * <code>
 * $command = (new Command\Builder\FetchMap($riak))
 *   ->buildLocation($order_id, 'online_orders', 'sales_maps')
 *   ->build();
 *
 * $response = $command->execute();
 *
 * $map = $response->getMap();
 * </code>
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class FetchBucketProperties extends Command\Builder implements Command\BuilderInterface
{
    use BucketTrait;

    /**
     * {@inheritdoc}
     *
     * @return Command\Bucket\Fetch;
     * @throws Exception
     */
    public function build()
    {
        $this->validate();

        return new Command\Bucket\Fetch($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->required('Bucket');
    }
}
