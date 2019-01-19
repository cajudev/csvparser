<?php
namespace Cajudev;

/**
 * @author Richard Lopes
 */

class CsvParser
{
    private $file;
    private $content;
    private $filters;
    private $columns;

    /**
     * __construct
     *
     * @param string $dir
     *
     * @return void
     */
    
    public function __construct(string $dir)
    {
        $this->setFile($dir);
        $this->setFlags();
    }

    /**
     * parse
     *
     * @return array
     */

    public function parse() : array
    {
        $this->setHeader();
        $this->setContent();

        return $this->get();
    }

    /**
     * setHeader
     *
     * @return void
     */
    
    private function setHeader()
    {
        $this->header = $this->file->fgetcsv();
    }

    /**
     * setContent
     *
     * @return void
     */
    
    private function setContent()
    {
        $i = 0;
        while ($row = $this->file->fgetcsv()) {
            foreach ($row as $key => $value) {
                $this->content[$i][$this->header[$key]] = $row[$key];
            }
            $i++;
        }
    }

    /**
     * get
     *
     * @return array
     */
    
    private function get() : array
    {
        if (!empty($this->filters)) {
            return $this->getArrayFiltered();
        }

        if (!empty($this->columns)) {
            return $this->getArrayColumns();
        }

        return $this->content;
    }

    /**
     * getArrayColumns
     *
     * @param  mixed $contents
     *
     * @return array
     */
    
    private function getArrayColumns($contents = null) : array
    {
        $contents = $contents ?? $this->content;

        foreach ($contents as $index => $content) {
            foreach ($this->columns as $column) {
                $ret[$index][$column] = $content[$column];
            }
        }

        return $ret;
    }

    /**
     * getArrayFiltered
     *
     * @return array
     */

    private function getArrayFiltered() : array
    {
        $ret = [];

        foreach ($this->content as $row) {
            $apply = true;

            foreach ($this->filters as $key => $value) {
                if (!in_array($row[$key], $value)) {
                    $apply = false;
                }
            }

            if ($apply) {
                $ret[] = $row;
            }
        }

        return isset($this->columns) ? $this->getArrayColumns($ret) : $ret;
    }

    /**
     * setDelimiter
     *
     * @param  mixed $delimiter
     *
     * @return self
     */
    
    public function setDelimiter($delimiter) : self
    {
        $this->file->setCsvControl($delimiter);
        return $this;
    }

    /**
     * setColumns
     *
     * @param  mixed $columns
     *
     * @return self
     */
    
    public function setColumns(array $columns) : self
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * setFilters
     *
     * @param  mixed $filters
     *
     * @return self
     */
    
    public function setFilters(array $filters) : self
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * setFile
     *
     * @param  mixed $dir
     *
     * @return void
     */
    
    private function setFile(string $dir)
    {
        $this->file = new \SplFileObject($dir);
    }

    /**
     * setFlags
     *
     * @return void
     */

    private function setFlags()
    {
        $this->file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY);
    }
}
