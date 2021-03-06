<style>    
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
        min-height: 100px;
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

    #item_listing{
        width: 57%;
        float: right;               
    }
    #product_list{
        width: 85%;
        height: 100%;
        float: left;        
        background: #CDD5FE;
    }
    #category_list{
        width: 14%;
        height: 100%;
        float: right;
        margin-left: 1px;
        background: #236daa;
    }

    .product_item{
        width: 100px;
        height: 100px;
        float: left;
        margin-right: 10px;
        margin-top: 10px;
        cursor: pointer;        
        overflow: hidden;
        font-size: 14px;
        text-align: center;
        background: url('/pos_uk/public/images/empty.png') no-repeat;        
    }
    .product_item img{
        width: 100px;
        max-height: 100px;
    }

    .category_item{
        width: 97%;
        height: 70px;                
        cursor: pointer;
        border: 1px solid;
        overflow: hidden;
        margin-top: 10px;
        text-align: center;
        background: url('/pos_uk/public/images/empty_cat.png') no-repeat;               
    }
    .category_item img{
        width: 97%;
        max-height: 70px;
    }

    .buttonGreen{
        cursor: pointer;
    }

    table#register td input[type="text"]{
        border: 1px solid #BBB;
        font-size: 12px;
        width: 98%;
        font-weight: normal;
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

    /*    .show_last_history:hover .tooltiptext {
            visibility: hidden;
        } */
</style>
<script type="text/javascript">
    window.JSON || document.write('<script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.2.4/json3.min.js"><\/script>');
</script>

