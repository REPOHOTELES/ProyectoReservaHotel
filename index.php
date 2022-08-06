<?php
	if (!isset($_GET['admin']))
        header('location: ./login');
        
    echo date('Y-m-d H:i:s');
?>
