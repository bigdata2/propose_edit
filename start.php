<?php
/**
 * The main file for this plugin
 */

define('PROPOSED_EDIT_BLOCK', 'suggested_edit_for');
require_once(dirname(__FILE__) . '/lib/propose_edit.php');

// register default Elgg events
elgg_register_event_handler('init', 'system', 'propose_edit_init');

/**
 * This function is called when the Elgg system gets initialized
 *
 * @return void
 */
function propose_edit_init() {
	//Add an entity menu to route to the edit page
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'propose_edit_menu_setup');

	//routing of urls
	elgg_register_page_handler('propose_edit', 'propose_edit_page_handler');

	// register actions
	$action_path = __DIR__ . '/actions';
	elgg_register_action('propose_edit/edit', "$action_path/edit.php");
	elgg_register_action('propose_edit/save', "$action_path/save.php");
	elgg_register_action('propose_edit/reject', "$action_path/reject.php");
	elgg_register_action('propose_edit/accept', "$action_path/accept.php");
}

function propose_edit_page_handler($page) {
	$page_type = elgg_extract(0, $page, 'all');
	$resource_vars = array();

	switch ($page_type) {
		case "edit":

			$entity_guid = elgg_extract(1, $page);
			$entity = get_entity((int)$entity_guid);
                	$resource_vars['guid'] = $entity_guid;
                	$resource_vars['entity'] = $entity;
                	echo elgg_view_resource('propose_edit/edit', $resource_vars);
			break;
		case "view":
			$entity_guid = elgg_extract(1, $page);
			
                        $resource_vars['guid'] = $entity_guid;
                        $resource_vars['guid'] = elgg_extract(1, $page);

                        echo elgg_view_resource('propose_edit/view', $resource_vars);
                        break;

		default:
                        return false;
	}

       	return true;
}
