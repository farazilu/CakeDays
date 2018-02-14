<?php
use PHPUnit\Framework\TestCase;

/**
 * CSVHandler test case.
 */
class CSVHandlerTest extends TestCase
{

    /**
     *
     * @var CakeDay\CSVHandler
     */
    private $cSVHandler;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->cSVHandler = new CakeDay\CSVHandler("data/test_file.csv", "data/test_file.csv");
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated CSVHandlerTest::tearDown()
        $this->cSVHandler = null;
        if (is_file("data/test_file.csv"))
            unlink("data/test_file.csv");
        
        parent::tearDown();
    }

    /**
     * Tests CSVHandler->__construct()
     */
    public function test__construct()
    {
        // don't need to test constructor as its alredy calledin setUP()
        // $this->cSVHandler->__construct("data/test_input.csv", "data/test_output.csv");
        $this->assertInstanceOf("\CakeDay\CSVHandler", $this->cSVHandler);
    }

    /**
     * Tests CSVHandler->setData()
     * Tests CSVHandler->setData()
     */
    public function testSetGetData()
    {
        $data = [
            [
                'test name',
                'DOB'
            ]
        ];
        $this->cSVHandler->setData($data);
        $data_return = $this->cSVHandler->getData();
        $this->assertEquals($data, $data_return);
    }

    /**
     * Tests CSVHandler->writer()
     */
    public function testWriterReader()
    {
        $data = [
            [
                'test name',
                'DOB'
            ]
        ];
        $this->cSVHandler->setData($data);
        
        $is_success = $this->cSVHandler->writer();
        $this->assertTrue($is_success);
    }

    /**
     * Tests CSVHandler->reader()
     */
    public function testReader()
    {
        $data = [
            [
                'test name',
                'DOB'
            ]
        ];
        $this->cSVHandler->setData($data);
        
        $this->cSVHandler->writer();
        $is_success = $this->cSVHandler->reader();
        $this->assertTrue($is_success);
    }
}

