<?php
/**
 * @file
 * Content administration.
 */

function node_order_setting_form() {
  $types = node_type_get_types();
  foreach ($types as $type) {
    $options[$type->type] = $type->name;
  } 
  $form['node_order_types'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Choose types for order'),
    '#options' => $options,
    '#default_value' => variable_get('node_order_types', array())
  );
  $form = system_settings_form($form);
  $form['#submit'][] = 'node_order_setting_form_submit';
  return $form;
}
function node_order_setting_form_submit($form, &$form_state) {
  menu_rebuild();
}

function node_order_content_by_type($form, &$form_state, $type) {
  $form['admin'] = node_order_admin_nodes($type);
  return $form;
}

function node_order_admin_nodes($type) {
  $admin_access = user_access('administer nodes');

  // Enable language column if translation module is enabled
  // or if we have any node with language.
  $multilanguage = (module_exists('translation') || db_query("SELECT COUNT(*) FROM {node} WHERE language <> :language", array(':language' => LANGUAGE_NONE))->fetchField());

  // Build the sortable table header.
  $header = array(
    'title' => t('Title'),
    'type' => t('Type'), 
    'author' => t('Author'),
    'status' => t('Status'),
    'changed' => t('Updated'),
  );
  if ($multilanguage) {
    $header['language'] = array('data' => t('Language'), 'field' => 'n.language');
  }
  $header['operations'] = array('data' => t('Operations'));
  $header['weight_node'] = array('data' => t('Weight'));

  $query = db_select('node', 'n');

  if (!user_access('bypass node access')) {
    // If the user is able to view their own unpublished nodes, allow them
    // to see these in addition to published nodes. Check that they actually
    // have some unpublished nodes to view before adding the condition.
    if (user_access('view own unpublished content') && $own_unpublished = db_query('SELECT nid FROM {node} WHERE uid = :uid AND status = :status', array(':uid' => $GLOBALS['user']->uid, ':status' => 0))->fetchCol()) {
      $query->condition(db_or()
        ->condition('n.status', 1)
        ->condition('n.nid', $own_unpublished, 'IN')
      );
    }
    else {
      // If not, restrict the query to published nodes.
      $query->condition('n.status', 1);
    }
  }
  $nids = $query
    ->fields('n', array('nid'))
    ->condition('n.type', $type)
    ->condition('n.status', 1)
    ->orderBy('n.sticky', 'ASC')
    ->orderBy('n.created', 'DESC')
    ->execute()
    ->fetchCol();
  
  $nodes = node_load_multiple($nids, array(), TRUE);

  // Prepare the list of nodes.
  $languages = language_list();
  $destination = drupal_get_destination();
  $options = array();
  foreach ($nodes as $node) {
    $l_options = $node->language != LANGUAGE_NONE && isset($languages[$node->language]) ? array('language' => $languages[$node->language]) : array();
    $options[$node->nid] = array(
      'title' => array(
        'data' => array(
          '#type' => 'link',
          '#title' => $node->title,
          '#href' => 'node/' . $node->nid,
          '#options' => $l_options,
          '#suffix' => ' ' . theme('mark', array('type' => node_mark($node->nid, $node->changed))),
        )
      ),
      'type' => check_plain(node_type_get_name($node)),
      'author' => theme('username', array('account' => $node)),
      'status' => $node->status ? t('published') : t('not published'),
      'changed' => format_date($node->changed, 'short'),
    );
    if ($multilanguage) {
      if ($node->language == LANGUAGE_NONE || isset($languages[$node->language])) {
        $options[$node->nid]['language'] = $node->language == LANGUAGE_NONE ? t('Language neutral') : t($languages[$node->language]->name);
      }
      else {
        $options[$node->nid]['language'] = t('Undefined language (@langcode)', array('@langcode' => $node->language));
      }
    }
    // Build a list of all the accessible operations for the current node.
    $operations = array();
    if (node_access('update', $node)) {
      $operations['edit'] = array(
        'title' => t('edit'),
        'href' => 'node/' . $node->nid . '/edit',
        'query' => $destination,
      );
    }
    if (node_access('delete', $node)) {
      $operations['delete'] = array(
        'title' => t('delete'),
        'href' => 'node/' . $node->nid . '/delete',
        'query' => $destination,
      );
    }
    
    
    $options[$node->nid]['operations'] = array();
    if (count($operations) > 1) {
      // Render an unordered list of operations links.
      $options[$node->nid]['operations'] = array(
        'data' => array(
          '#theme' => 'links__node_operations',
          '#links' => $operations,
          '#attributes' => array('class' => array('links', 'inline')),
        ),
      );
    }
    elseif (!empty($operations)) {
      // Render the first and only operation as a link.
      $link = reset($operations);
      $options[$node->nid]['operations'] = array(
        'data' => array(
          '#type' => 'link',
          '#title' => $link['title'],
          '#href' => $link['href'],
          '#options' => array('query' => $link['query']),
        ),
      );
    }
    $selector = node_order_selector($node->nid);
    $options[$node->nid]['weight_node'] = $selector;
  }

  // Only use a tableselect when the current user is able to perform any
  // operations.
  
  $form['nodes'] = array(
    '#theme' => 'table',
    '#header' => $header,
    '#rows' => $options,
    '#empty' => t('No content available.'),
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Update weight'),
    '#submit' => array('node_order_node_submit'),
  );
  return $form;
}

function node_order_node_submit($form, &$form_state) {
  $weights = $_POST['weights'];
  foreach ($weights as $nid => $sticky) {
    $node = node_load($nid);
    $node->sticky = $sticky;
    node_save($node);
  }
  $form_state['redirect'] = 'admin/content/' . arg(2);
  drupal_set_message(t('Updated Weights for') . ' ' . arg(2) . ' ' . t('nodes.'));
}