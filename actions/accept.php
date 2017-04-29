<?php
/**
 * Save propose_edit entity
 *
 * Can be called by clicking submit button.
 *
 */

$error = FALSE;
$error_forward_url = REFERER;
$user = elgg_get_logged_in_user_entity();

$guid = get_input('guid');
if (!$guid) {
        forward("");
}

$propose_edit_entity = get_entity((int)$guid);

$entityarray = elgg_get_entities_from_relationship(array(
          'relationship' => PROPOSED_EDIT_BLOCK,
          'relationship_guid' => $propose_edit_entity->getGUID(),
          'inverse_relationship' => FALSE,
          'limit' => false,
));

if ($entityarray) {
	$related_entity = array_values($entityarray)[0];
	$related_entity->description = $propose_edit_entity->description;
	$related_entity->save();
	remove_entity_relationship($propose_edit_entity->getGUID(),PROPOSED_EDIT_BLOCK,$related_entity->getGUID());
	$propose_edit_entity->delete();
	
}
forward("");
