<?php
namespace CakeDay;

/**
 *
 * @author faraz
 *        
 */
class CSVHandler implements DataHandelerInterface
{

    private $_file_read;

    private $_file_write;

    private $_data;

    /**
     */
    public function __construct($file_read, $file_write)
    {
        $this->_file_read = $file_read;
        $this->_file_weite = $file_write;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \CakeDay\DataHandelerInterface::setData()
     *
     */
    public function setData(array $data)
    {
        $this->_data = $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \CakeDay\DataHandelerInterface::reader()
     *
     */
    public function reader()
    {
        $file_info = new SplFileInfo($this->_file_read);
        if ($file_info->isReadable()) {
            $file = new SplFileObject($this->_file_read);
            $file->setFlags(SplFileObject::READ_CSV);
            foreach ($file as $row) {
                list ($animal, $class, $legs) = $row;
                printf("A %s is a %s with %d legs\n", $animal, $class, $legs);
            }
        } else {
            throw new Exception("Sorry input file is not readable, make sure file exist and has correct permissions");
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \CakeDay\DataHandelerInterface::writer()
     *
     */
    public function writer()
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \CakeDay\DataHandelerInterface::getData()
     *
     */
    public function getData(): array
    {
        return $this->_data;
    }
}

