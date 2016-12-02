<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class used to use cascade select
 *
 * @package     Models
 * @subpackage  Items
 * @author	 	Julien Andre <julienandre1199@gmail.com>
 */
class Model_items extends FM_Model {

    private $_table;

    public function __construct(){
        parent::__construct();
        $this->_table = '__items';
    }

    private function _exists($id){
        $this->db->where('ref', $id);
        return ($this->db->count_all_results($this->_table) > 0);
    }

    public function add($id){
        // insert or update
        if ($this->_exists($id)) { // reference exists
            return $this->db
                ->set('stock', 'stock+1', FALSE)
                ->set('date_last_modified', time())
                ->where('ref', $id)
                ->update($this->_table);
        } else { // reference doesn't exists - depreciated
            return $this->db->insert($this->_table, array('ref' => $id, 'stock' => 1));
        }
    }

    public function delete($id){
        // update or error
        if ($this->_exists($id)) { // reference exists
            return $this->db
                ->set('stock', 'stock-1', FALSE)
                ->set('date_last_modified', time())
                ->where('ref', $id)
                ->update($this->_table);
        } else { // reference doesn't exists
            return -1;
        }
    }
    
    public function stock($id){
        if ($this->_exists($id)) { // reference exists
            return $this->db
                ->select('stock')
                ->where('ref', $id)
                ->get($this->_table)
                ->row()
                ->stock;
        } else {
            return -1;
        }
    }

    public function get($id){
        if ($this->_exists($id))
            return $this->db
                ->select('lib as name, stock, brand, image, date_last_modified, category')
                ->where('ref', $id)
                ->get($this->_table)
                ->row();
        else
            return -1;
    }

    public function get_by_category($cat_id){
        return $this->db
            ->select('lib as name, stock, brand, image, date_last_modified')
            ->where('category', $cat_id)
            ->get($this->_table)
            ->result_object();
    }

    public function get_all(){
        return $this->db
            ->select('lib as name, stock, brand, image, date_last_modified, category')
            ->get($this->_table)
            ->result_object();
    }
}