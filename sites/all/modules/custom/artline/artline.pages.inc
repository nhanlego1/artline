<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 11/9/16
 * Time: 8:54 PM
 */

/**
 * Get post list
 * @param int $page_num
 * @param int $page_size
 * @return bool|string
 */
function artline_get_post($page_num = 0, $page_size = 12)
{
    global $user;
    $query = db_select('node', 'n');
    $query->fields('n');
    if ($user->uid > 0) {
        if (in_array('admin', $user->roles) || in_array('administrator', $user->roles)) {
            $query->condition(db_or()
                ->condition('status', 1)
                ->condition('status', 0)
            );
        } else {
            $query->condition(db_or()
                ->condition('uid', $user->uid)
                ->condition('status', 1)
            );
        }
    } else {
        $query->condition('status', 1);
    }


    $query->condition('type', 'article');
    $query->range($page_num, $page_size);
    $query->orderBy('created', 'DESC');
    $result = $query->execute()->fetchAllAssoc('nid');
    $data = array();
    if ($result) {
        foreach ($result as $n) {
            $data[] = node_load($n->nid);
        }
        return theme('post_list', array('nodes' => $data));
    } else {
        return false;
    }
}

/**
 * get post list query
 * @param int $page_num
 * @param int $page_size
 * @return bool|string
 */
function artline_get_post_pager()
{

    $page_num = 0;
    $page_size = 12;
    global $user;
    if ($_POST['page_num']) {

        $page_num = $page_size * $_POST['page_num'];
    }
    $query = db_select('node', 'n');
    $query->fields('n');
    if ($user->uid > 0) {
        if (in_array('admin', $user->roles) || in_array('administrator', $user->roles)) {
            $query->condition(db_or()
                ->condition('status', 1)
                ->condition('status', 0)
            );
        } else {
            $query->condition(db_or()
                ->condition('uid', $user->uid)
                ->condition('status', 1)
            );
        }
    } else {
        $query->condition('status', 1);
    }

    $query->condition('type', 'article');
    $query->range($page_num, $page_size);
    $query->orderBy('created', 'DESC');
    $result = $query->execute()->fetchAllAssoc('nid');

    $data = array();
    if ($result) {
        foreach ($result as $n) {
            $data[] = node_load($n->nid);
        }
        print (render(theme('post_list_pager', array('nodes' => $data))));
        drupal_exit();
    } else {
        print 'ko';
        drupal_exit();
    }
}

/**
 * @param $tid
 * @param int $page_num
 * @param int $page_size
 * @return bool|string
 */
function artline_get_post_cate($tid, $page_num = 0, $page_size = 12)
{
    global $user;
    $data = array();
    $children = taxonomy_get_children($tid);
    $tids = array();
    if ($children) {
        foreach ($children as $child) {
            if ($child->tid != $tid) {
                $tids[] = $child->tid;
            }
        }

    }

    $parents = taxonomy_get_parents($tid);
    if ($parents) {
        $parent = reset($parents);
        $tids[] = $parent->tid;
        $children_ = taxonomy_get_children($parent->tid);
        if ($children_) {
            foreach ($children_ as $child_) {
                if ($child_->tid != $tid) {
                    $tids[] = $child_->tid;
                }
            }

        }
    }
    $query = db_select('node', 'n');
    $query->fields('n');
    $query->innerJoin('taxonomy_index', 'ca', 'n.nid = ca.nid');

    //add or
    if ($user->uid > 0) {
        if (in_array('admin', $user->roles) || in_array('administrator', $user->roles)) {
            $db_or = db_or();
            $db_or->condition('n.status', 0);
            $db_or->condition('n.status', 1);
            //check tids
            $query->condition($db_or);
        } else {
            $db_or = db_or();
            $db_or->condition('n.uid', $user->uid);
            $db_or->condition('n.status', 0);
            $db_or->condition('n.status', 1);
            //check tids
            $query->condition($db_or);
        }
    } else {
        $query->condition('n.status', 1);
    }

    //check tids
    if ($parents) {
        $query->condition('ca.tid', $tid, '=');

    } else {
        if ($tids) {
            $query->condition('ca.tid', $tids, 'in');
        } else {
            $query->condition('ca.tid', $tid, '=');
        }


    }

    $query->condition('n.type', 'article');
    $query->orderBy('n.created', 'DESC');
    // $query->range($page_num, $page_size);

    $result = $query->execute()->fetchAllAssoc('nid');
    $data = array();
    if ($result) {
        foreach ($result as $n) {
            $data[] = node_load($n->nid);
        }
    }
    if ($parents) {
//        $data += artline_get_post_cate_other($tids);
    }
    return theme('post_list', array('nodes' => $data));
}

