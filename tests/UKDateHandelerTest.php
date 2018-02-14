<?php
use PHPUnit\Framework\TestCase;

/**
 * UKDateHandeler test case.
 */
class UKDateHandelerTest extends TestCase
{

    /**
     *
     * @var CakeDay\UKDateHandeler
     */
    private $uKDateHandeler;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated UKDateHandelerTest::setUp()
        
        $this->uKDateHandeler = new CakeDay\UKDateHandeler(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated UKDateHandelerTest::tearDown()
        $this->uKDateHandeler = null;
        
        parent::tearDown();
    }

    /**
     * Tests UKDateHandeler->__construct()
     */
    public function test__construct()
    {
        // don't need to call constructor as its alreay called in setUP()
        // $this->uKDateHandeler->__construct(/* parameters */);
        $this->assertInstanceOf(CakeDay\UKDateHandeler::class, $this->uKDateHandeler);
    }

    /**
     * Tests UKDateHandeler->checkDayOff()
     */
    public function test_checkDayOff()
    {
        $date = DateTime::createFromFormat('Y-m-d', "2017-01-02");
        $dayoff = $this->uKDateHandeler->checkDayOff($date);
        $this->assertFalse($dayoff);
        
        $date = DateTime::createFromFormat('Y-m-d', "2017-01-01");
        $dayoff = $this->uKDateHandeler->checkDayOff($date);
        $this->assertTrue($dayoff);
        
        $date = DateTime::createFromFormat('Y-m-d', "2017-12-25");
        $dayoff = $this->uKDateHandeler->checkDayOff($date);
        $this->assertTrue($dayoff);
        
        $date = DateTime::createFromFormat('Y-m-d', "2017-12-27");
        $dayoff = $this->uKDateHandeler->checkDayOff($date);
        $this->assertFalse($dayoff);
    }

    /**
     * Tests UKDateHandeler->getNextWrokingDay()
     */
    public function test_GetNextWrokingDay()
    {
        $next_working_day = $this->uKDateHandeler->getNextWrokingDay("2017-01-02");
        $this->assertEquals('2017-01-02', $next_working_day);
        
        $next_working_day = $this->uKDateHandeler->getNextWrokingDay("2018-02-18");
        $this->assertEquals('2018-02-19', $next_working_day);
        
        $next_working_day = $this->uKDateHandeler->getNextWrokingDay("2017-02-18");
        $this->assertEquals('2017-02-20', $next_working_day);
        
        $next_working_day = $this->uKDateHandeler->getNextWrokingDay("2017-12-25");
        $this->assertEquals('2017-12-27', $next_working_day);
        
        $next_working_day = $this->uKDateHandeler->getNextWrokingDay("2018-12-25");
        $this->assertEquals('2018-12-27', $next_working_day);
        
        $next_working_day = $this->uKDateHandeler->getNextWrokingDay("2019-01-01");
        $this->assertEquals('2019-01-02', $next_working_day);
    }
}

