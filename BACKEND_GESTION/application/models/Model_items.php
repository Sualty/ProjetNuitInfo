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
        $this->_table_users = '__contributors';
        $this->_table_ranks = '__ranks';
    }

    private function _exists($id){
        $this->db->where('ref', $id);
        return ($this->db->count_all_results($this->_table) > 0);
    }

    private function _exists_user($user){
        $this->db->where('id', $user);
        return ($this->db->count_all_results($this->_table_users) > 0);
    }

    private function _get_next_rank($user){
        // get user current rank max
        return $this->db
            ->select('__ranks.score')
            ->where('id', $user)
            ->where('__ranks.name', '__contributors.rank')
            ->join($this->_table_ranks, '__ranks.name = __contributors.rank')
            ->get($this->_table_users)
            ->row()
            ->score;
    }

    public function add($id, $user){
        // insert or update
        if ($this->_exists($id) && $this->_exists_user($user)) { // reference exists
            $res = $this->db
                ->set('stock', 'stock+1', FALSE)
                ->set('date_last_modified', time())
                ->where('ref', $id)
                ->update($this->_table);
            if (!$res) // 503 : internal server error
                return 0;
            return $this->db
                ->set('score', 'score+500', FALSE)
                ->where('id', $user)
                ->update($this->_table_users);
        } else // reference doesn't exists - depreciated
            return $this->db->insert($this->_table, array('ref' => $id, 'stock' => 1));
    }

    public function delete($id, $user){
        // update or error
        if ($this->_exists($id) && $this->_exists_user($user)) { // reference exists
            $res = $this->db
                ->set('stock', 'stock-1', FALSE)
                ->set('date_last_modified', time())
                ->where('ref', $id)
                ->update($this->_table);
            if( ! $res) // 503 : internal server error
                return 0;
            $prev = $this->score($user);
            $res = $this->db
                ->set('score', 'score+300', FALSE)
                ->where('id', $user)
                ->update($this->_table_users);
            if( ! $res) // 503 : internal server error
                return 0;
            $after = $this->score($user);
        }
        else // reference doesn't exists
            return -1;
    }

    public function stock($id){
        if ($this->_exists($id)) // reference exists
            return $this->db
                ->select('stock')
                ->where('ref', $id)
                ->get($this->_table)
                ->row()
                ->stock;
        else
            return -1;
    }

    public function score($user){
        if($this->_exists_user($user))
            return $this->db
                ->select('score')
                ->where('id', $user)
                ->get($this->_table_users)
                ->row()
                ->score;
        else
            return -1;
    }

    public function rank($user){
        if($this->_exists_user($user))
            return $this->db
                ->select('rank')
                ->where('id', $user)
                ->get($this->_table_users)
                ->row()
                ->rank;
        else
            return -1;
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