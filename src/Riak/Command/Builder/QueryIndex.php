<?php

namespace Start2004\Riak\Command\Builder;

use Start2004\Riak\Command;

/**
 * Used to query a secondary index in Riak.
 *
 * <code>
 * $command = (new Command\Builder\QueryIndex($riak))
 *   ->buildBucket('users')
 *   ->withIndex('users_name', 'Knuth')
 *   ->build();
 *
 * $response = $command->execute();
 *
 * $index_results = $response->getIndexResults();
 * </code>
 *
 * @author Alex Moore <amoore at basho d0t com>
 */
class QueryIndex extends Command\Builder implements Command\BuilderInterface
{
    use BucketTrait;
    use IndexTrait;

    /**
     * {@inheritdoc}
     *
     * @return Command\Indexes\Query
     * @throws Exception
     */
    public function build()
    {
        $this->validate();

        return new Command\Indexes\Query($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->required('Bucket');
        $this->required('IndexName');

        if ($this->isMatchQuery()) {
            $this->required('MatchValue');
        } else {
            $this->required('LowerBound');
            $this->required('UpperBound');
        }
    }
}
