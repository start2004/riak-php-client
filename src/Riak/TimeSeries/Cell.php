<?php

namespace OpenAdapter\Riak\TimeSeries;

/**
 * Data structure for Cells of a TimeSeries row
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Cell
{
    const STRING_TYPE = 'varchar';
    const INT_TYPE = 'sint64';
    const DOUBLE_TYPE = 'double';
    const BOOL_TYPE = 'boolean';
    const TIMESTAMP_TYPE = 'timestamp';
    const BLOB_TYPE = 'blob';

    protected $name;
    protected $value = null;
    protected $type = null;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setBlobValue($value = null)
    {
        $this->type = self::BLOB_TYPE;
        $this->value = $value;

        return $this;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setIntValue($value = null)
    {
        if ($value != null && !\is_int($value)) {
            throw new \InvalidArgumentException('Expected an integer value.');
        }

        $this->type = self::INT_TYPE;
        $this->value = $value;

        return $this;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setTimestampValue($value = null)
    {
        if ($value != null && !\is_int($value)) {
            throw new \InvalidArgumentException('Expected an integer value.');
        }

        $this->type = self::TIMESTAMP_TYPE;
        $this->value = $value;

        return $this;
    }

    /**
     * @param \DateTime $value
     *
     * @return $this
     */
    public function setDateTimeValue($value = null)
    {
        if ($value != null && !$value instanceof \DateTime) {
            throw new \InvalidArgumentException('Expected a \DateTime object.');
        }

        $this->type = self::TIMESTAMP_TYPE;
        $this->value = $value->getTimestamp();

        return $this;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setBooleanValue($value = null)
    {
        if ($value != null && !\is_bool($value)) {
            throw new \InvalidArgumentException('Expected an boolean value.');
        }

        $this->type = self::BOOL_TYPE;
        $this->value = $value;

        return $this;
    }

    /**
     * @param double $value
     *
     * @return $this
     */
    public function setDoubleValue($value = null)
    {
        if ($value != null && !\is_float($value)) {
            throw new \InvalidArgumentException('Expected an double value.');
        }

        $this->type = self::DOUBLE_TYPE;
        $this->value = $value;

        return $this;
    }

    /**
     * Convenience method for inclusion in HTTP api path
     *
     * @return string
     */
    public function __toString()
    {
        return rawurlencode($this->getName()) . '/' . rawurlencode($this->getValue());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value = null)
    {
        $this->type = self::STRING_TYPE;
        $this->value = $value;

        return $this;
    }
}
