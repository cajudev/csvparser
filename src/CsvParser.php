<?php namespace Cajudev\CsvParser;

class CsvParser {

    private $file;
    private $content;
    private $filters;
    private $columns;

    public function __construct(string $dir) {
        $this->setFile($dir);
        $this->setFlags();
    }

    public function parse() {
        $this->setHeader();
        $this->setContent();

        return $this->get();
    }

    private function setHeader() {
        $this->header = $this->file->fgetcsv();
    }

    private function setContent() {
        $i = 0;
        while($row = $this->file->fgetcsv()) {
            for($j = 0, $size = count($row); $j < $size; $j++) {
                $this->content[$i][$this->header[$j]] = $row[$j];
            }
            $i++;
        }
    }

    private function get() {

        if(!empty($this->filters)) {
            return $this->getArrayFiltered();
        }

        if(!empty($this->columns)) {
            return $this->getArrayColumns();
        }

        return $this->content;
    }

    private function getArrayColumns($contents = null) {
        $contents = $contents ?? $this->content;

        foreach($contents as $index => $content) {
            foreach($this->columns as $column) {
                $ret[$index][$column] = $content[$column];
            }
        }

        return $ret;
    }

    private function getArrayFiltered() {
        foreach($this->content as $row) {
            $apply = true;

            foreach($this->filters as $key => $value) {
                if(!in_array($row[$key], $value)) {
                    $apply = false;
                }
            }

            if($apply) {
                $ret[] = $row;
            }
        }

        return !empty($this->columns) ? $this->getArrayColumns($ret) : $ret;
    }

    public function setDelimiter($delimiter) {
        $this->file->setCsvControl($delimiter);
    }

    public function setColumns(array $columns) {
        $this->columns = $columns;
    }

    public function setFilters(array $filters) {
        $this->filters = $filters;
    }

    private function setFile($dir) {
        $this->file = new \SplFileObject($dir);
    }

    private function setFlags() {
        $this->file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY);
    }
}