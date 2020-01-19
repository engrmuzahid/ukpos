<?php
include 'db.php';

if(isset($_POST['Product'])) {
    
    $cnt_product = 0;
    foreach($_POST['Product'] as $product_data) {
        $columns = implode("`, `", array_keys($product_data));
        $values = implode("', '", $product_data);
        $sql = "INSERT INTO `product` (`$columns`) VALUES('$values')";        
        mysql_query($sql);        
        $cnt_product++;
    }
}
?>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    var product_sl = 0;
    var product_codes = new Array();
    function init_datepicker(id) {
        new JsDatePick({
                useMode:2,
                target:id,
                dateFormat:"%Y-%m-%d"
        });
    }
    
    function not_looked_up(code) {
        
        for(i=0; i<product_codes.length; i++) {
            if(product_codes[i] == code)
                return false;
        }
        
        return true;
    }
    $(document).ready(function(){
        $("#scan_product_code").focus();
        $("#scan_product_code").keyup(function(e){            
            if(e.keyCode == 13) {
                var product_code = $(this).val();   
                
                if(product_code != "" && not_looked_up(product_code)) {                    
                    $.post('get_product.php?product_sl='+product_sl+'&product_code='+product_code, {}, function(resp){
                        $("#frmAddDiv").append(resp);
                        init_datepicker("Product_expire_date_"+product_code);
                        $("#scan_product_code").val('');
                        product_codes[product_sl] = product_code;
                        product_sl++;
                    });
                } else {
                    $("#scan_product_code").val('');
                }
            }
        });
        
        $(".product_category").die('change').live('change', function(e){
            var pcode = $(this).attr('data-pcode');
            
            var category_id = $(this).val();
            $.post('get_subcategory.php?category_id='+category_id, {}, function(resp){
                $("#product_subcategory_"+pcode).html(resp);
            });
        });
        
        $("#frmSubmit").click(function(e){
                $("#search_product").fadeOut();
                $("#frmSubmit").attr('disabled', 'disabled');
                $("#frmAdd").submit();
        });
        
        $(window).scroll(function(e){
             $es = $('#search_product');
              if ($(this).scrollTop() > 50 && $es.css('position') != 'fixed'){
                    $('#search_product').css({'position': 'fixed', 'top': '0px'});
              }
              else{
                      if($(this).scrollTop() <= 50){
                          $('#search_product').css({'position': 'relative','top': ''});
                      }
              }
        });
    });
</script>


<div align="center" id="search_product" style="background: #E6E6E6; width: 100%;"><input type="text" id="scan_product_code" style="height: 30px; width: 200px" /></div>


<form id="frmAdd" method="post">
        <div id="errorAdd">
            <?php if(isset($cnt_product)) echo "$cnt_product Products Added!"; ?>
        </div>
        
    <table id="frmAddDiv" style="width: 100%;">
        <tr>
            <th style="width: 60px">Category</th>
            <th style="width: 60px">SubCategory</th>
            <th style="width: 60px">Brand</th>
            <th style="width: 150px">Code</th>
            <th style="width: 350px">Name</th>
            <th style="width: 60px">Unit</th>
            <th style="width: 60px">Buy</th>
            <th style="width: 60px">Sell</th>
            <th style="width: 100px">Expire</th>            
            <th style="width: 100px">Min</th>
        </tr>
    </table>
        
        <br/>
        <input type="button" id="frmSubmit" value=" SUBMIT " />
</form>
