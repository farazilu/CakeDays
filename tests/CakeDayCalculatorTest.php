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
        $this->assertEquals(7, $count);
    }

    public function test_getAllCakeDays()
    {
        $this->cakeDayCalculator->import_data();
        $count = $this->cakeDayCalculator->getAllCakeDays();
        $this->assertEquals(6, $count);
    }
}

