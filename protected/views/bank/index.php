<script type="text/javascript">
    $(document).ready(function ()
    {
        init_table_sorting();
        enable_select_all();
        enable_checkboxes();
        enable_row_selection();
    });

    function init_table_sorting()
    {
        if ($('.tablesorter tbody tr').length > 1)
        {
            $("#sortable_table").tablesorter(
                    {
                        sortList: [[1, 0]],
                        headers:
                                {
                                    0: {sorter: false},
                                    3: {sorter: false}
                                }
                    });
        }
    }
</script>

<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title"><?php echo "Bank Info"; ?></td>
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('_menu') ?>
            </td>
            <td style="width: 10px;"></td>        
            <td id="item_table">
                <div id="table_holder">

                    <table class="tablesorter" id="sortable_table" style="width:100%">
                        <?php if (count($models)): ?>
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">SL</th>
                                    <th width="40%" scope="col">Bank Name</th>
                                    <th width="40%" scope="col">Amount</th> 
                                    <th width="15%" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($models as $model):
                                    ?>
                                    <tr <?php if ($i % 2 == 0): ?> class="alternate-row" <?php endif; ?>>
                                        <td><?= $i; ?></td>
                                        <td><?php echo $model->bank_name; ?></td>
                                        <td><?php echo $model->description ? $model->description : "N/A"; ?></td>

                                        <td width="14%" style="margin-left:5px;">
                                            <a href="<?php echo Yii::app()->request->baseUrl . '/bank/showdetails/' . $model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/displaysIcon.png'; ?>" alt="Show" title="Show" border="0" /></a> 
                                        </td>
                                    </tr>
                                    <?php
                                    $i = $i + 1;
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div> 
            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
<script language="javascript">
    function confirmSubmit() {
        var agree = confirm("Are you sure to delete this record?");
        if (agree)
            return true;
        else
            return false;
    }
</script>