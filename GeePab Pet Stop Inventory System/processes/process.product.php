<?php
include '../classes/class.product.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
    case 'newtype':
        create_new_type();
	break;
    case 'newproduct':
        create_new();
	break;
    case 'updateproduct':
        update_product();
	break;
}

function create_new_type(){
	$product = new Product();
    $tname= ucwords($_POST['tname']);    
    $tid = $product->new_product_type($tname);
    if(is_numeric($tid)){
        header('location: ../index.php?page=settings&subpage=products&action=types&id='.$tid);
    }
}
function create_new(){
	$product = new Product();
    $pname= ucwords($_POST['pname']);  
    $desc= ucwords($_POST['desc']);  
    $price= ucwords($_POST['price']);    
    $type= $_POST['ptype'];  
    $pid = $product->new_product($pname,$desc,$price,$type);
    if(is_numeric($pid)){
        header('location: ../index.php?page=settings&subpage=products&action=profile&id='.$pid);
    }
}
function update_product(){
	$product = new Product();
    $pname = ucwords($_POST['pname']);  
    $desc = ucwords($_POST['desc']);   
    $type = $_POST['ptype'];
    $price = $_POST['price'];  // get the updated price
    $pid = $_POST['prodid']; 
    $result = $product->update_product($pname, $desc, $type, $price, $pid); // pass the updated price to the method
    header('location: ../index.php?page=settings&subpage=products&action=profile&id='.$pid);
}

