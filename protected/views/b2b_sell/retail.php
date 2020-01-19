<style type="text/css">    
    body{
        font-family: tahoma;
    }

    #cart_section{
        width: 42%;
        float: left;                
    }

    #total_price{
        width: 100%;
        background: #CDD5FE;        
        font-size: 18px;                
        font-weight: bold;
    }

    #cart_header{
        background: #CDD5FE;
        font-weight: bold;
        font-size: 15px;
        width: 100%;
        min-height: 65px;
    }

    #search_box{
        width: 100%;        
        margin-top: 10px;        
    }

    input[type=text]{
        font-size: 16px;
        font-weight: bold;
        height: 25px;
        width: 99%;
    }

    #cart_table{
        width: 100%;
        height: 50%;        
    }

    #cart_items{

    }
    #item_table tr:hover{ 
        color: #029acf;
    }
    #item_listing{
        width: 57%;
        float: right;               
    }
    #product_list{
        width: 100%;
        height: 100%;
        float: left;        
        background: #FFFS;
    }
    #category_list{
        width: 14%;
        height: 100%;
        float: right;
        margin-left: 1px;
        background: #236daa;
    }

    .product_item{
        width: 20.5%;
        font-family: SegoeUI,"Helvetica Neue",Helvetica,Arial,sans-serif;
        height: 70px;
        float: left;
        margin-left: 5px;
        margin-top: 5px;
        padding: 10px;
        cursor: pointer;        
        overflow: hidden;
        font-size: 14px;
        text-align: center;
        color: #FFF;   
    }

    .product_list_view{
        width: 100% !important;
        height: 45px !important;
        float: left;
        margin-right: 0px !important;
        margin-top: 0px !important;
        cursor: pointer;        
        overflow: hidden;
        font-size: 14px;
        text-align: left !important;

        border-bottom: 1px solid #000;
        background: #FFF !important;  
    }
    .product_list_view:nth-child(odd){

        background-color: #ededed !important;   
    }
    .product_list_view:hover{

        background-color: #CDD5FE !important; 
    }
    .product_list_view span{
        padding: 10px;
        font-size: 18px;
        color: #000;
        line-height: 28px;
    }

    .product_item img{
        width: 100%;
        max-height: 70px;

        color: #FFF;   
    }



    #product_list .category_item{
        width: 22%;
        float: left;
        margin-left: 5px;

    }

    .category_item{

        height: 70px;                
        cursor: pointer;
        /*        border: 3px solid #000000;*/
        overflow: hidden;
        margin-top: 5px;
        font-family: SegoeUI,"Helvetica Neue",Helvetica,Arial,sans-serif;
        text-align: center;
        text-transform: uppercase;
        background-color: #029acf;
        color:#FFF;
        padding: 5px;

        font-size: 16px;
        vertical-align: middle;

        /*border-radius: 25px;*/

    }
    .category_item img{
        width: 99%;
        max-height: 70px;
        color:#FFF;
    }

    .buttonGreen{
        cursor: pointer;
    }

    table#register td input[type="text"]{
        border: 0px solid #BBB;
        font-size: 12px;
        width: 98%;
        font-weight: normal;
        background: none;
    }

    .cart_add{
        float: left;        
    }
    .cart_remove{
        float: right;
    }

    .scroller{
        overflow: auto;

    }

    .cart_item_no_product{
        background: #CC0000;
    }
    .cart_item_no_product input{
        background: #CC0000;
    }

    .cart_item_row{
        cursor: pointer;
    }

    .cart_item_row:nth-child(2n-1){
        background: #EDEDED !important;
    }

    .lastbuy{

        display: none;
        color: #c77405;
        font-size: 11px;
        font-style: italic;
    }

    #suspend_date{
        display: none; padding: 20px; position: fixed; top: 0; left: 40%; background: #e6e6e6;
    }

    .show_last_history {
        position: relative;
        display: inline-block; 
    }
    .show_last_history .tooltiptext table tr td {

        color: #fff !important;
        border: 0 !important;;  
    }

    .show_last_history .tooltiptext {
        visibility: hidden;
        width: 300px;
        background-color: black;
        color: #fff !important;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        margin-top:30px;
        margin-left: -130px;
        position: absolute;
        z-index: 1;
        border: 0;
    }
    .ac_results li {
        cursor: default;
        display: block;

        font-size: 18px;
        line-height: 28px;
        margin: 0;
        overflow: hidden;
        padding:5px;
    }

    #item_table tr:nth-child(odd){
        background: #BBB;
    } 
    #item_table tr:nth-child(even){
        background: #EDEDED;
    }
</style>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.jqprint.0.3.js"></script>
<script type="text/javascript">
    window.JSON || document.write('<script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.2.4/json3.min.js"><\/script>');
</script>

