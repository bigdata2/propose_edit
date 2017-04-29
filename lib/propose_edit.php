<?php

/**
 * A collection of functions used in this plugin
 *
 */
function propose_edit_prepare_form_vars($post = NULL) {

        $values = array(
                'description' => NULL,
                'access_id' => ACCESS_DEFAULT,
                'container_guid' => NULL,
                'owner_guid' => NULL,
        );
        if ($post) {
                foreach (array_keys($values) as $field) {
                        if (isset($post->$field)) {
                                $values[$field] = $post->$field;
                        }
                }
		$values['entity'] = $post;
        }
        return $values;
}

/**
 * Get page components to edit a post.
 *
 */
function propose_edit_get_page_content_edit( $guid = 0) {

        $return = array(
                'filter' => '',
        );

        $vars = array();

        $sidebar = '';
        $edit_entity = get_entity((int)$guid);
        $vars['entity'] = $edit_entity;
        $vars['entity_guid'] = (int)$guid;

        $title = elgg_echo('propose_edit:title');
        $body_vars = propose_edit_prepare_form_vars($edit_entity);

        $content = elgg_view_form('propose_edit/save', $vars, $body_vars);

        $return['title'] = $title;
        $return['content'] = $content;
        $return['sidebar'] = $sidebar;
        return $return;
}

/**
 * Check if a logged in user can propose edit to a specific post.
 *
 */
function propose_edit_can_edit(ElggEntity $entity, $user_guid = 0) {
	
	$user_guid = sanitise_int($user_guid, false);
	if (empty($user_guid)) {
		$user_guid = elgg_get_logged_in_user_guid();
	}
	
	if (empty($user_guid) || !($entity instanceof ElggEntity)) {
		return false;
	}
	
	if ($entity->getOwnerGUID() === $user_guid) {
		//owner can not propose edits to his/her content
		return false;
	}

	$supported_entity_types = propose_edit_get_supported_entity_types();
	$type = $entity->getType();
	if (empty($supported_entity_types) || !isset($supported_entity_types[$type])) {
		return false;
	}
	
	return true;
}

/**
 * A list of entities that will have propose edit menu visible in them.
 *
 */
function propose_edit_get_supported_entity_types() {
	$result = [
		'object' => [
			'blog',
			'comment'
		],
	];
	
	$params = [
		'defaults' => $result,
	];
	
	return elgg_trigger_plugin_hook('entity_types', 'propose_edit', $params, $result);
}

function propose_edit_menu_setup($hook, $type, $return, $params) {
        if (!elgg_is_logged_in()) {
                return;
        }

        if (empty($params) || !is_array($params)) {
                return;
        }

        $entity = elgg_extract('entity', $params);
        if (empty($entity) || !propose_edit_can_edit($entity)) {
                return;
        }

        $return[] = \ElggMenuItem::factory([
                'name' => 'propose_edit',
                'text' => elgg_echo('propose_edit:edit'),
                'href' => "action/propose_edit/edit?entity_guid={$entity->getGUID()}",
                'is_action' => true,
		'is_trusted' => true,
                'priority' => 150,
		'item_class' => '',
                ]);

	return $return;
}
