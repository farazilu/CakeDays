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

    public function exec()
    {
        $this->import_data();
        $this->getAllCakeDays();
        $this->groupCakeDays();
        $this->export_data();
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

    public function export_data(): array
    {
        $data = [];
        //print_r($this->_cakeDays);
        foreach ($this->_cakeDays as $day => $cake_data) {
            $small_cake = 'No small cake';
            $large_cake = 'No large cake';
            $names= '';
            if (count($cake_data['names']) == 1) {
                $small_cake = '1 small cake';
            } else {
                $large_cake = '1 large cake';
            }
            $data[] = [
                $day,
                $small_cake,
                $large_cake,
                implode(', ', $cake_data['names'])
            ];
        }
        $this->_dataHandler->setData($data);
        $this->_dataHandler->writer();
        
        return $data;
    }

    public function getAllCakeDays(): int
    {
        foreach ($this->_birthdays as $birthday) {
            // If two or more cakes days coincide, we instead provide one large cake to share
            $this->_cakeDays[$birthday->getNextWrokingDay()]['names'][] = $birthday->getName();
            $this->_cakeDays[$birthday->getNextWrokingDay()]['moved'] = FALSE;
        }
        // sort cake days so coloser cake day is in start of list.
        ksort($this->_cakeDays);
        return count($this->_cakeDays);
    }

    private function moveDays($oldDate, $newDate)
    {
        if (isset($this->_cakeDays[$oldDate])) {
            // make sure we have a cake day set on old date..
            if (isset($this->_cakeDays[$newDate])) {
                // check if we already have a cake day on new date if we ahve merge them.
                $this->_cakeDays[$newDate]['names'] = array_merge($this->_cakeDays[$newDate]['names'], $this->_cakeDays[$oldDate]['names']);
            } else {
                // else create a new cake day..
                $this->_cakeDays[$newDate]['names'] = $this->_cakeDays[$oldDate]['names'];
            }
            $this->_cakeDays[$newDate]['moved'] = TRUE;
            // remove the old cake day..
            unset($this->_cakeDays[$oldDate]);
            ksort($this->_cakeDays);
            // echo PHP_EOL . " {$oldDate} -> {$newDate}";
            // print_r($this->_cakeDays);
            // die();
        }
    }

    /**
     * If there is to be cake two days in a row, we instead provide one large cake on the second
     * day.
     * For health reasons, the day after each cake must be cake-free. Any cakes due on a cake-
     * free day are postponed to the next working day.
     */
    public function groupCakeDays()
    {
        $cake_days = array_keys($this->_cakeDays);
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
                    if (isset($this->_cakeDays[$currentDayString]) && $this->_cakeDays[$currentDayString]['moved']) {
                        $nextDayStringNext = $this->_dateHandler->getNextWrokingDay($nextDayString);
                        $this->moveDays($nextDayString, $nextDayStringNext);
                        // echo PHP_EOL . " {$i} {$nextDayString} ->-> {$nextDayStringNext}";
                        $nextDayString = $nextDayStringNext;
                    } else {
                        $this->moveDays($currentDayString, $nextDayString);
                        // echo PHP_EOL . " {$i} {$currentDayString} ---> {$nextDayString}";
                    }
                    
                    // because we already have a cake day previous day we have to move current cake day to next working day.
                    $cake_days = array_keys($this->_cakeDays);
                    // echo PHP_EOL;
                    $i = array_search($nextDayString, $cake_days);
                    // print_r($this->_cakeDays);
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
}

