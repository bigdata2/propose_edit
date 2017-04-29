<?php

elgg_gatekeeper();
$entity_guid = (int) get_input("entity_guid");
forward("propose_edit/edit/$entity_guid");
