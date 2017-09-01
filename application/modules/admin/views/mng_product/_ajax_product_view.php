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
                    <!--<td><?php // echo $productData['description'];                      ?></td>-->
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