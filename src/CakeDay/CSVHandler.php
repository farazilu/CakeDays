<?php
namespace CakeDay;

/**
 *
 * @author faraz
 *        
 */
class CSVHandler implements DataHandelerInterface
{

    private $_file;

    private $_data;

    /**
     */
    public function __construct($file)
    {
        $this->_file = $file;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \classes\DataHandelerInterface::setData()
     *
     */
    public function setData(array $data)
    {
        $this->_data = $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \classes\DataHandelerInterface::reader()
     *
     */
    public function reader()
    {
        $file = new SplFileObject($this->_file);
        $file->setFlags(SplFileObject::READ_CSV);
        foreach ($file as $row) {
            list ($animal, $class, $legs) = $row;
            printf("A %s is a %s with %d legs\n", $animal, $class, $legs);
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \classes\DataHandelerInterface::writer()
     *
     */
    public function writer()
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \classes\DataHandelerInterface::getData()
     *
     */
    public function getData(): array
    {
        return $this->_data;
    }
}

