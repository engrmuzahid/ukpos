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
        //Only init if there is more than one row
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
            <td id="title"><?php echo CHtml::link('Van', array('add')) ?></td>
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <div id="new_button">
                    <a href="<?php echo Yii::app()->request->baseUrl . '/car'; ?>" class="none new">Van</a>
                    
                </div>
            </td>
            <td style="width: 10px;"></td>        
            <td id="item_table">
                <div id="table_holder">

                    <table class="tablesorter" id="sortable_table" style="width:100%;">
                        <?php if (count($models)): ?>
                            <thead>
                                <tr>
                                    <th>SL No.</th> 
                                    <th>Title</th> 
                                    <th>Reg. No.</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $inc= 1; foreach ($models as $model): ?>
                                    <tr>
                                          
                                        <td><?php echo $inc++; ?></td>
                                        <td><?php echo ucwords($model->title); ?></td>
                                        <td><?php echo $model->reg_no; ?></td> 
                                        <td width="15%" style="margin-left:10px;">
                                            <a href="<?php echo Yii::app()->request->baseUrl . '/car/edit/' . $model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a> |
                                            <a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl . '/car/delete/' . $model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="pagination"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></div>
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
