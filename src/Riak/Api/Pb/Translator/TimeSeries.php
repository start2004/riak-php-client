<?php

namespace Start2004\Riak\Api\Pb\Translator;

use Start2004\Riak\Api\Pb\Message\TsCell;
use Start2004\Riak\Api\Pb\Message\TsColumnDescription;
use Start2004\Riak\Api\Pb\Message\TsColumnType;
use Start2004\Riak\TimeSeries\Cell;
use Start2004\Riak\Api\Pb\Message\RpbPair;
use Start2004\Riak\Api\Pb\Message\TsInterpolation;
use Start2004\Riak\Api\Pb\Message\TsRow;

class TimeSeries
{
    /**
     * Converts a core lib Cell to a TS PB Cell
     *
     * @param Cell $cell
     * @return TsCell
     */
    public static function toPbCell(Cell $cell)
    {
        $tsCell = new TsCell();
        switch ($cell->getType()) {
            case Cell::INT_TYPE:
                $tsCell->setSint64Value($cell->getValue());
                break;
            case Cell::DOUBLE_TYPE:
                $tsCell->setDoubleValue($cell->getValue());
                break;
            case Cell::TIMESTAMP_TYPE:
                $tsCell->setTimestampValue($cell->getValue());
                break;
            case Cell::BOOL_TYPE:
                $tsCell->setBooleanValue($cell->getValue());
                break;
            case Cell::BLOB_TYPE:
                if (is_null($cell->getValue())) {
                    $tsCell->setVarcharValue('');
                    break;
                }
            default:
                $tsCell->setVarcharValue($cell->getValue());
        }

        return $tsCell;
    }

    /**
     * Converts a TS PB Cell to a core lib Cell
     *
     * @param TsColumnDescription $column
     * @param TsCell $tsCell
     * @return Cell
     */
    public static function fromPbCell(TsColumnDescription $column, TsCell $tsCell)
    {
        $cell = new Cell($column->getName());

        switch($column->getType()) {
            case TsColumnType::BOOLEAN:
                $cell->setBooleanValue($tsCell->getBooleanValue());
                break;
            case TsColumnType::BLOB:
                $cell->setBlobValue($tsCell->getVarcharValue());
                break;
            case TsColumnType::SINT64:
                $cell->setIntValue($tsCell->getSint64Value());
                break;
            case TsColumnType::DOUBLE:
                $cell->setDoubleValue($tsCell->getDoubleValue());
                break;
            case TsColumnType::TIMESTAMP:
                $cell->setTimestampValue($tsCell->getTimestampValue());
                break;
            default:
                $cell->setValue($tsCell->getVarcharValue());
                break;
        }

        return $cell;
    }

    /**
     * Converts a core lib Row to a TS PB Row
     *
     * @param Cell[] $row
     * @return TsRow
     */
    public static function toPbRow(array $row)
    {
        $tsRow = new TsRow();

        foreach($row as $cell) {
            $tsRow->appendCells(static::toPbCell($cell));
        }

        return $tsRow;
    }

    /**
     * Converts a TS PB Row to a core lib Row
     *
     * @param TsRow $tsRow
     * @param TsColumnDescription[] $columns
     * @return \Start2004\Riak\TimeSeries\Cell[]
     */
    public static function fromPbRow(TsRow $tsRow, array $columns)
    {
        $row = [];

        foreach($tsRow->getCells() as $index => $cell) {
            $row[] = static::fromPbCell($columns[$index], $cell);
        }

        return $row;
    }

    public static function toPbQuery($query = '', $interpolations = [])
    {
        $tsQuery = new TsInterpolation();

        $tsQuery->setBase($query);

        foreach($interpolations as $key => $value) {
            $pair = new RpbPair();
            $pair->setKey($key);
            $pair->setValue($value);
            $tsQuery->appendInterpolations($pair);
        }

        return $tsQuery;
    }
}
