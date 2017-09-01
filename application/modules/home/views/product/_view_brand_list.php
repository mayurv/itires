<?php
$i = 1;
if (isset($brands_dtails)) {
    ?>
    <ul class="list-inline list-unstyled">
        <?php foreach ($brands_dtails as $bData) { ?>
            <li ><a  href="<?php echo base_url(); ?>home/search_by_brand/<?php echo $bData['attribute_id'] . '/' . $bData['id'] ?>">
                    <?php if ($bData['sub_value'] != '') { ?>
                        <img style="width:140px; height: 50px"src="<?php echo base_url() . $bData['sub_value']; ?>" class="img-thumbnail"/>
                    <?php } else { ?>
                        <?php echo $bData['sub_name']; ?>
                    <?php } ?>
                </a></li>

            <?php
            $i++;
        }
        ?>
    </ul>
<?php } ?>
