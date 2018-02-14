<?php
namespace CakeDay;

/**
 *
 * @author faraz
 *        
 */
class CakeDayCalculator
{

    private $_dataHandler;

    private $_dateHandler;

    private $_birthdays = [];

    private $_cakeDays = [];

    /**
     */
    public function __construct(DateHandlerInterface $dateHandler, DataHandlerInterface $dataHandler)
    {
        $this->_dataHandler = $dataHandler;
        $this->_dateHandler = $dateHandler;
    }

    public function import_data(): int
    {
        if ($this->_dataHandler->reader()) {
            $birthdays = $this->_dataHandler->getData();
            foreach ($birthdays as $birthday) {
                // ignore invalid rows
                if (count($birthday) == 2) {
                    $this->_birthdays[] = new Birthday($birthday[0], $birthday[1], $this->_dateHandler);
                }
            }
            
            return count($this->_birthdays);
        }
        return 0;
    }

    public function getAllCakeDays(): int
    {
        foreach ($this->_birthdays as $birthday) {
            // If two or more cakes days coincide, we instead provide one large cake to share
            $this->_cakeDays[$birthday->getNextWrokingDay()][] = $birthday->getName();
        }
        // sort cake days so coloser cake day is in start of list.
        ksort($this->_cakeDays);
        return count($this->_cakeDays);
    }

    /**
     * If there is to be cake two days in a row, we instead provide one large cake on the second
     * day.
     * For health reasons, the day after each cake must be cake-free. Any cakes due on a cake-
     * free day are postponed to the next working day.
     */
    public function groupCakeDays()
    {
        $groupedCakeDays = [];
        $cake_days = array_keys($this->_cakeDays);
        $cake_day_shifted = FALSE;
        for ($i = 0; $i < count($cake_days) - 1; $i ++) {
    
                $today = \DateTime::createFromFormat('Y-m-d', $cake_days[$i]);
                $nextday = \DateTime::createFromFormat('Y-m-d', $cake_days[$i + 1]);
                $diff = $today->diff($nextday);
                echo PHP_EOL;
                print_r($cake_days[$i]);
                echo ' ; ';
                print_r($cake_days[$i + 1]);
                print_r($diff);
                
                if ($diff->days == 1) {
                    // we have two cake days in a row.. move cake day to late date.
                    $groupedCakeDays[$cake_days[$i + 1]] = array_merge($this->_cakeDays[$cake_days[$i]], $this->_cakeDays[$cake_days[$i + 1]]);
                    $cake_day_shifted = true;
                }
            } else {
                $today = \DateTime::createFromFormat('Y-m-d', $cake_days[$i]);
                $nextday = \DateTime::createFromFormat('Y-m-d', $cake_days[$i + 1]);
                
                
                $groupedCakeDays[$cake_days[$i]] = $this->_cakeDays[$cake_days[$i]];
            }
        }
        print_r($groupedCakeDays);
    }
}

