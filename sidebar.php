<?php
//in divid=sidebar_container
?>

<div id="sidebar_container">
<script>

function updateShouts(){    
$('#sidebar_container').load('test1.php?page=1&rpp=10&result_type=recent');
}; 
setInterval(updateShouts, 3000 );

</script>

Loading....

 </div>