<?php

defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();

JHtml::_('jquery.framework', false);

$document->addScript('components/com_cmd_search/assets/js/index.js');

$result = $this->response;
$source = $this->response['_source'];

?>

<h1><?php echo $source['title']; ?></h1>

<?php if(!empty($source['flags'])) { ?>
<div class="flags">
	<?php foreach ($source['flags'] as $flag) { ?>
		<span class="flag">
			<!-- TODO: change URL to default search menu item param -->
			<a href="<?php echo JRoute::_('/search?flags='.$flag); ?>" class="label label-important">
				<?php echo $flag; ?>
			</a>
		</span>
	<?php } ?>
</div>
<?php } ?>

<?php if(!empty($source['topics'])) { ?>
<div class="topics">
	<?php foreach ($source['topics'] as $topic) { ?>
		<span class="topic">
			<!-- TODO: change URL to default search menu item param -->
			<a href="<?php echo JRoute::_('/search?topics='.$topic); ?>" class="label">
				<?php echo $topic; ?>
			</a>
		</span>
	<?php } ?>
</div>
<?php } ?>

<?php if(!empty($source['types'])) { ?>
<div class="types">
	<?php foreach ($source['types'] as $type) { ?>
		<span class="type">
			<!-- TODO: change URL to default search menu item param -->
			<a href="<?php echo JRoute::_('/search?types='.$type); ?>" class="label label-info">
				<?php echo $type; ?>
			</a>
		</span>
	<?php } ?>
</div>
<?php } ?>

<?php if(!empty($source['extensions'])) { ?>
<div class="extensions">
	<?php foreach ($source['extensions'] as $extension) { ?>
		<span class="extension">
			<!-- TODO: change URL to default search menu item param -->
			<a href="<?php echo JRoute::_('/search?extensions='.$extension); ?>" class="label label-warning">
				<?php echo $extension; ?>
			</a>
		</span>
	<?php } ?>
</div>
<?php } ?>

<?php if(!empty($source['introtext'])) { ?>
	<p><?php echo $source['introtext']; ?></p>
<?php } ?>	
