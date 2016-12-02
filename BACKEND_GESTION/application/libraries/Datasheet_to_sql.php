<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 02/09/2016
 * Time: 12:33
 */
class Datasheet_to_sql {

    private static $_MYSQL_INT_TYPES = array(
        array('limit' => 256, 'type' => 'TINYINT')
        ,array('limit' => 65536, 'type' => 'SMALLINT')
        ,array('limit' => 16777216, 'type' => 'MEDIUMINT')
        ,array('limit' => 4294967296, 'type' => 'INT')
        ,array('limit' => -1, 'type' => 'BIGINT')
    );
    
    public function __construct(){
        // dummy security ..
        usort(Datasheet_to_sql::$_MYSQL_INT_TYPES, function($a, $b){ return $a['limit'] > 0 ? $a['limit'] > $b['limit'] : 1; });
    }

    public function get_mysql_int_type($int){
        foreach(Datasheet_to_sql::$_MYSQL_INT_TYPES as $mysql_int_type)
            if($int < $mysql_int_type['limit'])
                return $mysql_int_type['type'];
        // BIGINT if other too small
        return $mysql_int_type['type'];
    }

    private function _best_fields_specs(&$stats){
        $fields = array();
        foreach($stats as $field_name => $field){
            if( ! isset($fields[$field_name]))
                $fields[$field_name] = array();
            if($field['count']['string'] >= $field['count']['int']){// string type
                $fields[$field_name]['type'] = 'VARCHAR';
                $fields[$field_name]['constraint'] = $field['string']['constraint'];
            } else { // int type
                if(($field['count']['string'] > 0) && ($field['count']['float'] > 0)){ // float type
                    $fields[$field_name]['type'] = 'DECIMAL';
                    $fields[$field_name]['constraint'] = strlen( (string) $field['int']['max']) . ',1';
                } else { // int type
                    $fields[$field_name]['type'] = $this->get_mysql_int_type($field['int']['max']);
                }
                if(isset($field['int']['unsigned']))
                    $fields[$field_name]['unsigned'] = TRUE;
            }
        }
        $filtered = '';
        foreach($fields as $field_name => $value){
            $filtered = str_replace('/^[A-Za-z0-9_]*/', '', $field_name);
            if( ! $filtered){
                echo '<br/>YOLOOOOOOOOOOO BOOOOOOM';
                return;
            }
            if($filtered != $field_name){
                $fields[$filtered] = $value;
                unset($fields[$field_name]);
            }
        }
        echo '<pre style="background: lightcyan">';
        print_r($fields);
        echo '</pre>';
        return $fields;
    }

    private function _fields_stats($data){
        $stats = array();
        foreach($data as $row)
        foreach($row as $field_name => $value){
            // Welcome field name (first meeting)
            if( ! isset($stats[$field_name]))
                // init counts
                $stats[$field_name] = array('count' => array('int' => 0, 'string' => 0, 'float' => 0));
            // Finding type
            if(is_numeric($value)){
                {
                    // int field
                    if( ! isset($stats[$field_name]['int'])){
                        $stats[$field_name]['int'] = array('unsigned' => TRUE);
                        $stats[$field_name]['int']['max'] = 0;
                    }
                    // null field
                    if(is_null($value))
                        $stats[$field_name]['int']['null'] = TRUE;
                    // negative value
                    if($value < 0)
                        if(isset($stats[$field_name]['int']['unsigned']))
                            unset($stats[$field_name]['int']['unsigned']); // should only occur once
                    // count value met in order to decide the field type
                    $stats[$field_name]['count']['int']++;
                    // max value
                    $stats[$field_name]['int']['max'] = max($stats[$field_name]['int']['max'], (int) $value);
                }
                if(is_float($value)){
                    // count value type met in order to decide the field type
                    $stats[$field_name]['count']['float']++;
                }
            } else {
                // string field
                if( ! isset($stats[$field_name]['string'])){
                    $stats[$field_name]['string']['constraint'] = 0;
                }
                // count value type met in order to decide the field type
                $stats[$field_name]['count']['string']++;
                // max value
                $stats[$field_name]['string']['constraint'] = max($stats[$field_name]['string']['constraint'], strlen($value));
            }
        }
        return $stats;
    }

    public function fields_specs($data){
        $fields = $this->_best_fields_specs($this->_fields_stats($data));
        echo '<pre style="background: salmon">';
        print_r($fields);
        echo '</pre>';
        return;
        return $fields;
    }
}