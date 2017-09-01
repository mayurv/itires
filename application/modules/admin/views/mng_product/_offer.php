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
            <div class="x_panel">
                <div class="x_title">
                    <h2>Products</h2>.
                    <div class="pull-right">
                        <button type="button" id="id_offer" class="btn btn-xs btn-primary"><i class="fa fa-chain"> </i> Publish Offer of the week</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="table-responsive">
                        <form id="form_offer" method="post" action="<?php echo base_url() ?>admin/offer/modify">
                            <table id="product_offer_dt" class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Product Name</td>
                                        <td>Category</td>
                                        <td>Make Year Model </td>
                                        <td>Price</td>
                                        <td>Discounted Price</td>

<!--<td>Description</td>-->
                                        <td>Status</td>
                                        <td>#</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (isset($product_details))  ?>
                                    <?php foreach ($product_details as $productData) { ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="productCheck_<?php echo $productData['category_id'] ?>" name="productCheck[<?php echo $productData['category_id'] ?>]" onclick="funEditDiscountedOffer(<?php echo $productData['id']; ?>)">
                                            </td>
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
                                            <td><?php echo isset($product_make[$productData['make_id']]) ? $product_make[$productData['make_id']] : ''; ?>
                                                <?php echo isset($product_year[$productData['year_id']]) ? $product_year[$productData['year_id']] : '' ?>
                                                <p><button class="btn btn-xs btn-default"><?php echo isset($product_model[$productData['model_id']]) ? $product_model[$productData['model_id']] : ''; ?></button></p>
                                            </td>
                                            <td id="tr_price_<?php echo $productData['id'] ?>"><?php echo isset($productData['price']) ? $productData['price'] : $productData['price']; ?></td>
                                            <td><input  type="number" min="0"  id="id_discount_<?php echo $productData['id'] ?>" name="discount_<?php echo $productData['id'] ?>" readonly value="<?php echo $productData['discounted_price'] ?>"></td>
                                            <!--<td><?php // echo $productData['description'];                                              ?></td>-->
                                            <td><?php echo $productData['isactive'] == '0' ? 'Active' : 'In - Active' ?></td>
                                            <td><a class="btn btn-xs btn-default btn-round" ><i class="fa fa-pencil"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>     
</div>


<script>
    $(document).ready(function () {
        $("#product_offer_dt").dataTable();
        $("#id_offer").click(function () {
            $("#form_offer").submit();
            return false;
        });
    });
</script>
<script>
    function funEditDiscountedOffer(productId) {

        $("#id_discount_" + productId).removeAttr('readonly');
        $("#id_discount_" + productId).prop('required', true);
        var max_rate = $("#tr_price_" + productId).text();
        $("#id_discount_" + productId).attr({"max": max_rate});
    }
</script>