/**
 * @param $tid
 * @param int $page_num
 * @param int $page_size
 * @return bool|string
 */
function artline_get_post_cate_other($tids, $page_num = 0, $page_size = 12)
{
    global $user;
    $data = array();

    $query = db_select('node', 'n');
    $query->fields('n');
    $query->innerJoin('taxonomy_index', 'ca', 'n.nid = ca.nid');

    //add or
    if ($user->uid > 0) {
        if (in_array('admin', $user->roles) || in_array('administrator', $user->roles)) {
            $db_or = db_or();
            $db_or->condition('n.status', 0);
            $db_or->condition('n.status', 1);
            //check tids
            $query->condition($db_or);
        } else {
            $db_or = db_or();
            $db_or->condition('n.uid', $user->uid);
            $db_or->condition('n.status', 0);
            $db_or->condition('n.status', 1);
            //check tids
            $query->condition($db_or);
        }
    } else {
        $query->condition('n.status', 1);
    }

    //check tids
    $query->condition('ca.tid', $tids, 'in');
    $query->orderBy('n.created', 'DESC');

    $query->condition('n.type', 'article');
    //$query->range($page_num, $page_size);
    //$query->orderBy('n.created', 'DESC');
    $result = $query->execute()->fetchAllAssoc('nid');
    $data = array();
    if ($result) {
        foreach ($result as $n) {
            $data[] = node_load($n->nid);
        }
        return $data;
    } else {
        return false;
    }
}


/**
 * get post list query
 * @param int $page_num
 * @param int $page_size
 * @return bool|string
 */
function artline_get_post_pager_category()
{

    $page_num = 0;
    $page_size = 12;
    global $user;
    if ($_POST['page_num']) {

        $page_num = $page_size * $_POST['page_num'];
    }
    $tid = $_POST['tid'];
    $children = taxonomy_get_children($tid);
    $tids = array();
    if ($children) {
        foreach ($children as $child) {
            if ($child->tid != $tid) {
                $tids[] = $child->tid;
            }
        }

    }
    $query = db_select('node', 'n');
    $query->fields('n');
    $query->innerJoin('taxonomy_index', 'ca', 'n.nid = ca.nid');

    //add or
//    if ($user->uid > 0) {
//        if (in_array('admin', $user->roles) || in_array('administrator', $user->roles)) {
//            $db_or = db_or();
//            $db_or->condition('n.status', 0);
//            $db_or->condition('n.status', 1);
//            //check tids
//            $query->condition($db_or);
//        } else {
//            $db_or = db_or();
//            $db_or->condition('n.uid', $user->uid);
//            $db_or->condition('n.status', 0);
//            $db_or->condition('n.status', 1);
//            //check tids
//            $query->condition($db_or);
//        }
//    } else {
    $query->condition('n.status', 1);
    // }

    $parents = taxonomy_get_parents($tid);
    if ($parents) {
        $parent = reset($parents);
        $tids[] = $parent->tid;
        $children_ = taxonomy_get_children($parent->tid);
        if ($children_) {
            foreach ($children_ as $child_) {
                if ($child_->tid != $tid) {
                    $tids[] = $child_->tid;
                }
            }

        }
    }

    //check tids
    if ($tids) {
        $query->condition('ca.tid', $tids, 'in');
    } else {
        $query->condition('ca.tid', $tid, '=');
    }
    $query->condition('n.type', 'article');
    $query->range($page_num, $page_size);
    $query->orderBy('n.created', 'DESC');
    $result = $query->execute()->fetchAllAssoc('nid');

    $data = array();
    if ($result) {
        foreach ($result as $n) {
            $data[] = node_load($n->nid);
        }

    }
    if ($parents) {
        $data += artline_get_post_cate_other($tids, $page_num, $page_size);
    }

    print (render(theme('post_list_pager', array('nodes' => $data))));
    drupal_exit();
}

/**
 * @param int $page_num
 * @param int $page_size
 * @return bool|string
 */
function artline_get_my_post($page_num = 0, $page_size = 12)
{
    global $user;
    $query = db_select('node', 'n');
    $query->fields('n');

    $query->condition('type', 'article');
    $query->condition('uid', $user->uid);
    $query->range($page_num, $page_size);
    $query->orderBy('created', 'DESC');
    $result = $query->execute()->fetchAllAssoc('nid');
    $data = array();
    if ($result) {
        foreach ($result as $n) {
            $data[] = node_load($n->nid);
        }
        return theme('post_list', array('nodes' => $data));
    } else {
        drupal_set_message('Bạn vẫn chưa đăng bài viết.', 'status');
        drupal_goto('<front>');
    }
}

