<?php
namespace classes;

/**
 *
 * @author faraz
 *        
 */
interface DataHandelerInterface
{

    public function reader();

    public function writer();

    public function getData(): array;

    public function setData(array $data);
}