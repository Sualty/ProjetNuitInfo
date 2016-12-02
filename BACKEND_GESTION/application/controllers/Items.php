<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class used to use items
 *
 * @package     Controllers
 * @subpackage  Items
 * @author	 	Julien Andre <julienandre1199@gmail.com>
 */
class Items extends FM_Controller {

    public function index(){
        $this->load->view('templates/header');
        $this->load->view('items/view');
        $this->load->view('templates/footer');
    }

    public function add(){
        $this->load->model('model_items');

        $id = json_decode($this->input->get('json'))->ref;

        if($this->model_items->add($id))
            echo json_encode(array('status' => '200', 'ref' => $id, 'stock' => $this->model_items->stock($id)));
        else
            echo json_encode(array('status' => '503')); // Internal server error
    }

    public function delete(){
        $this->load->model('model_items');

        $id = json_decode($this->input->get('json'))->ref;

        $feedback = $this->model_items->delete($id);
        if($feedback === -1)
            echo json_encode(array('status' => '404')); // Unkown reference
        if($feedback)
            echo json_encode(array('status' => '200', 'ref' => $id, 'stock' => $this->model_items->stock($id)));
        else
            echo json_encode(array('status' => '503')); // Internal server error
    }

    public function get(){
        $this->load->model('model_items');

        $id = json_decode($this->input->get('json'))->ref;

        $feedback = $this->model_items->get($id);
        if($feedback === -1)
            echo json_encode(array('status' => '404')); // Unkown reference
        if($feedback)
            echo json_encode(array('status' => '200', 'ref' => $id, 'stock' => $feedback->stock
            , 'name' => $feedback->name, 'image' => base64_encode($feedback->image), 'brand' => $feedback->brand
            , 'date_last_modified' => date("d/m/Y H:i:s", $feedback->date_last_modified)));
        else
            echo json_encode(array('status' => '503')); // Internal server error
    }

    public function get_all(){
        $this->load->model('model_items');

        $feedback = $this->model_items->get_all();
        if($feedback){
            foreach ($feedback as $row){
                $row->date_last_modified = date("d/m/Y H:i:s", $row->date_last_modified);
                $row->image = base64_encode($row->image);
            }
            echo json_encode(array('status' => '200', 'data' => $feedback));
        } else
            echo json_encode(array('status' => '503')); // Internal server error
    }

    public function get_by_category(){
        $this->load->model('model_items');

        $cat_id = json_decode($this->input->get('json'))->cat_ref;

        $feedback = $this->model_items->get_by_category($cat_id);
        if($feedback === -1)
            echo json_encode(array('status' => '404')); // Unkown reference
        if($feedback) {
            foreach ($feedback as $row){
                $row->date_last_modified = date("d/m/Y H:i:s", $row->date_last_modified);
                $row->image = base64_encode($row->image);
            }
            echo json_encode(array('status' => '200', 'cat_ref' => $cat_id, 'data' => $feedback));
        } else
            echo json_encode(array('status' => '503')); // Internal server error
    }
}
