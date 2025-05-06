<?php
include('elements/header.php');
include('elements/sidebar.php');
include('elements/topbar.php');
$pagesDir = 'pages/';
$pageFile = $pagesDir . $pageName . '.php';


include($pageFile);
include('elements/footer.php');
