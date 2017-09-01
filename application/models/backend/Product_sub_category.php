<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_sub_category extends MY_Model {

    public $_table = 'it_product_sub_category';
    public $primary_key = 'id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    function get_attributes_dt() {
        $this->db->select('pt.*,pts.*');
        $this->db->from('p_attributes pt');
        $this->db->from('p_sub_attributes pts', 'pt.id=pts.attribute_id');
//        $this->db->group_by('pts.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_product_sub_attribute($pId) {
        $this->db->select('*,pa.attribute_type as test');
        $this->db->from('p_attributes pa');
        $this->db->join('it_product_sub_category ipsc', 'ipsc.p_sub_category_id=pa.id');
        $this->db->join('it_product_category ipc', 'ipc.id = ipsc.p_category_id');
        $this->db->where('ipsc.p_category_id', $pId);
//        $this->db->where('pa.attribute_type!=', '2');

//        $this->db->group_by('pts.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function delete_sub_cat($pId) {
        $this->db->where('p_category_id', $pId);
        $this->db->delete('it_product_sub_category');
    }

    function get_sub_category_name_by_id($product_sub_category) {
        $this->db->select('ipa.attribute_value as name');
        $this->db->from('it_product_attributes ipa');
        $this->db->where('ipa.attribute_id  ', $product_sub_category);
        $query = $this->db->get();
        $name = $query->result_array();
//        echo '<pre>';print_r($name[0]);die;
        if (isset($name[0]))
            return $name[0];
        else
            return NULL;
    }

}
