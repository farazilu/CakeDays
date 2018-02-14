<?php
use PHPUnit\Framework\TestCase;

/**
 * Birthday test case.
 */
class BirthdayTest extends TestCase
{

    /**
     *
     * @var CakeDay\Birthday
     */
    private $birthday;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        $dateHandler = new CakeDay\UKDateHandeler();
        $this->birthday = new CakeDay\Birthday('test name', '1990-01-01', $dateHandler);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated BirthdayTest::tearDown()
        $this->birthday = null;
        
        parent::tearDown();
    }

    /**
     * Tests Birthday->__construct()
     */
    public function test__construct()
    {
        
        // $this->birthday->__construct(/* parameters */);
        $this->assertInstanceOf(CakeDay\Birthday::class, $this->birthday);
    }

    public function test_getNextWrokingDay()
    {
        $dateHandler = new CakeDay\UKDateHandeler();
        $this->birthday = new CakeDay\Birthday('test name', '1990-01-01', $dateHandler);
        $working_day = $this->birthday->getNextWrokingDay();
        $this->assertEquals('2019-01-03', $working_day);
        
        $this->birthday = new CakeDay\Birthday('test name', '1990-12-01', $dateHandler);
        $working_day = $this->birthday->getNextWrokingDay();
        $this->assertEquals('2018-12-04', $working_day);
        
        $this->birthday = new CakeDay\Birthday('test name', '1990-12-25', $dateHandler);
        $working_day = $this->birthday->getNextWrokingDay();
        $this->assertEquals('2018-12-28', $working_day);
        
        $this->birthday = new CakeDay\Birthday('test name', '1990-12-31', $dateHandler);
        $working_day = $this->birthday->getNextWrokingDay();
        $this->assertEquals('2019-01-02', $working_day);
    }
}

