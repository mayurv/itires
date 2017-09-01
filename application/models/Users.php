<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author admin
 */
class Users extends MY_Model {

    //put your code here

    public $_table = 'users';
    public $primary_key = 'id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'active';

   

    function get_slug_by_id($id) {
        if ($id != null) {
            $obj = $this->db->select('salt')->get_where('main_users', array('id' => $id))->row();
            if (isset($obj)) {
                return $obj->salt;
            }
        }

        return null;
    }
    
    public function get_allData($user_id){
           $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        $objData = $query->result_array();
        if(isset($objData[0]))
        return $objData[0];
        else
            return NULL;
    }

    public function update_user_group_id($group_data) {
        $this->db->set('group_id', $group_data['group_id']);
        $this->db->where('id', $group_data['user_id']);
        $this->db->update('main_users');
    }

    public function update_user_status_id($id) {

        if (isset($id) && $id != NULL) {
            $this->db->set('isactive', '5');
            $this->db->where('id', $id);
            $this->db->update('main_users');
            return true;
        } else {
            return false;
        }
    }
    
    public function check_email($email_id) {

        $result =  $this->db->select('email')->get_where('main_users', array('email' => $email_id))->row();
        if(isset($result))
            return FALSE;
        else
            return TRUE;
        
    }
    
     public function delete_user_data($id) {
       return $this->db->where('id', $id)->delete('users');
       return $this->db->where('user_id', $id)->delete('users_groups');
        // return $q->result_array();
    }

}
