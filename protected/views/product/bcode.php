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
		<td id="title">Product Barcode Print</td>
	</tr>
  </tbody>
</table>
<table id="contents">
	<tbody><tr>
		<td  colspan="3">
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3">
            <table>
            <?php
            if(count($models)):
              
              foreach($models as $productValue):
              $product_code = $productValue->product_code;
              $product_name = $productValue->product_name;
              $sell_p       = $productValue->sell_price; 
			  $vat_pp       = $productValue->vat;
			  $vat = ($sell_p * $vat_pp) / 100;
              $sell_price = $sell_p + $vat; 
			 
              endforeach;
              $sh = "&pound; ";
			  
             ?>
               <tr>
                <td width="252" align="center">
               <font style="font-size:11px;"> <?php echo '<b>'.$product_name.'</b>'; ?></font><br />
               <font style="font-size:11px;"> <?php echo '<b> Price: '.$sh.number_format($sell_price, 2).'</b>'; ?></font><br />
                <img src="<?php echo Yii::app()->request->baseUrl.'/public/' ;?>barcode.php?barcode=<?php echo $productValue->product_code; ?>&width=315&height=55"> 
                </td>
               </tr>
                
            <?php else:?>
                <tr>
                <td width="95%" class="red-left"><div id="message-red">No Item Available ..</div></td>
                </tr>
            <?php endif; ?>
            </table>
             
               </div>     

		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
