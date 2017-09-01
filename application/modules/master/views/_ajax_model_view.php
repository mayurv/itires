<div class="pull-right">
    <?php echo $this->ajax_pagination_product->create_links(); ?>
</div>
<table id="model_datatable" class="table">
    <thead>
        <tr>
            <th>Make</th>
            <th>Year</th>
            <th>Model</th>
            <th>Status</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($model_detail))  ?>
        <?php foreach ($model_detail as $mdlData) { ?>
            <tr id="md_<?php echo $mdlData['id'] ?>">

                <td><?php echo $mdlData['make_name'] ?></td>
                <td><?php echo $mdlData['year_name'] ?></td>
                <td><?php echo $mdlData['name'] ?></td>
                <td>
                    <?php echo $mdlData['isactive'] == '0' ? 'Active' : 'In - Active' ?>
                </td>
                <td>
                    <button class="btn btn-round btn-xs btn-default" data-toggle="modal" data-target=".id_md_edit_make_<?php echo $mdlData['id'] ?>"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-round btn-xs btn-danger" data-toggle="modal" onclick="deleteModel(<?php echo $mdlData['id'] ?>)"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php } ?>

    </tbody>
</table>
<div class="pull-right">
    <?php echo $this->ajax_pagination_product->create_links(); ?>
</div>
<?php $this->load->view('modal/_modal_edit_model');?>