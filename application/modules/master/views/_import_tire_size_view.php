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
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Sizes</h2>
                <div class="pull-right"><a href="<?php echo base_url(); ?>master/model" class="btn btn-sm btn-default">Back to page</a></div>
                <div class="clearfix"></div>
            </div>
            <form action="<?php echo site_url(); ?>master/model/upload_csv" method="post" enctype="multipart/form-data">
                <div class="x_content">

                    <?php echo form_label(lang('size_csv'), 'size_csv', array('for' => 'size_csv', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                    <table>
                        <tr>
                        </tr>
                        <tr>
                            <td>
                                <input type="file" class="form-control" name="sizecsv" id="userfile"  align="center" required=""eq />
                                <p class="text-danger"><?php echo $this->session->flashdata('msg'); ?></p>
                            </td>
                            <td>
                                <div class="col-lg-offset-3 col-lg-9">
                                    <button type="submit" name="submit" class="btn btn-info">Upload CSV File</button>
                                </div>
                            </td>
                        </tr>

                    </table> 
                </div>
            </form>
            <hr>
            <?php if (($excel_row_data) && !empty($excel_row_data)) { ?>
                <form action="<?php echo base_url(); ?>master/upload_tire_csv" method="post">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-sm btn-primary pull-right" >Import Size</button>
                    </div>
                    <div class="clearfix"></div>

                    <div class="table-responsive">
                        <table class="table" id="">
                            <thead>
                                <tr>
                                    <th>Make</th>
                                    <th>Model</th>
                                    <th>Year</th>
                                    <th>Trim</th>
                                    <th>Size</th>
                                    <th>Image</th>
                                    <?php // foreach ($excel_row[1] as $rodTitle) { ?>
                                        <!--<th><?php // echo $rodTitle; ?></th>-->
                                    <?php // } ?>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if (!empty($excel_row_data)) { ?>
                                    <?php foreach ($excel_row_data as $rowData) { ?>
                                        <?php if ($rowData['A'] != null) { ?>
                                            <tr>
                                                <td>
                                                    <?php
//                                                                echo $key;
                                                    echo form_dropdown(array(
                                                        'id' => 'make',
                                                        'name' => 'make[]',
                                                        'class' => 'form-control',
//                                                        'required' => 'required',
                                                        'placeholder' => 'Select Category'
                                                            ), $product_make, set_value('make', array_search($rowData['A'], $product_make))
                                                    );
                                                    ?>
                                                    <input name="make_name[]" value="<?php echo $rowData['A']; ?>" class=""  hidden=""> </td>
                                                <td>
                                                    <input name="model[]" value="<?php echo $rowData['B']; ?> <?php echo $rowData['D']; ?>" class="form-control"></td>
                                                <td><input name="year[]" value="<?php echo $rowData['C']; ?>" class="form-control"></td>
                                                <td><input name="trim[]" value="<?php echo $rowData['D']; ?>" class="form-control"></td>
                                                <td><input name="tire_size[]" value="<?php echo $rowData['E']; ?>" class="form-control"></td>
                                                <td style="width:20%">
                                                    <?php if (isset($rowData['F']) && $rowData['F'] != '' && file_exists(base_url() . $rowData['F'])) { ?>
                                                        <image class="img-responsive img-thumbnail  " src="<?php echo base_url() . $rowData['F'] ?>" style="width:50%"/>
                                                    <?php } else { ?>
                                                        <image class="img-responsive img-thumbnail  " src="<?php echo base_url() ?>media/no-image-box.png" style="width:50%"/>
                                                    <?php } ?>
                                                    <input hidden="" value="<?php echo isset($rowData['F']) ? $rowData['F'] : ''; ?>" name="modal_image_csv[]">
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-sm btn-primary pull-right" >Import Size</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>  
<script>
    $(document).ready(function () {
        $("#size_datatable_csv").dataTable();
    });
</script>