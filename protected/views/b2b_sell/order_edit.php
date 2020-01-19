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

    #item_listing{
        width: 57%;
        float: right;
        margin: 0 auto;
    }
    
    #section_product_list{
        width: 84%;
        height: 100%;
        float: left;        
        background: #CDD5FE;
    }
    #product_list{
        width: 100%;
        height: 100%;
        float: left;        
        background: #CDD5FE;
    }
    #category_list{
        width: 14%;
        height: 100%;
        float: left;
        margin-left: 1px;
        background: #236daa;
    }

        #sub_category_list{
            width: 100%;
            background: #CDD5FE;
            height:auto;
        }

    .product_item{
        width: 97px;
        height: 100px;
        float: left;
        margin-right: 7px;
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

    .sub_category_item {
        background: rgba(0, 0, 0, 0) url("/pos_uk/public/images/empty_cat.png") no-repeat scroll 0 0;
        border: 1px solid;
        cursor: pointer;
        height: 70px;
        overflow: hidden;
        text-align: center;
        width: 103px;
        float:left;
        margin:0px 5px 0px 5px;
    }

    .sub_category{
        width: 97%;
        height: 70px;                
        cursor: pointer;
        border: 1px solid;
        overflow: hidden;
        margin-top: 10px;
        text-align: center;
        background: url('/pos_uk/public/images/empty_cat.png') no-repeat;               
    }
    .sub_category img{
        width: 97%;
        max-height: 70px;
    }

    .category_item{
        width: 17%;
        height: 70px;  
        float: left;
        cursor: pointer;
        border: 1px solid;
        overflow: hidden;
        margin-top: 10px;
        margin-right: 5px;
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
    
    .category_item .current{
        display:block;
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


</style>
<script type="text/javascript">
    window.JSON || document.write('<script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.2.4/json3.min.js"><\/script>');
</script>

<script type="text/javascript">
    var previous_id = 0;
    var current_id = 0;
    var json_categories = JSON.parse('<?php echo addslashes($categories) ?>');
    var json_sub_categories = JSON.parse('<?php echo addslashes($sub_categories) ?>');
    var json_products = JSON.parse('<?php echo addslashes($products) ?>');
    var json_temp_products = JSON.parse('<?php echo addslashes($temp_products) ?>');
    var base_url = '<?php echo Yii::app()->baseUrl ?>';
    var cart = {}, cart_key = 0;

    var categories = {}, sub_categories = {}, products = {}, temp_products = {}, stocks = <?php echo stripslashes($stocks) ?>;

    $.each(json_categories, function (k, val) {
        categories[k] = val;
    });

    $.each(json_sub_categories, function (sk, val) {
        sub_categories[sk] = val;
    });

//    $.each(json_sub_categories, function(sk, val){
//        sub_categories[sk] = new Array();
//		if(val) {
//			$.each(val, function(i, value){
//				if(value) sub_categories[sk][i] = value;
//			});        
//		}        
//    });


    $.each(json_products, function (kp, val) {
        products[kp] = new Array();
        if (val) {
            $.each(val, function (j, value) {
                if (value)
                    products[kp][j] = value;
            });
        }
    });


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

    function list_sub_categories(_sub_categories) {

        $("#sub_category_list").empty();
        if (_sub_categories) {
            content_btn =  '<a class="buttonGreen"  id="prev" style="width: 14%; height:32px; font-size:16px; text-align:center; padding-top:8px; margin:10px 10px 0px 0px; float:left;"> Go Back </a>';
            $("#sub_category_list").append(content_btn);
            
            $.each(_sub_categories, function (sk, sub_category) {
                if (sub_category) {
                    content = '<div class="category_item category'+ sub_category.id + '" data-id="' + sub_category.id + '" id="category_item_"' + sub_category.id + '><img  alt="' + sub_category.category_name + '" src="' + base_url + '/images/categories/' + sub_category.image + '"/></div>';
                    $("#sub_category_list").append(content);
                }
            });

        } else {
            content = 'No Items!';
            $("#sub_category_list").append(content);
        }
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

    function show_sub_category(category_id) {
        var sub_items, content, i, j, k;
        var _sub_categories = Array();
        var i = 0;

        $.each(sub_categories, function (k, sub_items) {
            if (sub_items.parent_id == category_id) {
                _sub_categories[i++] = sub_items;

            }
        });

        list_sub_categories(_sub_categories);

    }

    function has_sub_category(category_id) {
        var return_value = 0;
        $.each(sub_categories, function (k, sub_items) {

            if (sub_items.parent_id == category_id) {
                return_value = 1;
                return true;
            }

        });
        return return_value;
    }

    /**
     * Make html content for all categories  
     */
    function show_categories() {
        var content;
        $("#category_list").empty();
        $.each(categories, function (k, category) {
            content = '<div class="sub_category category'+category.id+'" data-id="' + category.id + '" id="category_item_"' + category.id + '><img  alt="' + category.category_name + '" src="' + base_url + '/images/categories/' + category.image + '" /></div>';
            $("#category_list").append(content);
        });
    }

    function show_sub_categories() {
        var content;
        //$("#sub_category_list").empty();
        $.each(sub_categories, function (sk, sub_categories) {
            content = '<div class="category_item" data-id="' + sub_categories.id + '" id="category_item_"' + sub_categories.id + '><img  alt="' + sub_categories.category_name + '" src="' + base_url + '/images/categories/' + sub_categories.image + '" /></div>';
            $("#sub_category_list").append(content);
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

                    var $min_stock = '';
                    if (stock_amt < product.min_stock) {
                        $min_stock = 'style="background:pink"';
                    }
                    content = '<tr class="cart_item_row" id="cart_item_row_' + product.product_code + '" ' + $min_stock + '>';
                    content += '<td><input data-id="' + product.product_code + '" type="text" size="1" class="cart_qty" value="' + val.quantity + '"></td><td><input  data-id="' + product.product_code + '" class="product_name" style="width:98%;" type="text" value="' + pname + '"><div class="lastbuy">' + lastbuy + '</div></td><td>' + (parseFloat(stock_amt)).toFixed(0) + '</td><td><input type="text" class="product_price" size="1" data-id="' + product.product_code + '" value="' + parseFloat(pprice).toFixed(2) + '"></td>';
                    content += '<td>' + price + '</td>';
                    content += '<td><a href="javascript:void(0)" class="cart_add" data-id="' + val.product_code + '"><img  src="' + base_url + '/public/images/icon_add.png"></a> <a href="javascript:void(0)" class="cart_remove" data-id="' + val.product_code + '"><img  src="' + base_url + '/public/images/delete.png"></a></td></tr>';

                    arr_content[cnt_key++] = content;
                } else { //no product
                    content = '<tr class="cart_item_no_product" style="background:red" id="cart_item_row_' + val.product_code + '">';
                    content += '<td><input data-id="' + val.product_code + '" type="text" size="1" class="cart_qty" value="' + val.quantity + '"></td><td><input  data-id="' + val.product_code + '" class="product_name" style="width:98%;" type="text" value="' + val.product_code + '"></td><td></td><td><input type="text" class="product_price" size="1" data-id="' + val.product_code + '" value="0.00"></td>';
                    content += '<td>0.00</td>';
                    content += '<td><a href="javascript:void(0)" class="cart_add" data-id="' + val.product_code + '"><img  src="' + base_url + '/public/images/icon_add.png"></a> <a href="javascript:void(0)" class="cart_remove" data-id="' + val.product_code + '"><img  src="' + base_url + '/public/images/delete.png"></a></td></tr>';

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

        calculate_amount();
        setCookie('pos_cart_sell', JSON.stringify(cart), 1);

        $("#cart_items").html(content);
        $("#item_info").html('ITEM | Line: ' + item_count + ' | Qty: ' + total_item.toFixed(2));
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
        $("#cart_items").html('');
        $("#item_info").html('ITEM | Line: 0 | Qty: 0');
        $("#product_list").empty();
        calculate_amount();
        setCookie('pos_cart_sell', "", 1);
    }

    function check_input() {

        if ($("#total_cost").val() == 0) {
            alert("No item in cart");
            return false;
        }
        if ($("#paid_amount").val() == 0) {
            alert("No payment done!");
            return false;
        }
        if (parseFloat($("#final_cost").val()) > parseFloat($("#paid_amount").val())) {
            alert("Payment due yet!");
            return false;
        }
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

        var pos_cart = getCookie("pos_cart_sell");
        if (pos_cart != "") {
            cart = JSON.parse(pos_cart);
            //get the cart keys as array
            var cart_keys = Object.keys(cart);
            //get the last key of the keys array
            cart_key = cart_keys[cart_keys.length - 1];
            //now increase the key to add next item
            cart_key++;
            show_cart_items();
        } else {
            $.each(json_temp_products, function (k, val) {
                cart_action('add', val.product_code, val);
            });
        }



        calculate_amount();
        
        $(".category_item").live('click', function (e) {
            var id = $(this).attr('data-id');
            previous_id = current_id;            
            current_id = id;
//            previous_id = previous_id + current_id ;
//            previous_id =  previous_id - current_id;
//            current_id =  previous_id - current_id;
            
            show_products(id);
            hide_content("sub_category_list");

            if (has_sub_category(id) == 1) {
                show_sub_category(id);
                show_content("sub_category_list");              
            }
            
        });
        
        $(".sub_category").live('click', function (e) {
            var id = $(this).attr('data-id');
            previous_id = current_id;            
            current_id = id;

            show_products(id);
            hide_content("sub_category_list");
            
            if (has_sub_category(id) == 1) {
                show_sub_category(id);
                show_content("sub_category_list");
                
            }
            
        });


        $("#search_product").autocomplete(base_url + '/public/product_list.php', {//we have set data with source here
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
            var _product = get_product(pcode);
            if (parseFloat($(this).val().trim()) != parseFloat(_product.sell_price)) {
                var _key = get_cart_key(pcode);
                cart[_key].product_price = parseFloat($(this).val().trim());
            }
            show_cart_items();
        });

        $(".cart_qty").live('blur', function (e) {
            var pcode = $(this).attr('data-id');

            var _key = get_cart_key(pcode);
            cart[_key].quantity = parseFloat($(this).val().trim());
            show_cart_items();
        });

        $(".cart_item_row").live({
            mouseenter: function () {
                $(this).find('.lastbuy').show();
            },
            mouseleave: function () {
                $(this).find('.lastbuy').hide();
            }
        });


        $("#suspend_order").click(function (e) {
            e.preventDefault();
            var url = base_url + '/sell/ajax_suspend_order';
        });

        $("#search_product").keyup(function (e) {
            if (e.keyCode == 13) {
                var pcode = $(this).val().trim().toUpperCase();
                if (pcode != "") {
                    cart_action('add', pcode);
                    $(this).val('');
                }
            }
        });



        $("#print_order").click(function (e) {
            e.preventDefault();
            var nproduct = $(".cart_item_no_product").length;
            if (nproduct) {
                alert(nproduct + ' Item(s) not found, Please check !');
                return false;
            }
            var url = base_url + '/sell/addOrder';
            $("#cart_info").val(JSON.stringify(cart));
            if (check_input()) {
                setCookie('pos_cart_sell', "", 1);
                $("#frm_order").submit();
            }

//            var data = $("#frm_order").serialize();            
//            $.post(url, data, function(resp){
//                $('html').replaceWith(resp);
//            });
        });

        $("#btn_confirm_suspend").click(function () {
            var url = base_url + '/sell/suspendOrder';
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
                location = base_url + '/sell/suspended/';
            } else {
                //alert('here');
                $("#suspend_date").fadeIn();
            }

        });

        $("#save_order").click(function (e) {
            e.preventDefault();
            var url = base_url + '/sell/addTemporary';
            $("#cart_info").val(JSON.stringify(cart));
            var data = $("#frm_order").serialize();
            $.post(url, data, function (resp) {
                alert("Saved as temporary....");
            });

        });

        $("#cancel_order").click(function (e) {
            e.preventDefault();
            clear_order();
            $.post(base_url + '/sell/sell_cancel', {'ajax_call': 1}, function (resp) {
                $("#search_product").focus();
            });
        });

    });
</script>

<form method="post" id="frm_order" action="<?php echo Yii::app()->baseUrl ?>/sell/addOrder">
    <input type="hidden" id="product_code" /> 
    <input type="hidden" name="total_cost" id="total_cost" />
    <input type="hidden" name="final_cost" id="final_cost" />
    <input type="hidden" name="paid_amount" id="paid_amount" />
    <input type="hidden" name="cart_info" id="cart_info" />
    <input type="hidden" name="vat_total" id="vat_total" />
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
                <input type="button" class="buttonGreen" style="width: 100%; height:50px; margin-top: 0px; font-size:25px" value=" PRINT " id="print_order" />    <br/>                
            </div>
            <div style="clear: both"></div>
        </div>
        <div style="width: 100%; margin: 10px 0"></div>            
        <div id="cart_header" style="padding: 5px 0">
            <table style="float: left; width: 50%;">
                <tr>
                    <td>Disc: </td> <td><input type="text" name="discount" style="width:60%" id="discount" value="" />%</td>
                </tr>
                <tr>
                    <td>Cheq: </td> <td><input class="payment" style="width: 90%" type="text" name="cheque_payment" id="check_payment" value="" /></td>
                </tr>
            </table>
            <table style="float: right; width: 50%; text-align: right">
                <tr>
                    <td>Cash: </td> <td><input class="payment" style="width:90%" type="text" name="cash_payment" id="cash_payment"  value="" /></td>
                </tr>
                <tr>
                    <td>Card: </td><td><input class="payment" style="width:90%" type="text" name="credit_card_payment" id="card_payment" value="" />                        
                    </td>
                </tr>                
            </table>            
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
                        <th id="item_info" colspan="2">ITEM | Line: 0 | Qty: 0</th>
                        <th>Stk</th>
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
        
        <div id="section_product_list">
<!--            <a href="#" onclick="goBack()" class="btn btn-success btn-md" >Go Back</a>-->
            <div class="scroller" id="sub_category_list">
               
            </div>
            <div class="scroller" id="product_list">  
                
            </div>            
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

<!-- <script>
    function goBack() {
        window.history.back();
    }
</script> -->

<script>
function show_content(target) {
    //$(".common-content").hide();
    $("#" + target).fadeIn();
    window.scrollTo(0, 0);
}

function hide_content(target){
    $("#" + target).fadeOut();
    window.scrollTo(0, 0);
}

 $(document).ready(function () {
     
    $("body").on("click", "#prev", function(e) {
        e.preventDefault();
        show_previous();
        
        current_id = previous_id + current_id ;
        previous_id = current_id - previous_id ;
        current_id = current_id - previous_id ;
    });
});

function show_previous(){       
        show_products(previous_id);
        hide_content("sub_category_list");
        if (has_sub_category(previous_id) == 1) {
            show_sub_category(previous_id );
            show_content("sub_category_list"); 
        }                
}
</script>