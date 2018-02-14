<?php
namespace CakeDay;

/**
 *
 * @author faraz
 *        
 */
class UKDateHandeler implements DateHandlerInterface
{

    private $_weekends = [
        'Sun',
        'Sat'
    ];

    private $_holidays_String = [
        '25 Dec',
        '26 Dec',
        '01 Jan'
    ];

    private $_holidays = [];

    /**
     */
    public function __construct()
    {
        foreach ($this->_holidays_String as $day) {
            $date = \DateTime::createFromFormat("d M", $day);
            $this->_holidays[] = $date;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \CakeDay\DateHandlerInterface::getNextWrokingDay()
     *
     */
    public function getNextWrokingDay($date): string
    {
        $dateObj = \DateTime::createFromFormat('Y-m-d', $date);
        $dateObj = $this->getNextWrokingDayItrator($dateObj);
        return $dateObj->format('Y-m-d');
    }

    /**
     *
     * {@inheritdoc}
     * @see \CakeDay\DateHandlerInterface::checkDayOff()
     */
    public function checkDayOff(\DateTime $dateObj): bool
    {
        if (in_array($dateObj->format('D'), $this->_weekends)) {
            return TRUE;
        }
        // check if day is on public holiday
        foreach ($this->_holidays as $holiday) {
            if ($dateObj->format('d') == $holiday->format('d') && $dateObj->format('m') == $holiday->format('m')) {
                return TRUE;
            }
        }
        return FALSE;
    }

    private function getNextWrokingDayItrator(\DateTime $dateObj)
    {
        if ($this->checkDayOff($dateObj)) {
            $dateObj = $dateObj->add(new \DateInterval('P1D'));
            $dateObj = $this->getNextWrokingDayItrator($dateObj);
        }
        return $dateObj;
    }
}

