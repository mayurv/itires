<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mst_model extends MY_Model {

    public $_table = 'it_mst_model';
    public $primary_key = 'id';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    public function get_make_detail($start = null, $limit = null) {
//        ,imms.size1,imms.size2,imms.size3,imms.tire_type
        $this->db->select('imm.*,imk.name as make_name, imy.name as year_name');
        $this->db->from('it_mst_model imm');
        $this->db->join('it_mst_make imk', 'imm.make_id=imk.id', 'left');
        $this->db->join('it_mst_year imy', 'imm.year_id=imy.id', 'left');
//        $this->db->join('it_mst_model_size imms', 'imm.id=imms.model_id','left');
        $this->db->order_by('imm.id', 'DESC');
        if ($start != null && $limit != null)
            $this->db->limit($limit, $start);
        else
            $this->db->limit(10, 0);

        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_model_by_id($yearId, $makeId) {
        $this->db->select('imm.name,imm.id');
        $this->db->from('it_mst_model imm');
        $this->db->where('make_id', $makeId);
        $this->db->where('year_id', $yearId);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_model_images_by_category($model_id) {
        $this->db->select('*');
        $this->db->from('it_mst_model imm');
        $this->db->where('id', $model_id);
        $query = $this->db->get();
        $image = $query->result_array();
        if (isset($image[0]))
            return $image[0];
        else
            return NULL;
    }

    public function delete_model($model_id) {
        $this->db->where('id', $model_id);
        $this->db->delete('it_mst_model');
        return TRUE;
    }

    public function update_model($model_id, $data) {
        $this->db->where('id', $model_id);
        $this->db->update('it_mst_model', $data);
        return TRUE;
    }

    public function checkIsExist($modelName, $makeId, $yearId) {
        $this->db->select('*');
        $this->db->from('it_mst_model imm');
        $this->db->where('make_id', $makeId);
        $this->db->where('year_id', $yearId);
        $this->db->like('name', $modelName);
        $query = $this->db->get();
        $res = $query->result_array();
        if (isset($res[0]) && $res[0] != '')
            return $res[0]['id'];
        else
            return 0; //not exist
    }

    public function get_model_name($modelId) {
        $this->db->select('name');
        $query = $this->db->get_where('it_mst_model', array('id' => $modelId));
        $ret = $query->row();
        if(isset($ret->name))
            return $ret->name;
        else
            return null;
    }

}

/* End of file Mst_Model.php */
/* Location: ./master/Mst_Model.php */