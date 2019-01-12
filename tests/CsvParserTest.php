<?php
use Cajudev\CsvParser;
use PHPUnit\Framework\TestCase;

/**
 * @author Richard Lopes
 */
class DateTest extends TestCase {

	public function setUp() {
        $this->csv = new CsvParser(__DIR__ . '/files/sails.csv');
	}

    public function test_Parse_With_SetColumns_Should_Return_Array_With_300_Registers() {
        $this->csv->setDelimiter(',');
        $this->csv->setColumns(['Product', 'Price', 'Payment_Type', 'Name']);
        $results = $this->csv->parse();

        self::assertEquals(998, count($results));
    }

    public function test_Parse_With_SetFilters_Should_Return_Array_With_5_Registers() {
        $this->csv->setDelimiter(',');
        $this->csv->setFilters([
            'Payment_Type' => ['Visa'],
            'State'        => ['Quebec'],
        ]);
        $results = $this->csv->parse();

        self::assertEquals(5, count($results));
    }
    
	public function test_Parse_With_SetColumns_And_SetFilters_Should_Return_Array_With_95_Registers() {
        $this->csv->setDelimiter(',');
        $this->csv->setColumns(['Product', 'Price', 'Payment_Type', 'Name']);
        $this->csv->setFilters([
            'Payment_Type' => ['Visa',   'Mastercard'],
            'Country'      => ['Canada', 'Australia'],
        ]);
        $results = $this->csv->parse();

        self::assertEquals(95, count($results));
    }
}
