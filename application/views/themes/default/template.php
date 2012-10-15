<?php defined('SYSPATH') OR die('No direct access allowed.');

	$authorized = false;
	if (Auth::instance()->logged_in()) {
		$ninja_menu_setting = Ninja_setting_Model::fetch_page_setting('ninja_menu_state', '/');

		$auth = Nagios_auth_Model::instance();
		if ($auth->view_hosts_root) {
			$authorized = true;
		}
	}

?>
<!DOCTYPE html>
<html>
	
	<?php
		include_once(__DIR__.'/dojo/head.php');
	?>

	<body>

		<div class="container">
			
			<div id="infobar-sml">
				<p><?php echo html::image('application/views/themes/default/icons/16x16/shield-warning.png',array('style' => 'float: left; margin-right: 5px', 'alt' => 'Warning')).' '.sprintf(_('It appears that the database is not up to date. Verify that Merlin and %s are running properly.'), Kohana::config('config.product_name')); ?></p>
			</div>

			<div class="logo">
				<?php echo html::image('application/views/themes/default/icons/op5.gif', array('style' => 'float: left; margin-left: 15px;')); ?>
			</div>

			<?php
				include_once(__DIR__.'/dojo/header.php');
			?>

			<div class="navigation" id="navigation">
				<div class="menu" id="main-menu">

				<?php
					include_once(__DIR__.'/dojo/menu.php');
				?>

				</div>
				<div class="slider" id="slider" title="Collapse Navigation">
					<div class="slide-button">
						::
					</div>
				</div>

			</div>

			<div class="content" id="content">
				
				
					<?php if (isset($content)) { echo $content; } else { url::redirect(Kohana::config('routes.logged_in_default')); }?>
				
			</div>
			
			<?php 

				if (isset($saved_searches) && !empty($saved_searches)) {
					echo $saved_searches;
				}
				
			?>

			<div id="save-search-form" title="<?php echo _('Save search') ?>" style="display:none">
				<form>
				<p class="validateTips"></p>
				<fieldset>
					<label for="search_query"><?php echo _('Search string') ?></label>
					<input type="text" name="search_query" id="search_query" value="<?php echo isset($query_str) ? $query_str : '' ?>" class="texts search_query ui-widget-content ui-corner-all" />
					<label for="search_name"><?php echo _('Name') ?></label>
					<input type="text" name="search_name" id="search_name" class="texts ui-widget-content ui-corner-all" />
					<label for="search_description"><?php echo _('Description') ?></label>
					<textarea cols="30" rows="3" name="search_description" id="search_description" class="texts ui-widget-content ui-corner-all"></textarea>
					<input type="hidden" name="search_id" id="search_id" value="0">
				</fieldset>
				</form>
			</div>

		</div>
		<?php
			echo html::script('application/media/js/dojo.js');
		?>

	</body>
</html>
