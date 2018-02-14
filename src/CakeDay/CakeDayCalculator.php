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
            $this->_cakeDays[$birthday->getNextWrokingDay()][] = $birthday->getName();
        }
        return count($this->_cakeDays);
    }
}

