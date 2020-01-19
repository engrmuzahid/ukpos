    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable3").jqprint();
            });
        });
    
    </script>
<table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">B2B Item List</td>
	</tr>
  </tbody>
</table>
<table id="contents">
	<tbody><tr>
		<td  colspan="3">

        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3" align="center">
               <p align="right" style="margin-right:100px;"><?php if(!empty($invoices)): echo "Total Invoices: ".$invoices; endif; ?></p>
			  <table  border="1" style="width:80%; border-collapse:collapse;">
				<tr>
                    <th width="60%" scope="col">Product Name</th>
                    <th width="15%" scope="col">Quantity</th>
                    <th width="25%" scope="col">Comment</th>
				</tr>
                <?php
				  for($i = 0; $i< sizeof($product_name); $i++):
                  $product_name2  = $product_name[$i];				  
                  $quantity2      = $quantity[$i];
                  $comment2       = $comment[$i]; 
                  
                 ?>
				<tr>
                    <td align="justify">&nbsp;<?php echo $product_name2; ?>
					</td>
                    <td align="center">
					 <?php echo $quantity2;  ?>
					</td>
					<td align="center"> <?php echo $comment2; ?></td>
				</tr>
             <?php  endfor; ?>
             	<tr>
                    <td align="right"><strong>Total Quantity:</strong>&nbsp;</td>
                    <td align="center"><?php echo $q_total;  ?> 
					</td>
					<td align="center">&nbsp;</td>
				</tr>
            </table>
               </div>     
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
