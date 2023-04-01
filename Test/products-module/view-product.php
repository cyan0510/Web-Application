<h3>Product Details</h3>
<div class="btn-box">
<a href="index.php?page=settings&subpage=products&action=upload" class="btn-jsactive">Upload Image</a> | 
</div>
<br/>
<div id="form-block">
    <form method="POST" action="processes/process.product.php?action=updateproduct">
        <div id="form-block-center">
            <label for="fname">Product Name</label>
            <input type="text" id="pname" class="input" name="pname" value="<?php echo $product->get_prod_name($id);?>" placeholder="Product name..">

            <label for="lname">Description</label>
            <textarea id="desc" class="input" name="desc" placeholder="Description.."><?php echo $product->get_prod_desc($id);?></textarea>
          
            <input type="hidden" id="prodid" name="prodid" value="<?php echo $id;?>"/>
            <label for="ptype">Type</label>
            <select id="ptype" name="ptype">
              <?php
              if($product->list_types() != false){
                foreach($product->list_types() as $value){
                   extract($value);
              ?>
              <option value="<?php echo $type_id;?>" <?php if($product->get_prod_type($id) == $type_id){ echo "selected";};?>><?php echo $type_name;?></option>
              <?php
                }
              }
              ?>
        </select>
              </div>
        <div id="button-block">
        <input type="submit" value="Save">
        </div>
  </form>
</div>