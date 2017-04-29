<?php
/**
 * View for propose_edit objects
 *
 * @package propose_edit
 */

$propose_edit = elgg_extract('entity', $vars, FALSE);

if (!$propose_edit) {
	return TRUE;
}

$owner = $propose_edit->getOwnerEntity();

$owner_icon = elgg_view_entity_icon($owner, 'small');

$body = elgg_view('output/longtext', array(
	'value' => $propose_edit->description,
	'class' => 'blog-post',
));

echo elgg_view('object/elements/full', array(
	'entity' => $propose_edit,
	'icon' => $owner_icon,
	'body' => $body,
));

$guid = $propose_edit->getGUID();

$accept_button = elgg_view('output/url', array(
	'text' => 'Accept', 
        'class' => 'elgg-button elgg-button-action',
	'is_action' => true,
        'href' => 'action/propose_edit/accept?guid='.$guid,
));

$reject_button = elgg_view('output/url', array(
	'text' => 'Reject', 
        'class' => 'elgg-button elgg-button-cancel',
	'is_action' => true,
        'href' => 'action/propose_edit/reject?guid='.$guid,
));

echo <<<HTML
<div class="mbn">
        $accept_button $reject_button
</div>
HTML;
