<h3>Provide the Required Information</h3>
<div id="form-block">
    <form action="products-module/upload.php" method="post" enctype="multipart/form-data">
    <input type="hidden" id="userid" name="userid" value="<?php echo $id;?>"/>
    <label for="fileToUpload">Select image to upload:</label>
    <input type="file" name="fileToUpload" id="fileToUpload" multiple>
    <input type="submit" value="Upload Image" name="submit">
    </form>
</div>