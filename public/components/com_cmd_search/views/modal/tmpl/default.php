<?php

$result = $this->response;
$source = $this->response['_source'];

?>

<?php $tmpFile = array(); ?>
<?php foreach ($source['files'] as $file) {
	if($file['type'] == 'link' || $file['type'] == 'file'){
		$tmpFile['title'] = $file['title'];
		$tmpFile['url'] = $file['path'];
		//break;
	} elseif($file['type'] == 'embed') {
		$tmpFile['title'] = $file['title'];
		$tmpFile['url'] = html_entity_decode($file['path']);
	}
	$tmpFile['width'] = '800';
	$tmpFile['height'] = '1200';
}

if(!empty($tmpFile)) {
	echo (string)$tmpFile['url'];
}

?>

<iframe src="#" width="800" height="600"></iframe>
