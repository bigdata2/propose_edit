<?php
/**
 * Save propose_edit entity
 *
 * Can be called by clicking submit button.
 *
 */

$guid = get_input('entity_guid');
if (!$guid) {
	forward("");
}

$original_entity = get_entity((int)$guid);
if (!$original_entity) {
	forward("");
}

$comment_text = get_input('generic_comment');

//create a new entity
$proposed_edit = new ElggObject();
$proposed_edit->subtype = 'propose_edit';
$proposed_edit->access_id = 2; //public access
$proposed_edit->description = $comment_text;
$proposed_edit->save();
$user = get_entity((int)elgg_get_logged_in_user_guid());

add_entity_relationship($proposed_edit->getGUID(),
			PROPOSED_EDIT_BLOCK,
			$original_entity->getGUID());

//send notification to author of the original post
$subject = $user->name . elgg_echo('propose_edit:notification:subject');
$body  = elgg_echo('propose_edit:notification:body:preamble') ;
$body  = $body . " " . elgg_echo('propose_edit:url') . $proposed_edit->getGUID() . "\n";
$body  = $body . " " . elgg_echo('propose_edit:notification:body:epilouge') . "\n";
$body  = $body .  $original_entity->description ;
$params = array();
notify_user($original_entity->getOwnerGUID(), 
	    $proposed_edit->getOwnerGUID(), 
	    $subject, $body, $params);

system_message(elgg_echo("propose_edit:action:save"));