<script type="text/javascript">
    var json_categories = JSON.parse('<?php echo addslashes($categories) ?>');
    var json_products = JSON.parse('<?php echo addslashes($products) ?>');
    var json_stocks = JSON.parse('<?php echo addslashes($stocks) ?>');
    var json_customers = JSON.parse('<?php echo addslashes($customers) ?>');
    var json_temp_products = JSON.parse('<?php echo addslashes($temp_products) ?>');
    var base_url = '<?php echo Yii::app()->baseUrl ?>';
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
        if (_products) {
            $.each(_products, function (k, product) {
                if (product.wholesale_price >0) {
                    content = '<div class="product_item" data-name="' + product.product_name + '" data-price="' + product.wholesale_price + '" data-id="' + product.product_code + '" id="product_item_"' + product.product_code + '><img  alt="' + product.product_name + '" src="' + base_url + '/images/products/' + product.image + '" /></div>';
                    $("#product_list").append(content);
                }
                else {
                      content = '<div class="product_item" data-name="' + product.product_name + '" data-price="' + product.sell_price + '" data-id="' + product.product_code + '" id="product_item_"' + product.product_code + '><img  alt="' + product.product_name + '" src="' + base_url + '/images/products/' + product.image + '" /></div>';
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
                if (product.wholesale_price >0) {
                    content = '<div class="product_item" data-name="' + product.product_name + '" data-price="' + product.wholesale_price + '" data-id="' + product.product_code + '" id="product_item_"' + product.product_code + '><img  alt="' + product.product_name + '" src="' + base_url + '/images/products/' + product.image + '" /><br>&pound;' + parseFloat(product.wholesale_price).toFixed(2) + '</div>';
                    $("#product_list").append(content);
                }
                else {
                    content = '<div class="product_item" data-name="' + product.product_name + '" data-price="' + product.sell_price + '" data-id="' + product.product_code + '" id="product_item_"' + product.product_code + '><img  alt="' + product.product_name + '" src="' + base_url + '/images/products/' + product.image + '" /><br>&pound;' + parseFloat(product.sell_price).toFixed(2) + '</div>';
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
        $.each(categories, function (k, category) {
            content = '<div class="category_item" data-id="' + category.id + '" id="category_item_"' + category.id + '><img  alt="' + category.category_name + '" src="' + base_url + '/images/categories/' + category.image + '" /></div>';
            $("#category_list").append(content);
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
        var product, content = '', price, total_price = 0.00, vat_total = 0.00, total_item = 0, item_count = 0, b_price = 0;
        var cnt_key = 0;
        var arr_content = new Array();
        $.each(cart, function (k, val) {
            if (val) {
                //alert(val.product_code);
                product = get_product(val.product_code);
                if (product) {
                    var stock_amt = stocks[product.product_code] ? stocks[product.product_code].product_balance : 0;
                    var pname = val.product_name != "" ? val.product_name : product.product_name;
                    var pprice = parseFloat(val.product_price) > 0 ? parseFloat(val.product_price) : parseFloat(product.sell_price);
                    var lastbuy = product.purchase_date;
                    price = (pprice * parseFloat(val.quantity)).toFixed(2);

                    total_price = parseFloat(total_price) + parseFloat(price);
                    total_item += parseFloat(val.quantity);
                    item_count++;

                    //purchase cost                
                    b_price = parseFloat(b_price) + (parseFloat(product.purchase_cost) * parseFloat(val.quantity));

                    //if sell price changed
                    if (pprice != parseFloat(product.sell_price)) {
                        var profitVat = ((pprice - (parseFloat(product.purchase_cost) + parseFloat(product.vat_on_purchase))) * (parseFloat(product.vat) / 100)).toFixed(2);
                        cart[k].vat_on_profit = profitVat;
                        vat_total = parseFloat(vat_total) + (parseFloat(profitVat) + parseFloat(product.vat_on_purchase)) * parseFloat(val.quantity);
                    } else {
                        vat_total = parseFloat(vat_total) + (parseFloat(product.vat_on_profit) + parseFloat(product.vat_on_purchase)) * parseFloat(val.quantity);
                    }


                    var _style = '';
                    //                if(parseInt(k) == cart_key-1) {
                    //                    content = '<tr style="font-weight:bold" id="cart_item_row_'+product.product_code+'">';
                    //                    _style = 'font-weight:bold';
                    //                    
                    //                } else {
                    //                    content = '<tr id="cart_item_row_'+product.product_code+'">';
                    //                }
                    //                              
                    var $min_stock = '';
                    if (stock_amt < product.min_stock) {
                        $min_stock = 'style="background:pink"';
                    }
                    content = '<tr class="cart_item_row" id="cart_item_row_' + product.product_code + '" ' + $min_stock + '>';
                    content += '<td><input data-id="' + product.product_code + '" type="text" size="1" class="cart_qty" value="' + val.quantity + '"></td><td><input  data-id="' + product.product_code + '" class="product_name" style="width:98%;' + _style + '" type="text" value="' + pname + '"><div class="lastbuy">' + lastbuy + '</div></td><td>' + (parseFloat(stock_amt)).toFixed(0) + '</td><td style="color:silver" data-id="' + product.product_code + '"  class="show_last_history"><span class="tooltiptext" id="tooltiptext_' + product.product_code + '">Loading...</span>' + parseFloat(parseFloat(product.purchase_cost) + parseFloat(product.vat_on_purchase)).toFixed(2) + '</td><td><input style="' + _style + '" type="text" class="product_price" size="1" data-id="' + product.product_code + '" value="' + parseFloat(pprice).toFixed(2) + '"></td>';
                    content += '<td>' + price + '</td>';
                    content += '<td><a href="javascript:void(0)" class="cart_add" data-id="' + val.product_code + '"><img src="' + base_url + '/public/images/icon_add.png"></a> <a href="javascript:void(0)" class="cart_remove" data-id="' + val.product_code + '"><img src="' + base_url + '/public/images/delete.png"></a></td></tr>';

                    arr_content[cnt_key++] = content;
                } else { //no product
                    var pprice = parseFloat(val.product_price) > 0 ? parseFloat(val.product_price) : 0;
                    price = (pprice * parseFloat(val.quantity)).toFixed(2);
                    total_price = parseFloat(total_price) + parseFloat(price);
                    total_item += parseFloat(val.quantity);

                    content = '<tr class="cart_item_no_product cart_item_row" style="background:red" id="cart_item_row_' + val.product_code + '">';
                    content += '<td><input data-id="' + val.product_code + '" type="text" size="1" class="cart_qty" value="' + val.quantity + '"></td><td><input  data-id="' + val.product_code + '" class="product_name" style="width:98%;' + _style + '" type="text" value="' + val.product_code + '"></td><td></td><td style="color:silver"></td><td><input style="' + _style + '" type="text" class="product_price" size="1" data-id="' + val.product_code + '" value="' + pprice + '"></td>';
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
        var amount = $("#total_cost").val() ? parseFloat($("#total_cost").val()) : 0;
        var new_amount = amount;
        var discount_amount = 0;
        if (discount > 0 && amount > 0) {
            discount_amount = (amount * (discount / 100)).toFixed(2);
            new_amount = amount - discount_amount;
        }

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
        $("#paid_amount").val(payment.toFixed(2));
        $("#due_amount").html((new_amount - payment).toFixed(2));
        $("#discount_amount").html(discount_amount);
        $("#vat_amount").html(vat_total);
    }

    function clear_order() {
        cart = {};
        cart_key = 0;
        $(".payment").val('');
        $("input[type=hidden]").val('');
        $("#discount").val('');
        $("#discount_amount").html('');
        $("#cart_items").html('');
        $("#buy_price").html('');
        $("#item_info").html('Line: 0 | Qty: 0');
        $("#product_list").empty();
        calculate_amount();
        setCookie('pos_cart', "", 1);
    }

    function check_input() {
        if ($("#customer_id").val() == 0) {
            alert("No customer selected!");
            return false;
        }
        if ($("#total_cost").val() == 0) {
            alert("No item in cart");
            return false;
        }
//        if($("#paid_amount").val() == 0) {
//            alert("No payment done!");
//            return false;
//        }
        return true;
    }

    // Actions after loading the content
    $(document).ready(function () {
        $("body, #cart_section, #item_listing").css('height', $(window).height());
//        $(".scroller").niceScroll({
//                    cursorwidth:0
//                });
        show_categories();
        //show_products(0);
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



<?php if ($customer_id) : ?>
            ccustomer = <?php echo $customer_id ?>;
            setCookie('pos_customer', ccustomer);
<?php endif; ?>

        var pos_cart_customer = getCookie("pos_customer");
        if (pos_cart_customer != "") {
            $("#customer_id").val(pos_cart_customer);
            $.post(base_url + '/public/get_jquery.php?customer_id=' + pos_cart_customer, {}, function (resp) {
                var result = resp.split("_");
                $("#customer").html(result[0]);
                $("#comment").val(result[1]);
                $("#customer").append('&nbsp;<input type="button" class="buttonGreen" id="customer_invoice" value="Inv." />');
            });
        }



        calculate_amount();

        $(".category_item").live('click', function (e) {
            var id = $(this).attr('data-id');
            show_products(id);
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
                var result = resp.split("_");
                $("#customer").html(result[0]);
                $("#comment").val(result[1]);
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
            //var _product = get_product(pcode);
            var _key = get_cart_key(pcode);
            //console.log(_product)
            cart[_key].product_price = parseFloat($(this).val().trim());
            //console.log(cart[_key])
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

        $("#search_product").keyup(function (e) {
            if (e.keyCode == 13) {
                var pcode = $(this).val().trim().toUpperCase();
                if (pcode != "") {
                    cart_action('add', pcode);
//                    var product = get_product(pcode);
//                    if(product) cart_action('add', pcode);
                    $(this).val('');
                }
            }
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
            var url = base_url + '/b2b_sell/addOrder';
            $("#cart_info").val(JSON.stringify(cart));
            if (check_input()) {
                setCookie('pos_cart', "", 1);
                $("#frm_order").submit();
            }

//            var data = $("#frm_order").serialize();            
//            $.post(url, data, function(resp){
//                $('html').replaceWith(resp);
//            });
        });


        $("#btn_confirm_suspend").click(function () {
            var url = base_url + '/b2b_sell/suspendOrder';
            $("#cart_info").val(JSON.stringify(cart));

            var data = $("#frm_order").serialize();
            $.post(url, data, function (resp) {
                //alert("Sell Suspended Successfully....");                    
                clear_order();
            });

            $("#suspend_date").fadeOut();
        });

        $("#btn_cancel_suspend").click(function (e) {
            $("#suspend_date").fadeOut();
        });

        $("#suspend_order").click(function (e) {
            e.preventDefault();
            if ($(this).hasClass('suspended_list')) {
                location = base_url + '/b2b_sell/suspended/';
            } else {
                //alert('here');
                $("#suspend_date").fadeIn();
            }

        });

        $("#save_order").click(function (e) {
            e.preventDefault();
            var url = base_url + '/b2b_sell/addTemporary';
            $("#cart_info").val(JSON.stringify(cart));
            var data = $("#frm_order").serialize();
            $.post(url, data, function (resp) {
                alert("Saved as temporary....");
            });

        });

        $("#cancel_order").click(function (e) {
            e.preventDefault();
            clear_order();
            $.post(base_url + '/b2b_sell/sell_cancel', {'ajax_call': 1}, function (resp) {
                $("#search_product").focus();
            });

        });

    });
</script>

<form method="post" id="frm_order" action="<?php echo Yii::app()->baseUrl ?>/b2b_sell/addOrder">
    <input type="hidden" id="product_code" /> 
    <input type="hidden" name="total_cost" id="total_cost" />
    <input type="hidden" name="final_cost" id="final_cost" />
    <input type="hidden" name="paid_amount" id="paid_amount" />
    <input type="hidden" name="cart_info" id="cart_info" />
    <input type="hidden" name="vat_total" id="vat_total" />
    <input type="hidden" name="suspend_id" value="<?php echo $suspend_id ?>" />
    <input type="hidden" name="existing_invoice_no" value="<?php echo @$old_order ? $old_order->invoice_no : '' ?>" />
    <div class="scroller" id="cart_section">        
        <div id="total_price">
            <div style="float: left; width: 25%">
                <a href="<?php echo Yii::app()->baseUrl ?>/super"><img alt="" width="85%" src="<?php echo Yii::app()->baseUrl ?>/public/images/header_logo.png"></a>
            </div>

            <div style="float: left; margin-top: 10px; font-size: 30px; width: 40%; font-weight: bold; text-align: center">
                <div>&pound;<span id="total_sell_price">0.00</span></div>
                <div style="font-size: 18px; margin-top: 5px; clear: both">Due: &pound;<span id="due_amount">0.00</span></div>
                <div style="font-size: 13px; margin-top: 5px; clear: both">Vat: &pound;<span id="vat_amount">0.00</span></div>
                <div style="font-size: 13px; margin-top: 5px; clear: both">Disc: &pound;<span id="discount_amount">0.00</span></div>                
            </div>
            <div style="float: right; width: 30%">
                <input type="button" class="buttonGreen" style="width: 100%"  value=" Suspend " id="suspend_order" /><br/>
                <!-- <input type="button" class="buttonGreen" style="width: 100%"  value=" Save " id="save_order" />      <br/> -->
                <input type="button" class="buttonGreen" style="width: 100%; height:50px; font-size:25px" value=" PRINT " id="print_order" />    <br/>                
            </div>
            <div style="clear: both"></div>
        </div>
        <div style="width: 100%; margin: 10px 0"></div>            
        <div id="cart_header" style="padding: 5px 0">
            <table style="float: left; width: 50%;">
                <tr>
                    <td>Disc: </td> <td><input type="text" name="discount" style="width:60%" id="discount" value="<?php echo @$old_order ? $old_order->discount_ratio : '' ?>" />%</td>
                </tr>
                <tr>
                    <td>Cheq: </td> <td><input class="payment" style="width: 90%" type="text" name="cheque_payment" id="check_payment" value="<?php echo @$old_order ? $old_order->cheque_payment : '' ?>" /></td>
                </tr>
            </table>
            <table style="float: right; width: 50%; text-align: right">
                <tr>
                    <td>Cash: </td> <td><input class="payment" style="width:90%" type="text" name="cash_payment" id="cash_payment"  value="<?php echo @$old_order ? $old_order->cash_payment : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Card: </td><td><input class="payment" style="width:90%" type="text" name="credit_card_payment" id="card_payment" value="<?php echo @$old_order ? $old_order->credit_card_payment : '' ?>" />                        
                    </td>
                </tr>                
            </table>
            <div style="clear: both"></div>
            <div style="border-top: 1px dashed; width: 100%; margin: 10px 0"></div>            
            <div>
                Customer : <select id="customer_id" name="customer_id" style="width: 20%">
                    <option value="0">Select</option>
                    <?php foreach ($org_customers as $customer) : ?>
                        <option value="<?php echo $customer['id'] ?>" <?php echo $customer_id == $customer['id'] ? 'selected' : '' ?>><?php echo $customer['customer_name'] ?>-<?php echo $customer['id'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" style="width: 30%" id="comment" name="comment" />
                <span id="customer"></span><span id="buy_price" style="font-size: 11px; font-weight: normal; color: #BBB"></span>
            </div>

        </div>

        <div id="search_box">
            <input style="width: 80%; float: left" type="text" id="search_product" name="search" />
            <input type="button" style="width: 18%; float: right" id="cancel_order" class="buttonGreen" value="Cancel" />
        </div>
        <div style="clear: both"></div>


        <div id="cart_table">
            <table id="register" style="width: 100%">
                <tbody>
                    <tr>
                        <th id="item_info" colspan="2">Line: 0 | Qty: 0</th>
                        <th>Stk</th>
                        <th>EU</th>
                        <th>Amt</th>
                        <th>Tot</th>
                        <th>&nbsp;</th>
                    </tr>
                </tbody>
                <tbody class="scroller" id="cart_items">

                </tbody>
            </table>
        </div>
    </div>


    <div id="item_listing">

        <div class="scroller" id="product_list">
        </div>
        <div class="scroller" id="category_list">
        </div>

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
        </select><br/><br/>

        <input type="button" id="btn_confirm_suspend" class="buttonGreen" value=" OK " />
        <input type="button" id="btn_cancel_suspend" class="buttonGreen" value=" Cancel " />
    </div>

</form> 