<?php
/**
 * Auto generated from riak.proto at 2016-09-24 09:49:42
 *
 * Start2004\Riak\Api\Pb\Message package
 */
namespace Start2004\Riak\Api\Pb\Message\RpbBucketProps {
/**
 * RpbReplMode enum embedded in RpbBucketProps message
 */
final class RpbReplMode
{
    const FALSE = 0;
    const REALTIME = 1;
    const FULLSYNC = 2;
    const TRUE = 3;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'FALSE' => self::FALSE,
            'REALTIME' => self::REALTIME,
            'FULLSYNC' => self::FULLSYNC,
            'TRUE' => self::TRUE,
        );
    }
}
}