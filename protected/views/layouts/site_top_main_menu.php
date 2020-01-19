<div class="grid_16" id="header">
<!-- MENU START -->
<div id="menu">
	<ul class="group" id="menu_group_main">
		<li class="item first"  id="one"><a href="<?php  echo Yii::app()->request->baseUrl.'/customer_register'; ?>" <?php if($mainTab == "customer"): ?> class="main current" <?php else: ?> class="main" <?php endif; ?>><span class="outer"><span class="inner customer">Customer Register</span></span></a></li>
        <li class="item middle" id="two"><a href="<?php  echo Yii::app()->request->baseUrl.'/product'; ?>"  <?php if($mainTab == "login"): ?> class="main current" <?php else: ?> class="main" <?php endif; ?>><span class="outer"><span class="inner login">Login</span></span></a></li>
		<li class="item last"   id="eight"><a href="<?php echo Yii::app()->request->baseUrl.'/site/contact'; ?>"  <?php if($mainTab == "contact_us"): ?> class="main current" <?php else: ?> class="main" <?php endif; ?>><span class="outer"><span class="inner contact">Contact Us</span></span></a></li>     
    </ul>
</div>
<!-- MENU END -->
</div>
<div class="grid_16">
</div>
