<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();

JHtml::_('jquery.framework', false);

$document->addStylesheet('//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.4.33/example1/colorbox.min.css');
$document->addScript('//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.4.33/jquery.colorbox-min.js');
$document->addScript('components/com_cmd_search/assets/js/index.js');

?>

<div id="cmd_search_results">

	<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<div class="page-header">
			<div class="componentheading">
				<?php echo $this->escape($this->params->get('page_title')); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="items">
		<?php if(!empty($this->response)) echo $this->loadTemplate('results'); ?>
	</div>

</div>

<script>
    jQuery('a.cmd_modal').colorbox();
</script>