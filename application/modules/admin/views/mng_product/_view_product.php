<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo $page_title; ?></h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php
//        echo '<pre>', print_r($this->session->flashdata());
            $msg = $this->session->flashdata('msg');
            if ($msg != '') {
                ?>
                <script>
                    $(document).ready(function () {
                        new PNotify({

                            title: 'Success',

                            text: '<?php echo $msg; ?>',
                            type: 'success',
                            styling: 'bootstrap3',
                            nonblock: {
                                nonblock: false
                            }
                        });
                    });
                </script>
            <?php } ?>
            <div class="x_panel">
                <div class="x_title">
                    <h2>Products</h2>
                    <a href="<?php echo base_url(); ?>admin/product/exportcsv" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-file-excel-o" ></i> Export Product</a>
                    <a href="<?php echo base_url(); ?>admin/product/addcsv" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-file-excel-o" ></i> Import Product</a>
                    <a href="<?php echo base_url(); ?>admin/product/add" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-plus-circle" ></i> Add Product</a>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" id="product_ajax_view">                    
                    <div class="pull-right">
                        <?php echo $this->ajax_pagination_product->create_links(); ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table id="" class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Product Name</td>
                                    <td>Category</td>
                                    <td>Make</td>
                                    <td>Year</td>
                                    <td>Model</td>
                                    <td>Quantity</td>
                                    <td>Price</td>
                                    <!--<td>Description</td>-->
                                    <td>SKU</td>
                                    <td>shipping_region</td>
                                    <td>Status</td>
                                    <td>#</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($product_details))  ?>
                                <?php foreach ($product_details as $productData) { ?>
                                    <tr>
                                        <td width="">
                                            <p>
                                                <?php if (isset($productData['product_images_details']) && !empty($attribute_details['product_images_details']))  ?>
                                                <?php foreach ($productData['product_images_details'] as $imgData) { ?>
                                                    <image class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url() . $imgData['url']; ?>"/>
                                                <?php } ?>
                                            </p>
                                            <p><?php echo $productData['product_name']; ?></p>
                                        </td>
                                        <td><?php echo isset($product_category[$productData['category_id']]) ? $product_category[$productData['category_id']] : ''; ?></td>
                                        <td><?php echo isset($product_make[$productData['make_id']]) ? $product_make[$productData['make_id']] : ''; ?></td>
                                        <td><?php echo isset($product_year[$productData['year_id']]) ? $product_year[$productData['year_id']] : '' ?></td>
                                        <td><?php echo isset($product_model[$productData['model_id']]) ? $product_model[$productData['model_id']] : ''; ?></td>
                                        <td><?php echo isset($productData['quantity']) ? $productData['quantity'] : $productData['quantity']; ?></td>
                                        <td><?php echo isset($productData['price']) ? $productData['price'] : $productData['price']; ?></td>
                                        <!--<td><?php // echo $productData['description'];                   ?></td>-->
                                        <td><?php echo isset($productData['product_sku']) ? $productData['product_sku'] : ''; ?></td>
                                        <td><?php echo isset($productData['shipping_region']) ? $productData['shipping_region'] : ''; ?></td>
                                        <td><?php echo $productData['isactive'] == '0' ? 'Active' : 'In - Active' ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-default btn-round" href="<?php echo base_url(); ?>admin/product/edit/<?php echo $productData['id']; ?>"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-xs btn-default btn-round" href="<?php echo base_url(); ?>admin/product_delete_soft/<?php echo $productData['id']; ?>"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right">
                        <?php echo $this->ajax_pagination_product->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>     
</div>

<script>
    $(document).ready(function () {

        $("#product_datatable").dataTable();

    });
</script>
<script>
    function searchProductFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var keywords = 'view_on_vehicle_product';
        var sortBy = $('#sortBy').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/ajaxPaginationData/' + page_num,
            data: 'page=' + page_num + '&keywords=' + keywords + '&sortBy=' + sortBy,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#product_ajax_view').html('');
                $('#product_ajax_view').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
</script>