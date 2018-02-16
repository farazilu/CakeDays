<?php
namespace CakeDay;

/**
 * data handler that can be extended with different implementations
 *
 * @author faraz
 *        
 */
interface DateHandlerInterface
{

    /**
     * return next working day for given holiday and calendar setup
     * input: 'Y-m-d'
     *
     * @param string $date
     * @return string
     */
    public function getNextWrokingDay($date): string;

    /**
     * check if given date is falls on weekend or on holiday
     *
     * @param \DateTime $dateObj
     * @return bool
     */
    public function checkDayOff(\DateTime $dateObj): bool;

    /**
     * check if date sting can be converted to DateTime object
     * input: 'Y-m-d'
     *
     * @param string $date
     * @return bool
     */
    public function dateValidator($date): bool;
}

