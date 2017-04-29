<?php
/**
 * Form for proposing edit to entity content
 *
 * @package Elgg
 *
 * @uses ElggEntity  $vars['entity']  The entity being edited
 */

if (!elgg_is_logged_in()) {
	return;
}

$entity = elgg_extract('entity', $vars);

$entity_guid_input = '';
if ($entity) {
	$entity_guid_input = elgg_view('input/hidden', array(
		'name' => 'entity_guid',
		'value' => $entity->guid,
	));
}

$comment_text = '';
$submit_input = elgg_view('input/submit', array('value' => elgg_echo('Submit')));
$comment_text = $entity->description;

$cancel_button = elgg_view('input/button', array(
	'value' => elgg_echo('cancel'),
	'class' => 'elgg-button-cancel mlm',
	'href' => $entity ? $entity->getURL() : '#',
));
$cancel_button = '';

$comment_input = elgg_view('input/longtext', array(
	'name' => 'generic_comment',
	'value' => $comment_text,
	'required' => true
));

	echo <<<FORM
<div>
	$comment_input
</div>
<div class="elgg-foot">
	$entity_guid_input
	$submit_input $cancel_button
</div>
FORM;
