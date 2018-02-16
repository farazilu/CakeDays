<?php
namespace CakeDay;

/**
 * Implementation of Data handler to read and write a CSV file
 *
 * @author faraz
 *        
 */
class CSVHandler implements DataHandlerInterface
{

    private $_file_read;

    private $_file_write;

    private $_data;

    /**
     * Construct a object of class
     * relative path of source and destination file
     *
     * @param string $file_read
     * @param string $file_write
     */
    public function __construct($file_read, $file_write)
    {
        $this->_file_read = $file_read;
        $this->_file_write = $file_write;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \CakeDay\DataHandlerInterface::setData()
     *
     */
    public function setData(array $data)
    {
        $this->_data = $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \CakeDay\DataHandlerInterface::reader()
     *
     */
    public function reader(): bool
    {
        $file_info = new \SplFileInfo($this->_file_read);
        if ($file_info->isReadable()) {
            $file = new \SplFileObject($this->_file_read);
            $file->setFlags(\SplFileObject::READ_CSV);
            foreach ($file as $row) {
                $this->_data[] = $row;
            }
            $file = null;
            $file_info = null;
            return true;
        } else {
            throw new \Exception("Sorry input file is not readable, make sure file exist and has correct permissions");
        }
        return false;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \CakeDay\DataHandlerInterface::writer()
     *
     */
    public function writer(): bool
    {
        try {
            $file = new \SplFileObject($this->_file_write, "w");
            foreach ($this->_data as $row) {
                $file->fputcsv($row);
            }
            $file = null;
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Sorry output file is not writable, make sure file exist and has correct permissions: " . $e->getMessage());
        }
        return false;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \CakeDay\DataHandlerInterface::getData()
     *
     */
    public function getData(): array
    {
        return $this->_data;
    }
}

