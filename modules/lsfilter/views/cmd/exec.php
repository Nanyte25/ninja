<?php
if(isset($error)) {
	echo sprintf(_('There was an error submitting your command to %s.'), Kohana::config('config.product_name'));
	if (!empty($error)) {
		echo '<br /><br />' . $error;
	}
} elseif ($count === $success) {
	if ($count === 1) {
?>
	Successfully ran <?php echo $command; ?>
<?php
	} else {
?>
	Successfully ran <?php echo $command; ?> for <?php echo $count . ' ' . $table; ?>
<?php
	}
} else {
	if ($success > 0) {
		?>
			Successfully ran <?php echo $command; ?> for <?php echo ($success) . ' ' . $table; ?><br />
		<?php
	}
?>
	Failed to run <?php echo $command; ?> for <?php echo ($count - $success) . ' ' . $table; ?>
<?php
}
