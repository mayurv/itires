<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonial extends MY_Model {

    public function get_testimonial() {
        $q = $this->db->where('status', 'Active')->get('mst_testimonial');
        return $q->result_array();
    }

    public function get_blog() {

        return $this->db->count_all("mst_blog_posts");
    }

    public function get_blog_d() {
        $q = $this->db->get('mst_blog_posts');
        return $q->result_array();
    }

    public function get_blog_home() {

        $q = $this->db->limit(3)->order_by("post_id","desc")->get('mst_blog_posts');

        return $q->result_array();
    }

    public function blog_details($limit, $id,$blog_id = null) {
        if (isset($blog_id))
            
            $query = $this->db->where('category_id', $blog_id)->get("mst_blog_posts");
            $query = $this->db->limit($limit, $id)->get("mst_blog_posts");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
public function blog_cat_detail($blog_id = null) {
    $query = $this->db->where('category_id', $blog_id)->get("mst_blog_posts");
//        if ($limit!='' &$id!='')
//        {
//          $query = $this->db->limit($limit, $id)->get("mst_blog_posts");  
//        }  
// else {
//     $query = $this->db->where('category_id', $blog_id)->get("mst_blog_posts");
// }
          

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function get_single_post($id) {
        $q = $this->db->where('post_id', $id)->get('mst_blog_posts');
        return $q->result_array();
    }

    public function get_relative_blog($id) {
        $q = $this->db->where('category_id', $id)->get('mst_blog_posts');
        return $q->result_array();
    }

}

/* End of file Product.php */
/* Location: ./models/backend/Product.php */