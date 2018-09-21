<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CSVReader {
    var $fields;/** columns names retrieved after parsing */
    var $separator = ';';/** separator used to explode each line */
    var $enclosure = '"';/** enclosure used to decorate each field */
    var $max_row_size = 4096;/** maximum row size to be used for decoding */

    function parse_file($p_Filepath) {
        $file = fopen($p_Filepath, 'r');
        $this->fields = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure);
        $keys = str_getcsv($this->fields[0]);
        $i = 1;
        while (($row = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure)) != false) {
            if ($row != null) { // skip empty lines
                $values = str_getcsv($row[0]);
                if (count($keys) == count($values)) {
                    $arr = array();
                    for ($j = 0; $j < count($keys); $j++) {
                        if ($keys[$j] != "") {
                            if ($keys[$j] == "admission_date(dd-mm-yyyy)" || $keys[$j] == "dob(dd-mm-yyyy)") {
                                $search = "(dd-mm-yyyy)";
                                $trimmed = str_replace($search, '', $keys[$j]);
                                $arr[$trimmed] = date('Y-m-d', strtotime($values[$j]));
                            } else {
                                $arr[$keys[$j]] = $values[$j];
                            }
                        }
                    }
                    $content[$i] = $arr;
                    $i++;
                }
            }
        }
        fclose($file);
        return $content;
    }
}
?>