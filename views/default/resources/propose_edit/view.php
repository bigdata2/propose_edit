<?php

$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', 'propose_edit');

$propose_edit_entity = get_entity($guid);

$entityarray = elgg_get_entities_from_relationship(array(
          'relationship' => PROPOSED_EDIT_BLOCK,
          'relationship_guid' => $propose_edit_entity->getGUID(),
          'inverse_relationship' => FALSE,
          'limit' => false,
));

$related_entity = '';

if ($entityarray) {
        $related_entity = array_values($entityarray)[0];
}

$params = [
	'filter' => '',
	'title' => "Original post"
];

$params['content'] = elgg_view_entity($related_entity);

$body = elgg_view_layout('content', $params);

$params = [
	'filter' => '',
	'title' => "Proposed Edit"
];

$params['content'] = elgg_view_entity($propose_edit_entity);

$body = $body . elgg_view_layout('content', $params);

echo elgg_view_page($params['title'], $body);
