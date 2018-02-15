<?php
namespace CakeDay;

/**
 *
 * @author faraz
 *        
 */
interface DateHandlerInterface
{

    public function getNextWrokingDay($date): string;

    public function checkDayOff(\DateTime $dateObj): bool;
}

