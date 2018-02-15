<?php
use PHPUnit\Framework\TestCase;

/**
 * CakeDayCalculator test case.
 */
class CakeDayCalculatorTest extends TestCase
{

    /**
     *
     * @var CakeDay\CakeDayCalculator
     */
    private $cakeDayCalculator;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        $csvHandler = new CakeDay\CSVHandler("data/input.csv", "data/output.csv");
        $dateHandler = new CakeDay\UKDateHandeler();
        CakeDay\Birthday::$testYear = 2018;
        
        $this->cakeDayCalculator = new CakeDay\CakeDayCalculator($dateHandler, $csvHandler);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated CakeDayCalculatorTest::tearDown()
        $this->cakeDayCalculator = null;
        
        parent::tearDown();
    }

    /**
     * Tests CakeDayCalculator->__construct()
     */
    public function test__construct()
    {
        
        // $this->cakeDayCalculator->__construct(/* parameters */);
        $this->assertInstanceOf(CakeDay\CakeDayCalculator::class, $this->cakeDayCalculator);
    }

    /**
     * Tests CakeDayCalculator->import_data()
     */
    public function test_Import_data()
    {
        $count = $this->cakeDayCalculator->import_data();
        $this->assertEquals(12, $count);
    }

    public function test_getAllCakeDays()
    {
        $this->cakeDayCalculator->import_data();
        $count = $this->cakeDayCalculator->getAllCakeDays();
        $this->assertEquals(10, $count);
    }

    public function test_groupCakeDays()
    {
        $this->cakeDayCalculator->import_data();
        $this->cakeDayCalculator->getAllCakeDays();
        $this->cakeDayCalculator->groupCakeDays();
        $days = $this->cakeDayCalculator->export_data();
        $this->assertEquals(6, count($days));
        $this->assertEquals([
            '2018-12-28',
            'No small cake',
            '1 large cake',
            'L, M'
        ], $days[0]);
        $this->assertEquals([
            '2019-01-02',
            '1 small cake',
            'No large cake',
            'N'
        ], $days[1]);
        $this->assertEquals([
            '2019-01-16',
            'No small cake',
            '1 large cake',
            'Tue, Faraz, O, Mon'
        ], $days[2]);
        $this->assertEquals([
            '2019-01-18',
            'No small cake',
            '1 large cake',
            'Thu, Wed'
        ], $days[3]);
        $this->assertEquals([
            '2019-01-21',
            '1 small cake',
            'No large cake',
            'Fri'
        ], $days[4]);
        $this->assertEquals([
            '2019-02-13',
            'No small cake',
            '1 large cake',
            'K, J'
        ], $days[5]);
    }
}

