<?php
namespace CakeDay;

/**
 *
 * @author faraz
 *        
 */
class Birthday
{

    private $_birthday;

    private $_name;

    private $_next_working_day;

    private $_dateHandler;

    private $_birthday_label;

    /**
     * set this variable to get next birthday if not set current time will be used
     * Date 'Y-m-d'
     *
     * @var string
     */
    public static $testYear;

    /**
     * create a birthday object
     *
     * @param string $name
     * @param string $birthday
     * @param DateHandlerInterface $datehandler
     */
    public function __construct($name, $birthday, DateHandlerInterface $datehandler)
    {
        $this->_name = $name;
        $this->_birthday = $birthday;
        $this->_dateHandler = $datehandler;
        
        $this->calculateNextWorkingDay();
    }

    /**
     * calculate next working day after birthday
     *
     * @throws \Exception
     * @return boolean
     */
    private function calculateNextWorkingDay()
    {
        if ($birthdayObj = \DateTime::createFromFormat('Y-m-d', $this->_birthday)) {
            $day = $birthdayObj->format('d');
            $month = $birthdayObj->format('m');
            $this->_birthday_label = "{$day}, {$month}";
            
            // make class test able so we can give fix year for test data e.g. 2018
            if (! empty(self::$testYear)) {
                
                $today = \DateTime::createFromFormat('Y-m-d', self::$testYear);
                $year = $today->format('Y');
                $next_birthday = \DateTime::createFromFormat('Y-m-d', "{$year}-{$month}-{$day}");
            } else {
                $next_birthday = \DateTime::createFromFormat('m-d', "{$month}-{$day}");
                $today = new \DateTime();
            }
            // check if this year birthday has passed
            $diff = $today->diff($next_birthday);
            if ($diff->invert && $diff->days > 0) {
                // this year birthday has passed so calculate next year
                $next_birthday = $next_birthday->add(new \DateInterval('P1Y'));
            }
            
            // check if birthday on day off
            $birthday_on_day_off = $this->_dateHandler->checkDayOff($next_birthday);
            $this->_next_working_day = $this->_dateHandler->getNextWrokingDay($next_birthday->format('Y-m-d'));
            
            // if birthday was on day off make next working day as day off
            if ($birthday_on_day_off) {
                $this->_next_working_day = $this->_dateHandler->getNextWrokingDay($this->_next_working_day);
            }
            return TRUE;
        } else {
            throw new \Exception("Invalid birthday format required: 'Y-m-d', given: " . $this->_birthday);
        }
        return FALSE;
    }

    public function getBirthdayLabel()
    {
        return $this->_birthday_label;
    }

    /**
     * get person name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * get next working day after birthday
     *
     * @return string
     */
    public function getNextWrokingDay(): string
    {
        
        // $this->_next_working_day
        return $this->_next_working_day;
    }
}