<script type="text/javascript">
    var json_categories = JSON.parse('<?php echo addslashes($categories) ?>');
    var json_products = JSON.parse('<?php echo addslashes($products) ?>');
    var json_stocks = JSON.parse('<?php echo addslashes($stocks) ?>');
    var json_customers = "";
    var json_temp_products = JSON.parse('<?php echo addslashes($temp_products) ?>');
    var base_url = '<?php echo Yii::app()->baseUrl ?>';
    var eu_enable = '<?php echo $user['eu'] ?>';
    var customer_enable = '0';

    var cart = {}, cart_key = 0, ccustomer = null;
    var invoice_products = {};

    var categories = {}, products = {}, customers = {}, temp_products = {}, stocks = {};

    $.each(json_categories, function (k, val) {
        categories[k] = val;
    });
    $.each(json_products, function (kp, val) {
        products[kp] = new Array();
        if (val) {
            $.each(val, function (j, value) {
                if (value)
                    products[kp][j] = value;
            });
        }
    });

    $.each(json_stocks, function (k, val) {
        stocks[val.product_code] = val;
    });
    $.each(json_customers, function (k, val) {
        customers[k] = val;
    });
    /**
     *  List the product items by given array of products
     */
    function list_products(_products) {

        $("#product_list").empty();
        var color_code = $("#color_code").val();
        if (_products) {
            $("#product_list").css("background", "#95a5a6");
            $.each(_products, function (k, product) {
                if (product) {
                    content = '<div class="product_item" style="background-color:' + color_code + '"  data-name="' + product.product_name + '" data-price="' + product.sell_price + '" data-id="' + product.product_code + '" id="product_item_' + product.product_code + '"><img  alt="' + product.product_name + '" src="' + base_url + '/images/products/' + product.image + '" /></div>';
                    $("#product_list").append(content);
                }
            });
        } else {
            content = 'No Items!';
            $("#product_list").append(content);
        }
    }

    /**
     *  List the product items by given array of products
     */
    function list_invoice(_products) {

        $("#product_list").empty();
        if (_products) {
            $("#product_list").append('<div><input type="button" value="Clr Inv Price" id="clearInvoicePrice" class="buttonGreen"></div>');
            $.each(_products, function (k, product) {
                if (product) {
                    content = '<div class="product_item" data-name="' + product.product_name + '" data-price="' + product.sell_price + '" data-id="' + product.product_code + '" id="product_item_' + product.product_code + '"><img  alt="' + product.product_name + '" src="' + base_url + '/images/products/' + product.image + '" /><br>&pound;' + parseFloat(product.sell_price).toFixed(2) + '</div>';
                    $("#product_list").append(content);
                }
            });
        } else {
            content = 'No Items!';
            $("#product_list").append(content);
        }
    }



    function setCookie(cname, cvalue, exdays)
    {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname)
    {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++)
        {
            var c = ca[i].trim();
            if (c.indexOf(name) == 0)
                return c.substring(name.length, c.length);
        }
        return "";
    }

    /**
     *  make array of products by category id 
     *  if 0 given then make an array of all products 
     *  and call list_products to display them     
     */
    function show_products(category_id) {
        var product, content, i, j, k;
        var _products = Array();
        if (category_id > 0) {
            _products = products[category_id];
        } else {
            i = 0;
            $.each(products, function (k, items) {
                if (items) {
                    $.each(items, function (j, product) {
                        _products[i++] = product;
                    });
                }

            });
        }

        list_products(_products);
    }

    /**
     * Make html content for all categories  
     */
    function show_categories() {
        var content;
        $("#category_list").empty();
        $("#product_list").empty();
        $("#product_list").css("background", "rgb(149, 165, 166)");
        $.each(categories, function (k, category) {
            if (category.parent_id == 0) {
                content = '<div class="category_item" style="background-color:' + category.color_code + '" data-color="' + category.color_code + '"   data-id="' + category.id + '"  data-parent="' + category.parent_id + '" id="category_item_' + category.id + '" data-name="' + category.category_name + '">' + ((category.image != "") ? '<a style="text-decoration: none; color: black;"><img  alt="' + category.category_name + '" src="' + base_url + '/images/categories/' + category.image + '"   /><div>' + category.photo_caption + '</div></a>' : '<p style="text-transform:upper">' + category.category_name + '<p>') + '</div>';
                $("#category_list").append(content);
                $("#product_list").append(content);
            }
        });
    }

    /**
     * Get product information from the original product object
     * by given product code 
     */
    function get_product(pcode) {
        var product, flag;
        $.each(products, function (k, items) {
            if (items) {
                $.each(items, function (j, _product) {
                    if (pcode == _product.product_code) {
                        product = _product;
                        flag = true;
                        return false;
                    }
                });
            }
            if (flag == true)
                return false;
        });
        return product;
    }

    /**
     * Get the cart index by the given product code
     */
    function get_cart_key(pcode) {
        var key = null;
        $.each(cart, function (k, val) {
            if (val.product_code == pcode) {
                key = k;
                return false;
            }
        });
        return key;
    }

    /**
     * Show items in the cart as html
     */


    function show_cart_items() {
        var product, content = '', price, total_price = 0.00, vat_total = 0.00, total_item = 0, item_count = 0, b_price = 0, extraQuantity = 0, totalOfferPrice = 0, escapePrice = 0;
        var cnt_key = 0, kk = 0;
        var arr_content = new Array();
        $.each(cart, function (k, val) {
            if (val) {
                var customer_type = $('#customer_typeEE').html();

                product = get_product(val.product_code);
                if (product) {
                    var stock_amt = stocks[product.product_code] ? stocks[product.product_code].product_balance : 0;
                    var pname = val.product_name != "" ? val.product_name : product.product_name;

                    if (parseFloat(val.product_price) > 0) {
                        var pprice = parseFloat(val.product_price);
                    } else {
                        var pprice = parseFloat(product.sell_price);

                    }

                    cart[k].product_price = pprice;
                    var lastbuy = product.purchase_date;
                    price = (pprice * parseFloat(val.quantity)).toFixed(2);

                    //........Offer Calculation......///////
                    if (val.quantity >= product.offer_quantity && product.offer_quantity > 0) {
                        extraQuantity = (val.quantity % product.offer_quantity);
                        totalOfferPrice = parseFloat((parseFloat(val.quantity - extraQuantity) / product.offer_quantity) * product.offerPrice);
                        escapePrice = parseFloat(extraQuantity * pprice);
                        price = parseFloat(totalOfferPrice + escapePrice).toFixed(2);
                    }
                    //........Offer Calculation......///////

                    total_price = parseFloat(total_price) + parseFloat(price);
                    total_item += parseFloat(val.quantity);
                    item_count++;
                    b_price = parseFloat(b_price) + (parseFloat(product.purchase_cost) * parseFloat(val.quantity));
                    
                        var profit_ = ((pprice - (parseFloat(product.purchase_cost) + parseFloat(product.vat_on_purchase)))).toFixed(2);
                        var profitVat = profit_ - (profit_ / (1 +  (parseFloat(product.vat) / 100)));
                        cart[k].vat_on_profit = profitVat;
                        vat_total = parseFloat(vat_total) + (parseFloat(profitVat) + parseFloat(product.vat_on_purchase)) * parseFloat(val.quantity);
                   
                    var _style = '';
                    var $min_stock = '';
                    if (stock_amt < product.min_stock) {
                        $min_stock = 'style="background:pink"';
                    }
                    content = '<tr class="cart_item_row" id="cart_item_row_' + product.product_code + '" ' + $min_stock + '>';
                    content += '<td><input data-id="' + product.product_code + '" type="text" size="1" class="cart_qty" value="' + val.quantity + '"></td><td><input data-id="' + product.product_code + '" class="product_name" style="width:98%;' + _style + '" type="text" value="' + pname + '"><div class="lastbuy">' + lastbuy + '</div></td><td>' + (parseFloat(stock_amt)).toFixed(0) + '</td>';
                    content += (eu_enable == '1') ? '<td style="color:#DDD;font-weight: normal;" data-id="' + product.product_code + '"  class="show_last_history"><span class="tooltiptext" id="tooltiptext_' + product.product_code + '">Loading...</span>' + parseFloat(parseFloat(product.purchase_cost) + parseFloat(product.vat_on_purchase)).toFixed(2) + '</td>' : '';
                    content += '<td><input  style="' + _style + '" type="text" class="product_price" size="1" data-id="' + product.product_code + '" value="' + parseFloat(pprice).toFixed(2) + '"></td>';
                    content += '<td>' + price + '</td>';
                    content += '<td><a href="javascript:void(0)" class="cart_add" data-id="' + val.product_code + '"><img src="' + base_url + '/public/images/icon_add.png"></a> <a href="javascript:void(0)" class="cart_remove" data-id="' + val.product_code + '"><img src="' + base_url + '/public/images/delete.png"></a></td></tr>';
                    arr_content[cnt_key++] = content;
                } else { //no product
                    var pprice = parseFloat(val.product_price) > 0 ? parseFloat(val.product_price) : 0;
                    price = (pprice * parseFloat(val.quantity)).toFixed(2);
                    total_price = parseFloat(total_price) + parseFloat(price);
                    total_item += parseFloat(val.quantity);
                    content = '<tr class="cart_item_no_product cart_item_row" style="background:red" id="cart_item_row_' + val.product_code + '">';
                    content += '<td><input data-id="' + val.product_code + '" type="text" size="1" class="cart_qty" value="' + val.quantity + '"></td><td><input data-id="' + val.product_code + '" class="product_name" style="width:98%;' + _style + '" type="text" value="' + val.product_code + '"></td><td></td><td style="color:silver"></td><td><input  readonly style="' + _style + '" type="text" class="product_price" size="1" data-id="' + val.product_code + '" value="' + pprice + '"></td>';
                    content += '<td>' + price + '</td>';
                    content += '<td><a href="javascript:void(0)" class="cart_add" data-id="' + val.product_code + '"><img src="' + base_url + '/public/images/icon_add.png"></a> <a href="javascript:void(0)" class="cart_remove" data-id="' + val.product_code + '"><img src="' + base_url + '/public/images/delete.png"></a></td></tr>';
                    arr_content[cnt_key++] = content;
                    item_count++;
                }
            }
        });
        content = '';
        for (var i = cnt_key - 1; i >= 0; i--) {
            content += arr_content[i];
        }
        total_price = total_price.toFixed(2);
        $("#total_cost").val(total_price);
        $("#vat_total").val(vat_total.toFixed(2));
        $("#buy_price").html((total_price - b_price).toFixed(2) + "(" + (((total_price - b_price) / total_price) * 100).toFixed(2) + ")");
        calculate_amount();
        setCookie('pos_cart', JSON.stringify(cart), 1);
        $("#cart_items").html(content);
        $("#item_info").html('Line: ' + item_count + ' | Qty: ' + total_item.toFixed(2));
    }


    /**
     * Add or remove items to/from the cart 
     */
    function cart_action(action, pcode, info) {


        var key = get_cart_key(pcode);
        if (cart[key]) {
            if (action == 'add')
                cart[key].quantity++;
            else {
                cart[key].quantity > 1 ? cart[key].quantity-- : delete cart[key];
            }
        } else {
            if (action == 'add') {
                cart[cart_key++] = {
                    'product_code': pcode,
                    'quantity': info ? (info.quantity ? info.quantity : 1) : 1,
                    'product_name': info ? info.product_name : "",
                    'product_price': info ? parseFloat(info.p_price) : ""
                };
            }
        }

        show_cart_items();

        if (action == 'add') {
            if (!$("#cart_item_row_" + pcode).hasClass('cart_item_no_product')) {
                $("#cart_item_row_" + pcode).css('background', "#fca830").css('font-weight', 'bold');
                $("#cart_item_row_" + pcode + "  input").css('background', "#fca830").css('font-weight', 'bold');
            }
        }

    }

    /**
     * Calculation of the price, payment, discount % etc
     */
    function calculate_amount() {
        var discount = $("#discount").val() != "" ? parseFloat($("#discount").val()) : 0;
        var discount_type = $("#discount_type").val();
        var amount = $("#total_cost").val() ? parseFloat($("#total_cost").val()) : 0;
        var new_amount = amount;
        var discount_amount = 0;
        if (discount_type == "flat") {
            if (discount > 0 && amount > 0) {
                discount_amount = discount.toFixed(2);
                new_amount = amount - discount_amount;
            }
        } else {
            if (discount > 0 && amount > 0) {
                discount_amount = (amount * (discount / 100)).toFixed(2);
                new_amount = amount - discount_amount;
            }
        }

        $("#discount_value").val(parseFloat(discount_amount));
        var vat_total = $("#vat_total").val();
        if (amount > 0) {
            $("#suspend_order").removeClass('suspended_list').val('Suspend');
        } else {
            $("#suspend_order").addClass('suspended_list').val('Suspended List');
        }

        $("#total_sell_price").html(new_amount.toFixed(2));
        $("#final_cost").val(new_amount.toFixed(2));
        var cash = $("#cash_payment").val() != "" ? parseFloat($("#cash_payment").val()) : 0;
        var card = $("#card_payment").val() != "" ? parseFloat($("#card_payment").val()) : 0;

        var check = $("#check_payment").val() != "" ? parseFloat($("#check_payment").val()) : 0;
        var payment = cash + card + check;


        $("#paid_amount").val(parseFloat(payment).toFixed(2));
        $("#due_amount").html((parseFloat(new_amount) - parseFloat(payment)).toFixed(2));
        $("#discount_amount").html(parseFloat(discount_amount));

        $("#vat_amount").html(vat_total);
    }

    function clear_order() {
        cart = {};
        cart_key = 0;
        $(".payment").val('');
        $("input[type=hidden]").val('');
        $("#discount").val('');
        $("#discount_value").val('');
        $("#discount_amount").html('');
        $("#discountBtn").val(" Discount ");
        $("#cart_items").html('');
        $("#buy_price").html('');
        $("#item_info").html('Line: 0 | Qty: 0');
        $("#product_list").empty();
        $("#parent_category_list").html('<a class="show_root_category"   style="cursor: pointer;padding:10px;background:#FB9D23;min-width:120px;"> HOME </a><b> > </b>');
        $("#customer_id").val("0");
        $("#customer").html("");
        $("#comment").val("");
        $("#customer_order").val("Customer");
        calculate_amount();
        setCookie('pos_cart', "", 1);
    }

    function check_input() {
        if ($("#customer_id").val() == 0) {
            if (customer_enable != '1') {
                if ($("#paid_amount").val() == 0) {
                    alert("No payment done!");
                    return false;
                }
                if (parseFloat($("#final_cost").val()) > parseFloat($("#paid_amount").val())) {
                    alert("Payment due yet!");
                    return false;
                }
            } else {
                alert("No customer selected!");
                return false;
            }
        }
        if ($("#total_cost").val() == 0) {
            alert("No item in cart");
            return false;
        }

        return true;
    }



    function show_child_categories(id) {
        var content;
        $("#product_list").empty();
        $.each(categories, function (k, category) {
            if (category.parent_id == id) {
                content = '<div class="category_item" style="cursor: pointer;float: left;font-size: 16px;height: 70px;margin-right: 10px;margin-top: 10px;overflow: hidden;' +
                        'text-align: center;width: 100px;" data-id="' + category.id + '"  data-parent="' + category.parent_id + '" id="category_item_' + category.id + '" data-name="' + category.category_name + '">' + category.category_name + '</div>';
                $("#product_list").append(content);
            }
        });
    }

    function show_parent_categories(id) {
        var cat_content = {};
        $("#parent_category_list").empty();
        $.each(categories, function (k, category) {
            if (category.id == id) {
                cat_content[k] = '<a class="category_item" data-id="' + category.id + '" data-parent="' + category.parent_id + '" id="category_item_' + category.id + '" data-name="' + category.category_name + '" style="cursor: pointer;padding:10px;background:#FB9D23;min-width:120px;">' + category.category_name + '</a><b> > </b>';
                if (category.parent_id > 0) {
                    show_parent_categories(category.parent_id);
                }
            }
        });
        $.each(cat_content, function (k, cate) {
            $("#parent_category_list").append(cate);
        });
    }
    function has_child_category(cat_id) {
        var return_value = false;
        $.each(categories, function (k, category) {
            if (category.parent_id == cat_id) {
                return_value = true;
                return false;
            }
        });
        return return_value;
    }
    // Actions after loading the content
    $(document).ready(function () {

        $("body, #cart_section, #item_listing").css('height', $(window).height() - 60);
        show_categories();
        $("#search_product").focus();
        var pos_cart = "";
<?php if (!@$old_order) : ?>
            pos_cart = getCookie("pos_cart");
<?php else : ?>
            setCookie('pos_cart', "", 1);
<?php endif; ?>

        if (pos_cart != "") {
            cart = JSON.parse(pos_cart);
            //get the cart keys as array
            var cart_keys = Object.keys(cart);
            //get the last key of the keys array
            cart_key = cart_keys[cart_keys.length - 1];
            //now increase the key to add next item
            if (isNaN(cart_key)) {
                pos_cart[0] = pos_cart[cart_key];
                cart_key = 0;
            }
            cart_key++;
            show_cart_items();
        } else {
            $.each(json_temp_products, function (k, val) {
                cart_action('add', val.product_code, val);
            });
        }

<?php if ($customer_id): ?>
            ccustomer = <?php echo $customer_id ?>;

            $("#customer_order").val('<?php echo $old_customer["customer_name"] ?>');
            $("#customer_id").val(ccustomer);
            $("#customer").html("Loading...");
            $.magnificPopup.close();
            setCookie('pos_customer', ccustomer);
            var url = base_url + '/public/get_jquery.php?customer_id=' + ccustomer;
            $.post(url, {}, function (resp) {

                var result = resp.split("_@_");
                $("#customer").html(result[0]);
                $("#comment").val(result[1]);
                $("#customer_typeEE").html(result[2]);

                $("#customer_due_amount").val(result[3]);
                $("#credit_limit").val(result[4]);
                $("#customer").append('&nbsp;<input type="button" class="buttonGreen" id="customer_invoice" value="Inv." />');
                $("#product_list").empty();
            });

            setCookie('pos_customer', ccustomer);
<?php endif; ?>

        var pos_cart_customer = getCookie("pos_customer");
        calculate_amount();

        $(".show_root_category").live('click', function (e) {
            show_categories();
            $("#parent_category_list").html('<a class="show_root_category"   style="cursor: pointer;padding:10px;background:#FB9D23;min-width:120px;"> HOME </a><b> > </b>');

        });


        $(".category_item").live('click', function (e) {
            var cat_id = $(this).attr('data-id');
            var cat_name = $(this).attr('data-name');
            var cat_parent = $(this).attr('data-parent');
            var color_code = $(this).attr('data-color');
            $("#color_code").val(color_code);
            var cat_content = '<a class="category_item" data-color="' + color_code + '"  style="background-color:' + color_code + '"  data-id="' + cat_id + '" data-parent="' + cat_parent + '" id="category_item_' + cat_id + '" data-name="' + cat_name + '" style="cursor: pointer;padding:10px;background:#FB9D23;min-width:120px;">' + cat_name + '</a><b> > </b>';
            if (cat_parent > 0) {
                show_parent_categories(cat_id);
            } else {
                $("#parent_category_list").html('<a class="show_root_category"   style="cursor: pointer;padding:10px;background:#FB9D23;min-width:120px;"> HOME </a><b> > </b>' + cat_content);
            }

            if (has_child_category(cat_id)) {
                show_child_categories(cat_id);
            } else {
                show_products(cat_id);
            }
        });

        $("#search_product").keyup(function (e) {
            if (e.keyCode == 13) {
                var pcode = $(this).val().trim().toUpperCase();
                if (pcode != "") {
                    var productCode = pcode.substring(0, 2);
                    if (productCode == "01") {
                        // 012150043200172
                        var _productPrice = pcode.substring(10, 13) + "." + pcode.substring(13, 15);
                        var productPrice = parseFloat(_productPrice).toFixed(2);
                        var newProduct = get_product(pcode.substring(2, 5));
                        var p_info = {'product_code': pcode.substring(2, 5), 'p_price': productPrice, 'product_name': newProduct.product_name};
                        cart_action('add', pcode.substring(2, 5), p_info);
                        $(this).val('');
                    } else {
                        cart_action('add', pcode);
                        $(this).val('');

                    }
                }
            }
        });


        $("#search_product").autocomplete(base_url + '/public/product_list.php?customer_id=' + $("#customer_id").val(), {//we have set data with source here
            formatItem: function (rowdata) { //This function is called right before the item is displayed on the dropdown, so we splitted and returned what we show in the selection box
                var info = rowdata[0].split(":");
                return info[1];
            },
            formatResult: function (rowdata) { // This function is called when any item selected, here also we returned that what we wanted to show our product_name field.
                var info = rowdata[0].split(":");
                return info[1];
            },
            width: $("#search_product").width(),
            multiple: false,
            matchContains: true,
            scroll: true,
            scrollHeight: 120
        }).result(function (event, data, formatted) { //Here we do our most important task :)
            if (!data) { //If no data selected set the product_id field value as 0
                $("#product_code").val('0');
            } else { // Set the value for the product id
                var info = formatted.split(":");
                $("#product_code").val(info[0]);
                cart_action('add', info[0]);
                $("#search_product").val('');
            }
        });
        $(".product_item").live('click', function (e) {
            var pcode = $(this).attr('data-id');
            $("#product_code").val(pcode);
            var _info = {'product_code': pcode, 'p_price': $(this).attr('data-price'), 'product_name': $(this).attr('data-name')};
            cart_action('add', pcode, _info);
        });
        $(".cart_add").live('click', function (e) {
            var pcode = $(this).attr('data-id');
            $("#product_code").val(pcode);
            cart_action('add', pcode);
        });
        $(".cart_remove").live('click', function (e) {
            var pcode = $(this).attr('data-id');
            $("#product_code").val(pcode);
            cart_action('remove', pcode);
        });


        $("#customer_id").change(function (e) {
            ccustomer = $(this).val();
            setCookie('pos_customer', ccustomer);
            var url = base_url + '/public/get_jquery.php?customer_id=' + $(this).val();
            $.post(url, {}, function (resp) {
                var result = resp.split("_@_");
                $("#customer").html(result[0]);
                $("#comment").val(result[1]);

                $("#customer_due_amount").val(result[3]);
                $("#credit_limit").val(result[4]);
                $("#customer").append('&nbsp;<input type="button" class="buttonGreen" id="customer_invoice" value="Inv." />');
                $("#product_list").empty();
            });
        });

        $("#discount, .payment").blur(function (e) {
            //if($(this).val() == '') $(this).val('0');
            calculate_amount();
        });

        $(".product_name").live('blur', function (e) {
            var pcode = $(this).attr('data-id');
            var _product = get_product(pcode);
            if ($(this).val() != _product.product_name) {
                var _key = get_cart_key(pcode);
                cart[_key].product_name = $(this).val();
            }
        });

        $(".product_price").live('blur', function (e) {
            var pcode = $(this).attr('data-id');
            var _key = get_cart_key(pcode);
            cart[_key].product_price = parseFloat($(this).val().trim());
            show_cart_items();
        });

        $(".cart_qty").live('blur', function (e) {
            var pcode = $(this).attr('data-id');

            var _key = get_cart_key(pcode);
            cart[_key].quantity = parseFloat($(this).val().trim());
            show_cart_items();
        });

        $(".show_last_history").live('mouseenter', function (e) {
            var pcode = $(this).attr('data-id');

            $('#tooltiptext_' + pcode).css('visibility', 'visible');
            var url = '<?php echo Yii::app()->request->baseUrl . '/b2b_sell/show_last_history'; ?>';
            $.post(url, {'pcode': pcode}, function (resp) {
                $('#tooltiptext_' + pcode).html(resp);
            });
        });

        $(".show_last_history").live('mouseleave', function (e) {
            var pcode = $(this).attr('data-id');
            $('#tooltiptext_' + pcode).css('visibility', 'hidden');
        });

//        $(".cart_item_row").live({
//            mouseenter: function () {
//                $(this).find('.lastbuy').show();
//            },
//            mouseleave: function () {
//                $(this).find('.lastbuy').hide();
//            }
//        });
//        
        $("#suspend_order").click(function (e) {
            e.preventDefault();
            var url = base_url + '/b2b_sell/ajax_suspend_order';
        });

        $("#customer_invoice").live('click', function (e) {
            e.preventDefault();
            var url = base_url + '/customer_invoice/getProducts';
            $.post(url, {'customer_id': $("#customer_id").val()}, function (resp) {

                var response = JSON.parse(resp.replace("Array", ""));
                k = 0;
                $.each(response, function (k, val) {
                    var _product = get_product(val.product_code);
                    if (_product) {
                        _product.old_sell_price = _product.sell_price;
                        _product.sell_price = val.p_price;
                        if (val.product_name != "")
                            _product.product_name = val.product_name;
                        if (_product)
                            invoice_products[k++] = _product;
                    }
                });
                list_invoice(invoice_products);
            });
        });

        $("#clearInvoicePrice").live('click', function (e) {

            $.each(invoice_products, function (k, val) {
                var _product = get_product(val.product_code);
                if (_product) {
                    _product.sell_price = _product.old_sell_price;
                    invoice_products[k++] = _product;
                }
            });
            list_invoice(invoice_products);
            $("#clearInvoicePrice").remove();
        });

        $("#print_order").click(function (e) {
            e.preventDefault();
            var nproduct = $(".cart_item_no_product").length;
            if (nproduct) {
                alert(nproduct + ' Item(s) not found, Please check !');
                return false;
            }

            if ($("#customer_id").val() != 0) {
                var amount = $("#total_cost").val() ? parseFloat($("#total_cost").val()) : 0;
                var total_due = $("#customer_due_amount").val() != "" ? parseFloat($("#customer_due_amount").val()) : 0;
                var credit_limit = $("#credit_limit").val() != "" ? parseFloat($("#credit_limit").val()) : 0;

                if ((amount + total_due) > credit_limit) {
                    var promp = prompt("Credit limit exceeded.Enter approval code", "");
                    if (promp != null && promp != "4422") {
                        alert("Please enter correct code");
                        return false;
                    }
                }
            }
            var url = base_url + '/b2b_sell/addOrder?b2b=<?php echo $user['printer_name']; ?>';
            $("#cart_info").val(JSON.stringify(cart));
            if (check_input()) {
                url = base_url + '/b2b_sell/addOrderWithoutCustomer';

                setCookie('pos_cart_sell', "", 1);
                $("#frm_order").submit();
                clear_order();
//                var data = $("#frm_order").serialize();
//                $.post(url, data, function (resp) {
//                    $('#print_partOfb2b').html(resp);
//                    $("#print_partOfb2b").jqprint();
//                    $("#print_partOfb2b").empty();
//                    clear_order();
//                });
            }

        });

        $("#btn_confirm_suspend").die().click(function () {

            if ($("#customer_id").val() != 0) {
                var url = base_url + '/b2b_sell/suspendOrder';
                $("#cart_info").val(JSON.stringify(cart));
                var data = $("#frm_order").serialize();
                $.post(url, data, function (resp) {
                    if(resp == "DONE") {
                        alert("Sell Suspended Successfully....");

                        clear_order();
                    }
                    else{
                        alert("Sell does not Suspended | Please try again");
                    }

                });
                $("#suspend_date").fadeOut();
            } else {
                alert("Please select a customer.");
            }
        });

        $("#btn_cancel_suspend").click(function (e) {
            $("#suspend_date").fadeOut();
        });

        $("#suspend_order").click(function (e) {
            e.preventDefault();
            if ($(this).hasClass('suspended_list')) {
                location = base_url + '/b2b_sell/suspended/';
            } else {
                $("#suspend_date").fadeIn();
            }
        });

        $("#save_order").click(function (e) {
            e.preventDefault();
            var url = base_url + '/b2b_sell/addTemporary';
            $("#cart_info").val(JSON.stringify(cart));
            var data = $("#frm_order").serialize();
            $.post(url, data, function (resp) {
                alert("Saved as temporary...");
            });
        });

        $("#cancel_order").click(function (e) {
            e.preventDefault();
            var r = confirm("Are you sure ! You want to cancel this order.");
                if (r == true) {
                    $("#customer").html("");
                            $("#comment").val("");
                            $("#customer_id").val("");
                            clear_order();
                            $.post(base_url + '/b2b_sell/sell_cancel', {'ajax_call': 1}, function (resp) {
                                $("#search_product").focus();
                            });
                }        
        });

        $("#customer_order").die('click').live('click', function (e) {
            e.preventDefault();
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: "#customer_popup"
                },
                callbacks: {
                    beforeOpen: function (e) {
                        this.st.mainClass = "mfp-rotateLeft";
                    }
                },
                midClick: true
            });
            // $("#search_customer_name").focus();
            setTimeout(function () {
                document.getElementById('search_customer_name').focus();
            }, 100);

        });

        $(".customer_radiobox").live('click', function () {
            ccustomer = $(this).attr("data-value");
            $("#customer_order").val($(this).attr("data-name"));
            $("#customer_id").val(ccustomer);
            $("#customer").html("Loading...");
            $.magnificPopup.close();
            setCookie('pos_customer', ccustomer);
            var url = base_url + '/public/get_jquery.php?customer_id=' + ccustomer;
            $.post(url, {}, function (resp) {
                var result = resp.split("_@_");
                $("#customer").html(result[0]);
                $("#comment").val(result[1]);
                $("#customer_typeEE").html(result[2]);
                $("#customer_due_amount").val(result[3]);
                $("#credit_limit").val(result[4]);
                $("#customer").append('&nbsp;<input type="button" class="buttonGreen" id="customer_invoice" value="Inv." />');
                $("#product_list").empty();
            });
        });

        $(".search_customer").keyup(function () {

            $("#customer_listing").html('<h2> Loading... </h2> ');
            var url = base_url + '/b2b_sell/search_customer/';
            var data = $("#search_frm").serialize();
            $.post(url, data, function (resp) {
                $("#customer_listing").html(resp);
            });
        });

        $("#discountBtn").die('click').live('click', function () {
            $("#percentage_text").val("");
            $("#flat_text").val("");
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: "#discount_popup"
                },
                callbacks: {
                    beforeOpen: function (e) {
                        this.st.mainClass = "mfp-rotateLeft";
                    }
                },
                midClick: true
            });
        });

        $(".apply_discount_btn").live('click', function () {
            var dis_type = $(this).attr('data-type');
            var dis_value = $(this).attr('data-value');
            $("#discount").val(dis_value);
            $("#discount_type").val(dis_type);
            calculate_amount();
            $.magnificPopup.close();

            $("#discountBtn").val($(this).val() + " Discount");

        });


        $("#apply_discount").live('click', function () {
            if ($("#percentage_text").val() > 0) {
                $("#discount").val($("#percentage_text").val());
                $("#discount_type").val("percentage");
                $("#discountBtn").val($("#percentage_text").val() + "% Discount");
            } else if ($("#flat_text").val() > 0) {
                $("#discount").val($("#flat_text").val());
                $("#discount_type").val("flat");
                $("#discountBtn").val("£" + $("#flat_text").val() + " Discount");
            } else {
                $("#discount_type").val("flat");
                $("#discount").val(0);
            }

            calculate_amount();
            $.magnificPopup.close();

        });

        $(".apply_pound_btn").live('click', function (e) {
            e.preventDefault();

            var cash_payment = $("#cash_payment").val();
            var pound_value = parseFloat($(this).attr("data-value"));
            var new_value = 0.0;
            new_value = (cash_payment == "" ? 0.0 : parseFloat(cash_payment)) + pound_value;
            $("#cash_payment").val(new_value);
            calculate_amount();
        });

    });
