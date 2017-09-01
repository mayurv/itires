<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends MY_Model {

    public $_table = 'it_products';
    public $primary_key = 'id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    function get_products($start = null, $limit = null) {

        $this->db->select('ip.*,ipm.*,ip.id as id,opr.review_total');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
        $this->db->join('it_product_review opr', 'opr.product_id = ip.id', 'LEFT');

        $this->db->order_by('ip.id', 'DESC');
        $this->db->where('ip.isactive', 0);
        $this->db->group_by('ip.id');

        if ($start != null && $limit != null)
            $this->db->limit($limit, $start);
        else
            $this->db->limit(10, 0);


        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_product_by_category_id($categoryId = null, $subCategoryId = null, $start = null, $limit = null, $offer = null) {

        $this->db->select('ip.*,ipm.*,ip.id as id,opr.review_total');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('it_product_review opr', 'opr.product_id = ip.id', 'LEFT');

        if (isset($categoryId) && $categoryId != null) {
            $this->db->where('ip.category_id', $categoryId);
        }
        if (isset($subCategoryId) && $subCategoryId != null) {
            $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->where('ipa.attribute_id', $subCategoryId);
        }
//        if ($categoryId = null && $subCategoryId = null)
        $this->db->order_by('ip.id', 'DESC');
        $this->db->where('ip.isactive', 0);

        if ($offer != null) {


            $this->db->where('ip.is_offer_publish', 1);
        }
        $this->db->group_by('ip.id');

        if ($start != null && $limit != null)
            $this->db->limit($limit, $start);
        else
            $this->db->limit(6, 0);


        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_product_by_category_page($categoryId = null, $start = 0, $limit) {

        $this->db->select('ip.*,ipm.*,ip.id as id,opr.review_total');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('it_product_review opr', 'opr.product_id = ip.id', 'LEFT');

        if (isset($categoryId) && $categoryId != null && $categoryId != 0) {
            $this->db->where('ip.category_id', $categoryId);
        }
        if (isset($subCategoryId) && $subCategoryId != null) {
            $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->where('ipa.attribute_id', $subCategoryId);
        }
//        if ($categoryId = null && $subCategoryId = null)
        $this->db->order_by('ip.id', 'DESC');

        $this->db->where('ip.isactive', 0);

        $this->db->group_by('ip.id');
//        echo $start;die;
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_product_by_count($categoryId = null) {
        $this->db->cache_on();
        $this->db->select('count(ip.id)');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');

        if (isset($categoryId) && $categoryId != null && $categoryId != 0) {
            $this->db->where('ip.category_id', $categoryId);
        }
        // if (isset($subCategoryId) && $subCategoryId != null) {
        $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
        //$this->db->where('ipa.attribute_id', $subCategoryId);
        // }
        //if ($categoryId = null && $subCategoryId = null)
        $this->db->order_by('ip.id', 'DESC');

        $this->db->where('ip.isactive', 0);

        $this->db->group_by('ip.id');
//        echo $start;die;
        // $//this->db->limit($limit, $start);
        $query = $this->db->get();
        $this->db->cache_off();
        return $query->num_rows();
    }

    function get_filter_product($make_id = null, $year_id = null, $model_id = null, $product_category_id = null, $product_sub_category = null, $searchTearm = null, $start = null, $limit = null, $filterTearm = null, $bySize = null) {

//        die;
//        echo $start;
//
//        if (strstr($product_category_id, '_')) {
//            $id = explode('_', $product_category_id);
//            $product_category_id = $id[0];
//            $product_sub_category = $id[1];
//        } else {
//            $product_category_id = $product_category_id;
//            $product_sub_category = null;
//        }


        $this->db->select('ip.*,ipm.*,ip.id as id,opr.review_total');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('it_product_review opr', 'opr.product_id = ip.id', 'LEFT');
        if (isset($product_category_id) && $product_category_id != '' && $searchTearm == null)
            $this->db->where('ip.category_id', $product_category_id);
        if ($make_id != null)
            $this->db->where('ip.make_id', $make_id);
        if ($year_id != null)
            $this->db->where('ip.year_id', $year_id);
        if ($model_id != null)
            $this->db->where('ip.model_id', $model_id);

        if (isset($product_sub_category) && $product_sub_category != '' && $searchTearm == null) {
            $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->where('ipa.attribute_id', $product_sub_category);
        }
        if (isset($product_sub_category) && $product_sub_category != '' && $searchTearm == 'brand') {
            $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->where('ipa.sub_attribute_dp_id', $product_sub_category);
        }


        /* filter tearms */
        if ($filterTearm != null) {
            if (isset($filterTearm['price']) && $filterTearm['price'] != '') {
                $price_r = explode(',', $filterTearm['price']);
                $this->db->where("ip.price BETWEEN $price_r[0] AND $price_r[1]");
            }
            if (isset($filterTearm['brand']) && $filterTearm['brand'] != '') {
//                echo '<pre>', print_r($filterTearm['brand']);die;
                $brand_id = explode(',', $filterTearm['brand']);
//                print_r($brand_id);die();
                $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
//                foreach ($brand_id as $bid)
                $this->db->where_in('ipa.sub_attribute_value', $brand_id);
//                echo 'bb<pre>',print_r($filterTearm);die();
            }
        }

        /* filter tearms */

        /* By Size */
        if ($bySize != null) {
//            $this->db->select('ipa.*');
            $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->where('ipa.sub_attribute_value', $bySize);
        }
        /* By Size */


        $this->db->order_by('ip.id', 'DESC');

        $this->db->where('ip.isactive', 0);
        $this->db->group_by('ip.id');

        if (isset($start) && $start != NULL)
            $this->db->limit($start, $limit);
        else
            $this->db->limit(6);
        $query = $this->db->get();

        return $query->result_array();
    }

    function get_filter_product_count($make_id = null, $year_id = null, $model_id = null, $product_category_id = null, $product_sub_category = null, $searchTearm = null, $bySize = null) {
        $this->db->cache_on();
//  
//        if (strstr($product_category_id, '_')) {
//            $id = explode('_', $product_category_id);
//            $product_category_id = $id[0];
//            $product_sub_category = $id[1];
//        } else {
//            $product_category_id = $product_category_id;
//            $product_sub_category = null;
//        }

//        $query = $this->db->query('SELECT `ip`.*, `ipm`.*, `ip`.`id` as `id` FROM `it_products` `ip` LEFT JOIN `it_products_image` `ipm` ON `ipm`.`product_id` = `ip`.`id` LEFT JOIN `it_product_attributes` `ipa` ON `ipa`.`product_id` = `ip`.`id` WHERE `ip`.`category_id` = 1 AND `ipa`.`sub_attribute_value` LI '."%205/55R16".' AND `ip`.`isactive` =0 GROUP BY `ip`.`id`');
//        echo '<pre>',print_r($query);die;
        $this->db->select('count(ip.id)');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id', 'LEFT');

       
        if (isset($product_category_id) && $product_category_id != '' && $searchTearm == null)
            $this->db->where('ip.category_id', $product_category_id);
        if ($make_id != null)
            $this->db->where('ip.make_id', $make_id);
        if ($year_id != null)
            $this->db->where('ip.year_id', $year_id);
        if ($model_id != null)
            $this->db->where('ip.model_id', $model_id);
         /* By Size */
        if ($bySize != null) {
//            $this->db->select('ipa.*');
            $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id', 'LEFT');
            $this->db->like('ipa.sub_attribute_value', $bySize);
        }
        /* By Size */
        if (isset($product_sub_category) && $product_sub_category != '' && $searchTearm == null) {
            $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id', 'LEFT');
            $this->db->where('ipa.attribute_id', $product_sub_category);
        }
        if (isset($product_sub_category) && $product_sub_category != '' && $searchTearm == 'brand') {
            $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id', 'LEFT');
            $this->db->where('ipa.sub_attribute_dp_id', $product_sub_category);
        }
        /* filter tearms */
        
//        if($searchTearm == 'brand'){
////            echo $product_sub_category;die;
//            $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
//            $this->db->where('ipa.sub_attribute_value', $product_sub_category);
//        }
       



        $this->db->where('ip.isactive', 0);
        $this->db->group_by('ip.id');
        if (isset($start) && $start != NULL)
            $this->db->limit($start, $limit);
//        else
//            $this->db->limit(6);
        
        $query = $this->db->get();
//        echo '<pre>',print_r($query->num_rows());
//       echo $this->db->last_query();die;
        $this->db->cache_off();
        return $query->num_rows();
    }

    public function get_all_plugin_images_by_category($make_id = null, $year_id = null, $model_id = null, $product_category_id = null, $filterTearm = null, $productId = null) {
//        print_r($filterTearm);
//        die();
        $this->db->select('ipa.sub_attribute_value');
        $this->db->from('it_products ip');
        $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
        if ($make_id != null)
            $this->db->where('ip.make_id', $make_id);
        if ($year_id != null)
            $this->db->where('ip.year_id', $year_id);
        if ($model_id != null)
            $this->db->where('ip.model_id', $model_id);

        if (isset($product_category_id) && $product_category_id != '')
            $this->db->where('ip.category_id', $product_category_id);


//        if (isset($filterTearm['brand']) && $filterTearm['brand'] != '') {
//            $brand_id = explode(',', $filterTearm['brand']);
//            //$this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
//            foreach ($brand_id as $bid)
//                $this->db->where('ipa.sub_attribute_id', $bid);
////                echo 'bb<pre>',print_r($filterTearm);die();
//        }
        if (isset($filterTearm['brand']) && $filterTearm['brand'] != '') {
            $brand_id = explode(',', $filterTearm['brand']);
//            $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
//            foreach ($brand_id as $bid)
            $this->db->where_in('ipa.sub_attribute_id', $brand_id);
//                echo 'bb<pre>',print_r($filterTearm);die();
        }
        if (isset($filterTearm['price']) && $filterTearm['price'] != '') {
            $price = explode(',', $filterTearm['price']);
//            $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
//            foreach ($brand_id as $bid)
            $this->db->where_in('ipa.sub_attribute_id', $price);
//                echo 'bb<pre>',print_r($filterTearm);die();
        }
        $this->db->where('ipa.attribute_type', 2);
        if (isset($productId))
            $this->db->where('ip.id', $productId);

        $this->db->order_by('ip.id', 'DESC');
        $this->db->group_by('ip.id');
        $query = $this->db->get();
//        echo $this->db->last_query();
        //  die;
        $data = $query->result_array();
//        echo '<pre>', print_r($data);die;
        if (isset($productId) && $productId != null && isset($data[0])) {
            return $data[0];
        } else
            return $data;
    }

    function get_feature_product() {

        $this->db->select('ip.*,ipm.*,ip.id as id,opr.review_total');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('it_product_review opr', 'opr.product_id = ip.id', 'LEFT');
        $this->db->where('ip.product_is_feature', '1');
        $this->db->group_by('ip.id');
        $this->db->order_by('ip.id', 'DESC');
        $this->db->limit(4);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_product_by_product_id($profuctId) {

        $this->db->select('ip.*,ipm.*,ip.id as id,opr.review_total');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('it_product_review opr', 'opr.product_id = ip.id', 'LEFT');
        $this->db->where('ip.id', $profuctId);
        $this->db->group_by('ip.id');
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_offer_product($categoryId) {

        $this->db->select('ip.*,ipm.*,ip.id as id,opr.review_total');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('it_product_review opr', 'opr.product_id = ip.id', 'LEFT');
        $this->db->where('ip.is_offer_publish', 1);
        $this->db->where('ip.category_id', $categoryId);
        $this->db->group_by('ip.id');
        $this->db->limit(3);
        $query = $this->db->get();
        $offerData = $query->result_array();
        if (!empty($offerData))
            return $offerData;
        else
            return null;
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_all_offer_product() {

        $this->db->select('ip.*,ipm.*,ip.id as id,opr.review_total');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('it_product_review opr', 'opr.product_id = ip.id', 'LEFT');
        $this->db->where('ip.is_offer_publish', 1);
//        $this->db->where('ip.category_id', $categoryId);
        $this->db->group_by('ip.category_id');
        $this->db->order_by('ip.category_id', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get();
        $offerData = $query->result_array();
//        echo $this->db->last_query();die;
        if (!empty($offerData))
            return $offerData;
        else
            return null;
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_best_seller_products() {

        $this->db->select('ip.*,ipm.*,ip.id as id,opr.review_total');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('it_product_review opr', 'opr.product_id = ip.id', 'LEFT');
//        $this->db->where('ip.is_offer_publish', 1);
        $this->db->where('ip.category_id', '2');
        $this->db->group_by('ip.id');
        $this->db->order_by('ip.product_sale_count', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get();
        $sellerData = $query->result_array();
        if (!empty($sellerData))
            return $sellerData;
        else
            return null;
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    public function get_product_by_cat_id($id) {
        $q = $this->db->where('category_id', $id)->get('it_products');
        return $q->result_array();
    }

    public function delete_product($id) {
        $this->db->where('id', $id)->delete('it_products');
        return true;
    }

    public function get_all_inactive_product() {
        $q = $this->db->where('isactive', 1)->get('it_products');
        return $q->result_array();
    }

    public function update_sale_count($productId, $data) {
        $this->db->where('id', $productId);
        $this->db->set('product_sale_count', 'product_sale_count' + $data['product_sale_count'], FALSE);
        $this->db->set('quantity', 'quantity' - $data['product_quantity'], FALSE);
        $this->db->update('it_products');
        return true;
    }

}

/* End of file Product.php */
/* Location: ./models/backend/Product.php */