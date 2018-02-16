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
        CakeDay\Birthday::$testYear = '2018-02-15';
        
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
     * @dataProvider birthdayDataProvider
     */
    public function test_cakeDayCalculator($testyear, $birthdays, $cakedays)
    {
        CakeDay\Birthday::$testYear = $testyear;
        $this->cakeDayCalculator->setBirthdays($birthdays);
        $returnCakedays = $this->cakeDayCalculator->getCakeDays();
        
        $this->assertEquals(count($cakedays), count($returnCakedays));
        if (count($cakedays) == count($returnCakedays)) {
            for ($i = 0; $i < count($cakedays); $i ++) {
                $this->assertEquals($cakedays[$i], $returnCakedays[$i]);
            }
        }
    }

    public function birthdayDataProvider()
    {
        return [
            [
                '2018-02-15',
                [
                    [
                        'Faraz',
                        '1980-01-12'
                    ],
                    [
                        'J',
                        '1981-02-11'
                    ],
                    [
                        'K',
                        '1970-02-12'
                    ],
                    [
                        'L',
                        '1988-12-25'
                    ],
                    [
                        'M',
                        '1966-12-24'
                    ],
                    [
                        'N',
                        '1999-12-31'
                    ],
                    [
                        'O',
                        '1971-01-12'
                    ],
                    [
                        'Mon',
                        '1971-01-14'
                    ],
                    [
                        'Tue',
                        '1971-01-15'
                    ],
                    [
                        'Wed',
                        '1971-01-16'
                    ],
                    [
                        'Thu',
                        '1971-01-17'
                    ],
                    [
                        'Fri',
                        '1971-01-18'
                    ]
                
                ],
                [
                    [
                        '2018-12-28',
                        'No small cake',
                        '1 large cake',
                        'L, M'
                    ],
                    [
                        '2019-01-02',
                        '1 small cake',
                        'No large cake',
                        'N'
                    ],
                    [
                        '2019-01-16',
                        'No small cake',
                        '1 large cake',
                        'Tue, Faraz, O, Mon'
                    ],
                    [
                        '2019-01-18',
                        'No small cake',
                        '1 large cake',
                        'Thu, Wed'
                    ],
                    [
                        '2019-01-21',
                        '1 small cake',
                        'No large cake',
                        'Fri'
                    ],
                    [
                        '2019-02-13',
                        'No small cake',
                        '1 large cake',
                        'K, J'
                    ]
                ]
            ],
            [
                '2017-01-01',
                [
                    [
                        'Dave',
                        '1990-06-28'
                    ],
                    [
                        'Rob',
                        '1990-07-02'
                    ],
                    [
                        'Sam',
                        '1990-07-03'
                    ],
                    [
                        'Kate',
                        '1990-07-04'
                    ],
                    [
                        'Alex',
                        '1990-07-10'
                    ],
                    [
                        'Jen',
                        '1990-07-11'
                    ],
                    [
                        'Pete',
                        '1990-07-12'
                    ]
                
                ],
                [
                    [
                        '2017-06-29',
                        '1 small cake',
                        'No large cake',
                        'Dave'
                    ],
                    [
                        '2017-07-05',
                        'No small cake',
                        '1 large cake',
                        'Kate, Rob, Sam'
                    ],
                    [
                        '2017-07-12',
                        'No small cake',
                        '1 large cake',
                        'Jen, Alex'
                    ],
                    [
                        '2017-07-14',
                        '1 small cake',
                        'No large cake',
                        'Pete'
                    ]
                ]
            ]
        
        ];
    }
}