</script>

<div id="discount_popup" style="width: 600px;margin: 0 auto;background: #FFF;padding: 15px;min-height: 600px;" class="popup-basic admin-form mfp-with-anim mfp-hide" >

    <h3> PERCENTAGE </h3>
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="percentage" data-value="3" value=" 3% "   />  
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="percentage" data-value="5" value=" 5% "   />    
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="percentage" data-value="10"  value=" 10% "   />    
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="percentage" data-value="20"  value=" 20% "   />    
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="percentage" data-value="25"  value=" 25% "   />    
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="percentage" data-value="30"  value=" 30% "   />    
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="percentage" data-value="50"  value=" 50% "   />    
    <input type="text" id="percentage_text" class="buttonGreen" style="width: 80px; height:80px; font-size:25px;margin: 2%;padding: 10px;background: #EDEDED;color: #000;text-align: center;" data-type="percentage" data-value="50"  value=""   />    

    <h3> FLAT </h3>
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="flat" data-value="1"   value=" &pound;1 "   />    
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="flat" data-value="2"  value=" &pound;2 "   />    
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="flat" data-value="3"  value=" &pound;3 "   />    
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="flat" data-value="4"  value=" &pound;4 "   />    
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="flat" data-value="5"  value=" &pound;5 "   />    
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="flat" data-value="10"  value=" &pound;10 "   />    
    <input type="button" class="buttonGreen apply_discount_btn" style="width: 100px; height:100px; font-size:25px;margin: 2%" data-type="flat" data-value="20"  value=" &pound;20 "   />    
    <input type="text" id="flat_text"  class="buttonGreen" style="width: 80px; height:80px; font-size:25px;margin: 2%;padding: 10px;background: #EDEDED;color: #000;text-align: center;" data-type="percentage" data-value="50"  value=""   />    

    <hr/>
    <input type="button" class="buttonGreen" style="width: 200px; height:45px; font-size:25px;margin: 2%;float:right;background: #255F99;" id="apply_discount"  value=" APPLY "   />    

