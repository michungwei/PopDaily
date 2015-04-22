<?php
include_once('_config.php');

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

$sql = "SELECT * 
		FROM $table_about 
		ORDER BY about_ind DESC";
$rows = $db -> fetch_all_array($sql);
?>

<ul class="clear">
<?php
	foreach($rows as $row){
?>
    <li>
        <article>
            <h4><?php echo $row["about_title"]; ?></h4>
            <p><?php echo $row["about_content"]; ?></p>
        </article>
    </li>
<?php
	}
?>
</ul>
