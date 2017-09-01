<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Global_Setting_Model extends CI_Model
{
    /* Function to get global settings from the database if edit_id and lang_id black then it will return all reacords start */

    public function getGlobalSettingsGlobal($edit_id = '')
    {
        $this->db->select('mst_global.global_name_id as global_id,mst_global.name,trans_global.*');
        $this->db->from(TABLES::$MST_GLOBAL_SETTING . ' as mst_global');
        $this->db->join(TABLES::$TRANS_GLOBAL_SETTING . ' as trans_global', 'mst_global.global_name_id = trans_global.global_name_id', 'left');
        if ($edit_id != '') {
            $this->db->where("mst_global.global_name_id", $edit_id);
        }
        $result = $this->db->get();
        return $result->result_array();
    }

    /* Function to get global settings from the database if edit_id and lang_id black then it will return all reacords end */
}
