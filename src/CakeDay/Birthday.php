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
     */
    public function __construct($name, $birthday, DateHandlerInterface $datehandler)
    {
        $this->_name = $name;
        $this->_birthday = $birthday;
        $this->_dateHandler = $datehandler;
        
        $this->calculateNextWorkingDay();
    }

    private function calculateNextWorkingDay()
    {
        if ($birthdayObj = \DateTime::createFromFormat('Y-m-d', $this->_birthday)) {
            $day = $birthdayObj->format('d');
            $month = $birthdayObj->format('m');
            $this->_birthday_label = "{$day}, {$month}";
            $next_birthday = \DateTime::createFromFormat('m-d', "{$month}-{$day}");
            
            // check if this year birthday has passed
            $diff = (new \DateTime())->diff($next_birthday);
            if ($diff->invert && $diff->days > 0) {
                // this year birthday has passed so calculate next year
                $next_birthday = $next_birthday->add(new \DateInterval('P1Y'));
            }
            
            // check if birthday on day off
            $birthday_on_day_off = $this->_dateHandler->checkDayOff($next_birthday);
            
            $next_working_day = $next_birthday->add(new \DateInterval('P1D'));
            $this->_next_working_day = $this->_dateHandler->getNextWrokingDay($next_birthday->format('Y-m-d'));
            
            // if birthday was on day off make next working day as day off
            if ($birthday_on_day_off) {
                $next_working_day = \DateTime::createFromFormat('Y-m-d', $this->_next_working_day);
                $next_working_day = $next_working_day->add(new \DateInterval('P1D'));
                $this->_next_working_day = $this->_dateHandler->getNextWrokingDay($next_working_day->format('Y-m-d'));
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

    public function getName()
    {
        return $this->_name;
    }

    public function getNextWrokingDay(): string
    {
        
        // $this->_next_working_day
        return $this->_next_working_day;
    }
}

