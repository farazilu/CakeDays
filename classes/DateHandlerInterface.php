<?php
namespace classes;

/**
 *
 * @author faraz
 *        
 */
interface DateHandlerInterface
{

    public function getNextWrokingDay($date): string;
}