</div>

<input type="hidden" id="color_code" value=""/> 

<form method="post" id="frm_order" action="<?php echo Yii::app()->baseUrl ?>/b2b_sell/addOrderWithoutCustomer">
    <input type="hidden" id="product_code" /> 
    <input type="hidden" name="total_cost" id="total_cost" />
    <input type="hidden" name="final_cost" id="final_cost" />
    <input type="hidden" name="paid_amount" id="paid_amount" />
    <input type="hidden" name="cart_info" id="cart_info" />
    <input type="hidden" name="vat_total" id="vat_total" />
    <input type="hidden" name="customer_id" id="customer_id" />
    <input type="hidden" name="customer_due_amount" id="customer_due_amount" />
    <input type="hidden" name="credit_limit" id="credit_limit" />

    <input type="hidden" name="suspend_id" value="<?php echo $suspend_id ?>" />
    <input type="hidden" name="existing_invoice_no" value="<?php echo @$old_order ? $old_order->invoice_no : '' ?>" />
    <div class="scroller" id="cart_section">        
        <div id="total_price">
            <div style="float: left; width: 25%">
                <a href="<?php echo Yii::app()->baseUrl ?>/super"><img alt="" width="85%" style="margin-top: 25px;" src="<?php echo Yii::app()->baseUrl ?>/public/images/header_logo.png"></a>
            </div>
            <div style="float: left; margin-top: 10px; font-size: 30px; width: 40%; font-weight: bold; text-align: center">
                <div>&pound;<span id="total_sell_price">0.00</span></div>
                <div style="font-size: 18px; margin-top: 5px; clear: both">Due: &pound;<span id="due_amount">0.00</span></div>
                <div style="font-size: 13px; margin-top: 5px; clear: both;">Vat: &pound;<span id="vat_amount">0.00</span></div>
                <div style="font-size: 13px; margin-top: 5px; clear: both">Disc: &pound;<span id="discount_amount">0.00</span></div>                
            </div>
            <div style="float: right; width: 30%">
                <?php if ($user['is_suspend'] == '1'): ?>
                    <input type="button" class="buttonGreen" style="width: 100%"  value=" Suspend " id="suspend_order" />
                    <input type="button" class="buttonGreen" style="width: 100%; height:60px;margin-top: 5px; font-size:35px" value=" PRINT " id="print_order" />    <br/>
                    <input type="button" style="width: 100%; float: right;margin-top: 5px;" id="discountBtn" class="buttonGreen" value=" DISCOUNT " />  <br/>
                <?php else: ?>
                    <input type="hidden" class="buttonGreen" style="width: 100%"  value=" Suspend " id="suspend_order" />
                    <input type="button" style="width: 100%; float: right;margin-top: 5px;" id="discountBtn" class="buttonGreen" value=" DISCOUNT " />  <br/>
                    <input type="button" class="buttonGreen" style="width: 100%; height:80px;margin-top: 5px; font-size:35px" value=" PRINT " id="print_order" />    <br/>
                <?php endif; ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div style="width: 100%; margin: 10px 0"></div>            
        <div id="cart_header" style="padding: 5px 0">
            <table style="float: left; width: 30%; text-align: left">
                <tr>
                    <td>Cash: </td> <td><input class="payment" style="width:90%" type="text" name="cash_payment" id="cash_payment"  value="<?php echo @$old_order ? $old_order->cash_payment : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Card: </td><td><input class="payment" style="width:90%" type="text" name="credit_card_payment" id="card_payment" value="<?php echo @$old_order ? $old_order->credit_card_payment : '' ?>" />                        
                    </td>
                </tr>                
            </table>
            <table style="float: right; width: 70%;">
                <?php if ($user['payment_check'] == '1'): ?>
                    <tr>
                        <td style="float: right;">Cheq: </td> <td><input class="payment" style="width: 90%;float: right" type="text" name="cheque_payment" id="check_payment" value="<?php echo @$old_order ? $old_order->cheque_payment : '' ?>" /></td>
                    </tr> 
                    <tr> 
                        <td colspan="2">
                            <div  style="float: right;">
                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 36px; height:36px; font-size:15px;margin: 2px" data-value="1" value=" &pound;1 "   />    
                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 36px; height:36px; font-size:15px;margin: 2px" data-value="2" value=" &pound;2 "   />      
                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 36px; height:36px; font-size:15px;margin: 2px" data-value="5" value=" &pound;5 "   />    
                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 36px; height:36px; font-size:15px;margin: 2px" data-value="10" value=" &pound;10 "   />    
                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 36px; height:36px; font-size:15px;margin: 2px" data-value="20" value=" &pound;20 "   />  
                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 36px; height:36px; font-size:15px;margin: 2px" data-value="50" value=" &pound;50 "   /> 
                            </div>
                        </td>

                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="2">
                            <div  style="float: right;">

                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 40px; height:50px; font-size:15px;margin: 2px" data-value="1" value=" &pound;1 "   />    
                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 40px; height:50px; font-size:15px;margin: 2px" data-value="2" value=" &pound;2 "   />      
                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 40px; height:50px; font-size:15px;margin: 2px" data-value="5" value=" &pound;5 "   />    
                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 40px; height:50px; font-size:15px;margin: 2px" data-value="10" value=" &pound;10 "   />    
                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 40px; height:50px; font-size:15px;margin: 2px" data-value="20" value=" &pound;20 "   />  
                                <input type="button" class="buttonGreen apply_pound_btn" style="width: 40px; height:50px; font-size:15px;margin: 2px" data-value="50" value=" &pound;50 "   /> 
                            </div>  &nbsp;<input class="payment"   type="hidden" name="cheque_payment" id="check_payment" value="<?php echo @$old_order ? $old_order->cheque_payment : '' ?>" />

                        </td>
                    </tr>
                <?php endif; ?>
                <input type="hidden" id="discount_type" value="percentage"/>
                <input type="hidden" name="discount" style="width:30%" id="discount" value="<?php echo @$old_order ? $old_order->discount_ratio : '' ?>" />                        
                <input type="hidden" name="discount_value" style="width:30%" id="discount_value" value="<?php echo @$old_order ? $old_order->discount_ratio : '' ?>" />                        

            </table>
            <div style="clear: both"></div>


        </div>

        <div id="search_box">
            <!--<input type="button" style="width: 18%; float: left;" id="customer_order" class="buttonGreen" value=" CUSTOMER " />-->
            <input style="width: 75%; float: left;padding-left: 10px;" type="text" id="search_product" name="search" />
            <input type="button" style="width: 18%; float: right;background: #d20000" id="cancel_order" class="buttonGreen" value="Cancel" />
        </div>
        <div style="clear: both"></div>
        <div id="cart_table">
            <table id="register" style="width: 100%">
                <tbody>
                    <tr>
                        <th id="item_info" colspan="2">Line: 0 | Qty: 0</th>
                        <th>Stk</th>
                        <?php if ($user['eu'] == '1'): ?> 
                            <th>EU</th>
                        <?php endif; ?>
                        <th>Amt</th>
                        <th>Total</th>
                        <th>&nbsp;</th>
                    </tr>
                </tbody>
                <tbody class="scroller" id="cart_items">
                </tbody>
            </table>
        </div>
    </div>
    <div id="item_listing">
        <div class="scroller" id="parent_category_list" style="min-height:40px;background: #524F4F;width: 100%;padding-top: 15px;color: #FFF;">
            <a class="show_root_category"   style="cursor: pointer;padding:10px;background:#FB9D23;min-width:120px;"> HOME </a><b> > </b>
        </div>
        <div class="scroller" id="product_list"></div>

    </div>
    <div id="suspend_date">        
        <h4>Select Day</h4><br/>
        <select name="suspend_date" style="height: 30px; min-width: 150px">
            <option value="MON">Monday</option>
            <option value="TUE">Tuesday</option>
            <option value="WED">Wednesday</option>
            <option value="THU">Thursday</option>
            <option value="FRI">Friday</option>
            <option value="SAT">Saturday</option>
            <option value="SUN">Sunday</option>
        </select>
        <br/>
        <br/>
        <input type="button" id="btn_confirm_suspend" class="buttonGreen" value=" OK " />
        <input type="button" id="btn_cancel_suspend" class="buttonGreen" value=" Cancel " />
    </div>
</form> 

<div id="print_partOfb2b"></div>
