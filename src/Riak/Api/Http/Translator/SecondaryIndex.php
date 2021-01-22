<?php

namespace Start2004\Riak\Api\Http\Translator;

/**
 * @author Alex Moore <amoore at basho d0t com>
 */
class SecondaryIndex
{
    private const INT_INDEX_SUFFIX = '_int';
    private const STR_IDX_SUFFIX = '_bin';
    private const IDX_SUFFIX_LEN = 4;
    private const IDX_HEADER_PREFIX = 'x-riak-index-';
    private const IDX_HEADER_PREFIX_LEN = 13;

    public static function isIntIndex($headerKey)
    {
        return static::indexNameContainsTypeSuffix($headerKey, self::INT_INDEX_SUFFIX);
    }

    private static function indexNameContainsTypeSuffix($indexName, $typeSuffix)
    {
        $nameLen = \strlen($indexName) - self::IDX_SUFFIX_LEN;

        return substr_compare($indexName, $typeSuffix, $nameLen) == 0;
    }

    public function extractIndexesFromHeaders(&$headers)
    {
        $indexes = [];
        foreach ($headers as $key => $value) {
            if (!self::isIndexHeader($key)) {
                continue;
            }

            $this->parseIndexHeader($indexes, $key, $value);
            unset($headers[$key]);
        }

        return $indexes;
    }

    public static function isIndexHeader($headerKey)
    {
        if (\strlen($headerKey) <= self::IDX_HEADER_PREFIX_LEN) {
            return false;
        }

        return substr_compare($headerKey, self::IDX_HEADER_PREFIX, 0, self::IDX_HEADER_PREFIX_LEN) == 0;
    }

    private function parseIndexHeader(&$indexes, $key, $rawValue)
    {
        $indexName = $this->getIndexNameWithType($key);
        $value = $this->getIndexValue($indexName, $rawValue);

        $indexes[$indexName] = $value;
    }

    private function getIndexNameWithType($key)
    {
        return substr($key, self::IDX_HEADER_PREFIX_LEN);
    }

    private function getIndexValue($indexName, $value)
    {
        $values = explode(', ', $value);

        if (self::isStringIndex($indexName)) {
            return $values;
        }

        return array_map('\intval', $values);
    }

    public static function isStringIndex($headerKey)
    {
        return static::indexNameContainsTypeSuffix($headerKey, self::STR_IDX_SUFFIX);
    }

    public function createHeadersFromIndexes($indexes)
    {
        $headers = [];

        foreach ($indexes as $indexName => $values) {
            $this->createIndexHeader($headers, $indexName, $values);
        }

        return $headers;
    }

    private function createIndexHeader(&$headers, $indexName, $values)
    {
        $headerKey = self::IDX_HEADER_PREFIX . $indexName;
        foreach ($values as $index => $value) {
            $headers[] = [$headerKey, $value];
        }
    }
}
