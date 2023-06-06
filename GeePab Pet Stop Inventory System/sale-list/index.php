<script>
function showResults(str) {
  if (str.length == 0) {
    document.getElementById("search-result").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("search-result").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "sale-list/search.php?q=" + str, true);
    xmlhttp.send();
  }
}
</script>


<div id="third-submenu">
    <a style="float: left;" href="index.php?page=sales"> | Sale List</a>
    <input type="text" id="search-input" placeholder="Search by Client Name" onkeyup="showResults(this.value)">
</div>
<div id="subcontent">
    <?php
    require_once 'classes/class.sales.php';
    $sales = new Sales();
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    switch ($action) {
        case 'modify':
            require_once 'edit-sale.php';
            break;
        default:
            require_once 'sale-list.php';
            break;
    }
    ?>
</div>
