<?php
include_once 'classes/class.user.php';
include_once 'classes/class.product.php';
include_once 'classes/class.sales.php';
include 'config/config.php';

$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : '';
$subpage = (isset($_GET['subpage']) && $_GET['subpage'] != '') ? $_GET['subpage'] : '';
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
$id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
$type = (isset($_GET['type']) && $_GET['type'] != '') ? $_GET['type'] : ''; // Add this line to retrieve the $type variable

$user = new User();
$product = new Product();
$sales = new Sales();

if(!$user->get_session()){
	header("location: login.php");
}

$user_id = $user->get_user_id($_SESSION['user_email']);

// Check user access
$user_access = $user->get_user_access($user_id);

if ($user_access == 'Staff') {

    // User with "Staff" access cannot add, update, or change products
    if (($page == 'settings' && $action == 'profile') || 
        ($page == 'settings' && $action == 'create')) {
        echo "You do not have access to perform this action. 
        <a href='index.php'>Go back to homepage</a>";
        exit();
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>GeePab's Pet Stop</title>
    <meta charset="UTF-8">
	<link rel="icon" type="image/x-icon" href="img/fishy.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet'>
    <link rel="stylesheet" href="css/custom.css?<?php echo time();?>">
    <script src="jscript/script.js"></script>
</head>
<body>


  <div class="nav">
		<ul class="menu">
    <li><a href="index.php">Main</a></li>
    <li><a href="index.php?page=reports">Reports</a></li>
    <li><a href="index.php?page=sales">Sales List</a></li>
    <li><a href="index.php?page=order">Order</a></li>
    <li><a href="index.php?page=settings">Settings</a> <a id="logout" href="logout.php">Log Out</a></li>
	<span id="user" style="color:white;" class="move-right"><?php echo $user->get_user_access($user_id).'  -  '. $user->get_user_lastname($user_id).', '.$user->get_user_firstname($user_id);?>&nbsp;&nbsp; &nbsp;&nbsp;</span>
		</ul>
  </div>

            <div id="content">
                <?php
                switch($page){
                            case 'settings':
                                require_once 'settings-module/index.php';
                            break; 
                            case 'sales':
                                require_once 'sale-list/index.php';
                            break; 
                            case 'order':
                                require_once 'order/index.php';
                            break; 
                            case 'reports':
                                require_once 'reports.php';
                            break; 
                            default:
                                require_once 'main.php';
                            break; 
                        }
                ?>
            </div>
    </div>
</div>
</body>
</html>