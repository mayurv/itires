<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mst_make extends MY_Model {

    public $_table = 'it_mst_make';
    public $primary_key = 'id';
//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }
    public function checkIsExist($makeName) {
        $this->db->select('id');
        $this->db->from('it_mst_make im');
        $this->db->like('name', $makeName);
        $query = $this->db->get();
        $res = $query->result_array();
        if (isset($res[0]) && $res[0] != '')
            return $res[0]['id'];
        else
            return 0; //not exist
    }

}

/* End of file Mst_Make.php */
/* Location: ./master/Mst_Make.php */