<?php
use Cajudev\CsvParser;
use PHPUnit\Framework\TestCase;

/**
 * @author Richard Lopes
 */

class CsvParserTest extends TestCase
{

    public function setUp()
    {
        $this->csv = new CsvParser(__DIR__ . '/files/sails.csv');
	}

    public function test_Parse_With_SetColumns()
    {
        $columns = ['Product', 'Price', 'Payment_Type', 'Name'];

        $results = $this->csv->setDelimiter(',')
                             ->setColumns($columns)
                             ->parse();

        self::assertEquals(998, count($results));
    }

    public function test_Parse_With_SetFilters()
    {
        $filters = [
            'Payment_Type' => ['Visa'],
            'State'        => ['Quebec'],
        ];

        $results = $this->csv->setDelimiter(',')
                             ->setFilters($filters)
                             ->parse();

        self::assertEquals(5, count($results));
    }
    
    public function test_Parse_With_SetColumns_And_SetFilters()
    {
        $columns = ['Product', 'Price', 'Payment_Type', 'Name'];

        $filters = [
            'Payment_Type' => ['Visa',   'Mastercard'],
            'Country'      => ['Canada', 'Australia'],
        ];

        $results = $this->csv->setDelimiter(',')
                             ->setColumns($columns)
                             ->setFilters($filters)
                             ->parse();

        self::assertEquals(95, count($results));
    }
}