/**
 * post pager user
 */

function artline_get_my_post_pager()
{
    $page_num = 0;
    $page_size = 12;
    global $user;
    if ($_POST['page_num']) {
        $page_num = $page_size * $_POST['page_num'];
    }
    $query = db_select('node', 'n');
    $query->fields('n');
    $query->condition('uid', $user->uid, '=');
    $query->condition('type', 'article');
    $query->range($page_num, $page_size);
    $query->orderBy('created', 'DESC');
    $result = $query->execute()->fetchAllAssoc('nid');

    $data = array();
    if ($result) {
        foreach ($result as $n) {
            $data[] = node_load($n->nid);
        }
        print (render(theme('post_list_pager', array('nodes' => $data))));
        drupal_exit();
    } else {
        print 'ko';
        drupal_exit();
    }
}

/**
 * @param $node
 * @return string
 */

function _post_list_detail($node)
{
    return theme('post_list_detail', array('node' => $node));
}

/**
 * get 100 list store
 */
function artline_list_100_post_store()
{
    $query = db_select('node', 'n');
    $query->fields('n');
    $query->condition('type', 'article');
    $query->range(0, 200000);
    $query->orderBy('created', 'DESC');
    $result = $query->execute()->fetchAllAssoc('nid');
    $data = array();
    if ($result) {
        foreach ($result as $n) {
            $data[] = node_load($n->nid);
        }
        return theme('100_post_store', array('nodes' => $data));
    } else {
        return false;
    }
}

/**
 * share social
 */
function artline_share_social()
{
    global $user;
    $nid = $_POST['nid'];
    $uid = $_POST['uid'];
    //add xu
    $node = node_load($nid);
    _update_xu_user($user->uid, _type_of_xu('share_social'));
    _update_xu_user($node->uid, _type_of_xu('owner_post'));
}

/**
 * function
 */
function gift_confirm_update($token)
{
    $hash = base64_decode($token);
    $hash = explode('|', $hash);
    $node = node_load($hash[2]);
    $node->field_status[LANGUAGE_NONE][0]['value'] = 'confirm';
    node_save($node);
    drupal_set_message('Bạn đã xác nhận thành công.');
    drupal_goto('<front>');
}

/**
 * invite form
 */
function invite_friend($form, &$form_state)
{
    global $user;

    if ($user->uid <= 0) {
        drupal_set_message('Bạn vui lòng đăng nhập để mời bạn bè.');
        drupal_goto('user');
    }
    $form['invite_info'] = array(
        '#markup' => '<h4>Hãy gửi email để mời những người bạn của bạn tham gia chương trình.</h4>'
    );

    $form['email'] = array(
        '#type' => 'textarea',
        '#title' => 'Email',
        '#description' => 'Bạn có thể nhập 1 hoặc nhiều email, mỗi email cách nhau duấ phẩy(,).',
    );
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => 'Send E-mail',
    );
    return $form;
}

/**
 * invite form
 */
function invite_friend_validate($form, &$form_state)
{
    if (empty($form_state['values']['email'])) {
        form_set_error('email', t('Vui lòng nhập Email'));
    }
}

/**
 * invite form
 */
function invite_friend_submit($form, &$form_state)
{
    global $user;
    $token = base64_encode($user->mail);
    $emails = $form_state['values']['email'];
    $emails = explode(',', $emails);
    $info = variable_get('email_invite');
    $link = '<a href="' . url('user/register', array('absolute' => true, 'query' => array('token' => $token))) . '">' . url('user/register', array('absolute' => true, 'query' => array('token' => $token))) . '</a>';
    $to = '';
    foreach ($emails as $key => $email) {
        $to .= trim($email).',';
    }
    preg_match_all('/<title=[^>]+>/i',$info, $result);
    $title = str_replace('<title=','',$result);
    $title = str_replace('>','',$title);
        $params['subject'] = $title;

        $info = str_replace('[link]', $link, $info);
        $params['body'] = $info;

        // Add an associative array about this desired attachment.
        drupal_mail('artline', 'doiqua', $to, language_default(), $params, $user->mail, TRUE);
        drupal_set_message('Bạn đã gửi mail thành công.');
        drupal_goto('user');
}
