<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mst_model_size extends MY_Model {

    public $_table = 'it_mst_model_size';
    public $primary_key = 'id';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    public function get_model_size_detail($model_id) {
        $this->db->select('imms.*');
        $this->db->from('it_mst_model imm');
        $this->db->join('it_mst_model_size imms', 'imm.id=imms.model_id', 'left');
        $this->db->where('imms.model_id', $model_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_all_size() {
        $this->db->distinct();
        $this->db->select('size1,size2,size3');
        $this->db->from('it_mst_model_size');
        $this->db->where('size1!=', '-');
        $this->db->where('size2!=', '-');
        $this->db->where('size3!=', '-');
        $query = $this->db->get();
        return $query->result_array();
    }

}

/* End of file Mst_model_size.php */
/* Location: ./master/Mst_model_size.php */