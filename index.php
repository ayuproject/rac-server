<?php
  require_once('layout/header.php');
  require_once('layout/sidebar.php');
?>
<?php
$time_start = microtime(true);

// Sleep for a while
usleep(100);

$time_end = microtime(true);
$time = $time_end - $time_start;
echo $_SERVER["HTTP_HOST"] ."<br>";
echo "start_time_: ". $time_start ." <br>";
echo "end_time__: ". $time_end ." <br>";
echo "start_time_: ". hash('ripemd160', $time_start. "") ." <br>";
echo "end_time__: ". hash('ripemd160', $time_end. "") ." <br>";

echo "Did nothing in $time seconds<br>";
?>
    <?php/*
    require_once('object/android-app.php');
    $android = new appAndroid();
    if ($android->getData("1")) {
	    echo "name : ". $android->name ."<br>";
	    echo "desc : ". $android->desc ."<br>";
	    echo "src_app : ". $android->src_app ."<br>";
	    echo "src_pdf : ". $android->src_pdf ."<br>";
	    echo "src_ico : ". $android->src_ico ."<br>";	
    }
    */?>

<?php
  require_once('layout/footer.php');
?>
