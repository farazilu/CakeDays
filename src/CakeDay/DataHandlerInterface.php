<?php
namespace CakeDay;

/**
 *
 * @author faraz
 *        
 */
interface DataHandlerInterface
{

    public function reader(): bool;

    public function writer(): bool;

    public function getData(): array;

    public function setData(array $data);
}