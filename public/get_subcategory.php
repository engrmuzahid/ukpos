<?php
include 'db.php';

$category_id = $_REQUEST['category_id'];

$results = mysql_query("select * FROM product_type WHERE product_category_id = '$category_id'");


?>
                
                    <?php while($subcategory = mysql_fetch_assoc($results)) : ?>
                        <option value="<?= $subcategory['id'] ?>"><?= $subcategory['type_name'] ?></option>
                    <?php endwhile; ?>
