<div id="second-submenu">
    <a href="index.php?page=settings&subpage=users">Users</a> |
    <a href="index.php?page=settings&subpage=products">Products</a> |
</div>
<div id="content">
    <?php
      switch($subpage){
                case 'users':
                    require_once 'users-module/index.php';
                break; 
                case 'products':
                    require_once 'products-module/index.php';
                break; 
            }
    ?>
  </div>

  