<?php

namespace App\Bot\Loader;


class File
{
    const DATA_DELIMITER = "\n";

    /** @var string absolute path of file to load data */
    private $file;

    /**
     * File constructor.
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * @return array
     */
    public function getData():array
    {
        return explode(self::DATA_DELIMITER, file_get_contents($this->file));
    }

    /**
     * @param $data
     * @return int
     */
    public function appendData($data):int
    {
        return file_put_contents($this->file, $data.self::DATA_DELIMITER, FILE_APPEND);
    }

    /**
     * @param $data
     * @return int
     */
    public function replaceData($data):int
    {
        return file_put_contents($this->file, $data.self::DATA_DELIMITER);
    }
}
