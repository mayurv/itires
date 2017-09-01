<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mst_year extends MY_Model {

    public $_table = 'it_mst_year';
    public $primary_key = 'id';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    function get_all_year_by_make_id($make_id) {
        $this->db->select('*');
        $this->db->from('it_mst_year imy');
        $this->db->where('make_id', $make_id);
        $this->db->order_by('name', 'DESC');
//        $this->db->limit(6);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function checkYsYearExist($make_id, $year_id) {
        $this->db->select('id');
        $this->db->from('it_mst_year imy');
        $this->db->where('make_id', $make_id);
        $this->db->like('name', $year_id);
        $query = $this->db->get();
        $res = $query->result_array();
        if (isset($res[0]) && $res[0] != '')
            return $res[0]['id'];
        else
            return 0; //not exist
    }

    function delete_make($make_id) {
        $this->db->where('make_id', $make_id);
        $this->db->delete('it_mst_year');
    }

    function delete_year($make_id, $year) {
        $this->db->where('make_id', $make_id);
        $this->db->where('name', $year);
        $this->db->delete('it_mst_year');
    }

    function delete_year_by_make($make_id) {
        $this->db->where('make_id', $make_id);
        $this->db->delete('it_mst_year');
    }

    public function get_year_name($yearId) {
        $this->db->select('name');
        $query = $this->db->get_where('it_mst_year', array('id' => $yearId));
        $ret = $query->row();
        if (isset($ret->name))
            return $ret->name;
        else
            return null;
    }

}

/* End of file Mst_Year.php */
/* Location: ./master/Mst_Year.php */