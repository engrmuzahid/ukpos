<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
   
      $(document).ready(function () {

		new JsDatePick({
			useMode:2,
			target:"confirm_date",
			dateFormat:"%Y-%m-%d"
		}); 
	});
</script>
<div>
        <input value="<?php echo $model['id']; ?>" name="id" type="hidden" >
        <h3> Change Cheque date  </h3>
        <br/><br/>
        <input value="<?php echo date('Y-m-d', strtotime($model['confirm_date'])); ?>" name="confirm_date" id="confirm_date" type="text" style="width: 300px; height:40px; font-size:20px;padding-left: 10px;" >
        <br/> <br/>
        <textarea  placeholder="Notes" name="notes" id="notes"   style="font-family: verdana;width: 90%; height:140px; font-size:20px;padding: 10px;" ><?php echo $model['notes']; ?>
        </textarea> 
        <br/> <br/>
        <select name="is_confirm" style="width: 300px; height:40px; font-size:20px;padding-left: 10px;">
            <option <?php echo $model['is_confirm'] == "0" ? "selected" : ""; ?> style="padding-left: 10px;" value="0">Returned</option>
            <option  <?php echo $model['is_confirm'] == "1" ? "selected" : ""; ?> style="padding-left: 10px;"  value="1">Paid</option>
        </select>
        <br/> <br/>
        <hr/>
        <input type="submit" class="buttonGreen" id="submit_button" style="width: 200px; height:45px; font-size:25px;margin: 2%;float:right;background: #255F99;" id="apply_discount"  value=" APPLY "   />    

   

</div>