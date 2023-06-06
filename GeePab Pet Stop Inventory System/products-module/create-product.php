<h3>Provide the Required Information</h3>
<div id="form-block">
    <form method="POST" action="processes/process.product.php?action=newproduct">
        <div id="form-block-center">
            <label for="fname">Product Name</label>
            <input type="text" id="pname" class="input" name="pname" placeholder="Product name.." required>

            <label for="lname">Description</label>
            <textarea id="desc" class="input" name="desc" placeholder="Description.."></textarea>
            
            <label for="fname">Product Retail Price</label>
            <input type="text" id="price" class="input" name="price" placeholder="Product price.." pattern="[0-9]+" title="Please enter numbers only" required>

            <label for="ptype">Type</label>
            <select id="ptype" name="ptype">
              <?php
              if($product->list_types() != false){
                foreach($product->list_types() as $value){
                   extract($value);
              ?>
              <option value="<?php echo $type_id;?>"><?php echo $type_name;?></option>
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