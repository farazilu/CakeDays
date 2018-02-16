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

    private $_cakeDaysData = [];

    private $_cakeDaysFinished = [];

    /**
     * create a object of cake day calculator
     *
     * @param DateHandlerInterface $dateHandler
     * @param DataHandlerInterface $dataHandler
     */
    public function __construct(DateHandlerInterface $dateHandler, DataHandlerInterface $dataHandler)
    {
        $this->_dataHandler = $dataHandler;
        $this->_dateHandler = $dateHandler;
    }

    /**
     * calculate cakedays for birthdays single controller
     */
    public function exec()
    {
        $this->setBirthdays([]);
        $this->getCakeDays();
        $this->export_data();
    }

    /**
     * import data using DataHandler attached using dependency injecton
     *
     * @return array
     */
    private function import_data(): array
    {
        if ($this->_dataHandler->reader()) {
            return $this->_dataHandler->getData();
        }
        return [];
    }

    /**
     * write data using Datahandler attached using dependency injection
     */
    public function export_data(): void
    {
        $this->_dataHandler->setData($this->_cakeDaysFinished);
        $this->_dataHandler->writer();
    }

    /**
     * set data to process Or empty to use Data Handler import
     * [ [Dan, 1990-02-11], [Dan, 1990-02-11] ]
     *
     * @param array $birthdays
     */
    public function setBirthdays(array $birthdays)
    {
        if (count($birthdays) == 0) {
            $birthdays = $this->import_data();
        }
        
        foreach ($birthdays as $birthday) {
            // ignore invalid rows
            if (count($birthday) == 2) {
                if ($this->_dateHandler->dateValidator($birthday[1])) {
                    $this->_birthdays[] = new Birthday($birthday[0], $birthday[1], $this->_dateHandler);
                }
            }
        }
    }

    /**
     * get calculated cake days
     *
     * [ [2017-01-01, 'small cakes', 'Large cakes', 'Names'] ]
     *
     * @return array
     */
    public function getCakeDays(): array
    {
        if (count($this->_cakeDaysFinished) == 0) {
            $this->convertBirthdaysToCakeDays();
            $this->groupCakeDays();
            $this->sanitiseCakeDays();
        }
        return $this->_cakeDaysFinished;
    }

    /**
     * convert birthday data into cake days for curren year
     */
    private function convertBirthdaysToCakeDays(): void
    {
        foreach ($this->_birthdays as $birthday) {
            // If two or more cakes days coincide, we instead provide one large cake to share
            $this->_cakeDaysData[$birthday->getNextWrokingDay()]['names'][] = $birthday->getName();
            $this->_cakeDaysData[$birthday->getNextWrokingDay()]['moved'] = FALSE;
        }
        // sort cake days so coloser cake day is in start of list.
        ksort($this->_cakeDaysData);
    }

    /**
     * move and group cake days according to rules
     * If there is to be cake two days in a row, we instead provide one large cake on the second
     * day.
     * For health reasons, the day after each cake must be cake-free. Any cakes due on a cake-
     * free day are postponed to the next working day.
     */
    private function groupCakeDays()
    {
        $cake_days = array_keys($this->_cakeDaysData);
        $i = 0;
        $loop = TRUE;
        while ($loop) {
            $nothing = TRUE;
            // check if we have a cake day on previous day.. H&S
            if (isset($cake_days[$i]) && isset($cake_days[$i + 1])) {
                $currentDay = \DateTime::createFromFormat('Y-m-d', $cake_days[$i]);
                $nextDay = \DateTime::createFromFormat('Y-m-d', $cake_days[$i + 1]);
                $diff = $currentDay->diff($nextDay);
                if ($diff->days == 1) {
                    $currentDayString = $currentDay->format('Y-m-d');
                    $nextDayString = $nextDay->format('Y-m-d');
                    // we have two situations.. 1: current cake day is already moved so move next day onward.. 2: current cake day is not moved yet so merge both to next day.
                    if (isset($this->_cakeDaysData[$currentDayString]) && $this->_cakeDaysData[$currentDayString]['moved']) {
                        $nextDayStringNext = $this->_dateHandler->getNextWrokingDay($nextDayString);
                        $this->moveDays($nextDayString, $nextDayStringNext);
                        // echo PHP_EOL . " {$i} {$nextDayString} ->-> {$nextDayStringNext}";
                        $nextDayString = $nextDayStringNext;
                    } else {
                        $this->moveDays($currentDayString, $nextDayString);
                        // echo PHP_EOL . " {$i} {$currentDayString} ---> {$nextDayString}";
                    }
                    
                    // because we already have a cake day previous day we have to move current cake day to next working day.
                    $cake_days = array_keys($this->_cakeDaysData);
                    // echo PHP_EOL;
                    $i = array_search($nextDayString, $cake_days);
                    // print_r($this->_cakeDaysData);
                    // return;
                    
                    $nothing = FALSE;
                } else {
                    // we did not have a cake day on check if we have a cake day next day and merge them into one..
                }
            } else {
                // end the loop we have reached the end of list
                // echo PHP_EOL . ' continue';
                // ob_flush();
                // continue;
                $loop = FALSE;
            }
            // echo PHP_EOL . $i;
            // ob_flush();
            
            if ($nothing)
                $i ++; // just move to next day
        }
    }

    /**
     * move cake days from old date to new date and set moved flag
     *
     * @param string $oldDate
     * @param string $newDate
     */
    private function moveDays($oldDate, $newDate)
    {
        if (isset($this->_cakeDaysData[$oldDate])) {
            // make sure we have a cake day set on old date..
            if (isset($this->_cakeDaysData[$newDate])) {
                // check if we already have a cake day on new date if we ahve merge them.
                $this->_cakeDaysData[$newDate]['names'] = array_merge($this->_cakeDaysData[$newDate]['names'], $this->_cakeDaysData[$oldDate]['names']);
            } else {
                // else create a new cake day..
                $this->_cakeDaysData[$newDate]['names'] = $this->_cakeDaysData[$oldDate]['names'];
            }
            $this->_cakeDaysData[$newDate]['moved'] = TRUE;
            // remove the old cake day..
            unset($this->_cakeDaysData[$oldDate]);
            ksort($this->_cakeDaysData);
            // echo PHP_EOL . " {$oldDate} -> {$newDate}";
            // print_r($this->_cakeDaysData);
            // die();
        }
    }

    /**
     * convert cake day data to exportable format
     */
    private function sanitiseCakeDays()
    {
        $this->_cakeDaysFinished = [];
        // print_r($this->_cakeDaysData);
        foreach ($this->_cakeDaysData as $day => $cake_data) {
            $small_cake = 'No small cake';
            $large_cake = 'No large cake';
            $names = '';
            if (count($cake_data['names']) == 1) {
                $small_cake = '1 small cake';
            } else {
                $large_cake = '1 large cake';
            }
            $this->_cakeDaysFinished[] = [
                $day,
                $small_cake,
                $large_cake,
                implode(', ', $cake_data['names'])
            ];
        }
    }
}

