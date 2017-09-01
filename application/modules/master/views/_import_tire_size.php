<?php // echo '<pre>', print_r($excel_row);die;                                         ?>
<?php // echo '<pre>', print_r($prodcut_cat_detail);die;                                         ?>
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
                <?php if (($excel_row_data) && !empty($excel_row_data)) { ?>
                    <form>
                        <div class="table-responsive">
                            <table class="table" id="product_datatable_csv">
                                <thead>
                                    <tr>
                                        <?php foreach ($excel_row[1] as $rodTitle) { ?>
                                            <th><?php echo $rodTitle; ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>     
</div>