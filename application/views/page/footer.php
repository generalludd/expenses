<?php defined('BASEPATH') or exit('No direct script access allowed');
?>
<div id="ci-version">
	<?php echo "CI Version: " . CI_VERSION; ?>
</div>
<div id="app-version">
	<?php echo "App Version: " . APP_VERSION; ?>
</div>
<?php if (isset($scripts)): ?>
	<?php foreach ($scripts as $script): ?>
		<?php if ( ! empty($script->location) && $script->location == 'footer'): ?>
			<?php if ($script->url): ?>
                <script type="text/javascript"
                        src="<?php print $script->url; ?>"></script>
			<?php else: ?>
                <script type="text/javascript"><?php print $script->code; ?></script>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>

