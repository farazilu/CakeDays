<?php
namespace CakeDay;

/**
 * data handler that can be extended with different implementations
 *
 * @author faraz
 *        
 */
interface DataHandlerInterface
{

    /**
     * read data as array from source and store it in class property
     *
     * @return bool
     */
    public function reader(): bool;

    /**
     * write array data to destination that is stored in class property
     *
     * @return bool
     */
    public function writer(): bool;

    /**
     * return data from class property
     *
     * @return array
     */
    public function getData(): array;

    /**
     *
     * set data to class property
     * 
     * @param array $data
     */
    public function setData(array $data);
}