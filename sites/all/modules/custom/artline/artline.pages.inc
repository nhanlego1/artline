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
function artline_get_post($page_num = 0, $page_size = 8)
{
    global $user;
    $query = db_select('node', 'n');
    $query->fields('n');
    if($user->uid > 0){
        if(in_array('admin',$user->roles) || in_array('administrator',$user->roles)){
            $query->condition(db_or()
                ->condition('status', 1)
                ->condition('status', 0)
            );
        }else{
            $query->condition(db_or()
                ->condition('uid', $user->uid)
                ->condition('status', 1)
            );
        }
    }else{
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
    $page_size = 8;
    global $user;
    if ($_POST['page_num']) {

        $page_num = $page_size * $_POST['page_num'];
    }
    $query = db_select('node', 'n');
    $query->fields('n');
    if($user->uid > 0){
        if(in_array('admin',$user->roles) || in_array('administrator',$user->roles)){
            $query->condition(db_or()
                ->condition('status', 1)
                ->condition('status', 0)
            );
        }else{
            $query->condition(db_or()
                ->condition('uid', $user->uid)
                ->condition('status', 1)
            );
        }
    }else{
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
function artline_get_post_cate($tid, $page_num = 0, $page_size = 8)
{
    global $user;
    $data = array();
    $children = taxonomy_get_children($tid);
    $tids = array();
    if ($children) {
        foreach ($children as $child) {
            if($child->tid != $tid){
                $tids[] = $child->tid;
            }
        }

    }

    $parents = taxonomy_get_parents($tid);
    if($parents){
        $parent = reset($parents);
            $tids[] = $parent->tid;
            $children_ = taxonomy_get_children($parent->tid);
            if ($children_) {
                foreach ($children_ as $child_) {
                    if($child_->tid != $tid){
                        $tids[] = $child_->tid;
                    }
                }

            }
    }
    $query = db_select('node', 'n');
    $query->fields('n');
    $query->innerJoin('field_data_field_category', 'ca', 'n.nid = ca.entity_id');

    //add or
    if($user->uid > 0){
        if(in_array('admin',$user->roles) || in_array('administrator',$user->roles)){
            $db_or = db_or();
            $db_or->condition('n.status', 0);
            $db_or->condition('n.status', 1);
            //check tids
            $query->condition($db_or);
        }else{
            $db_or = db_or();
            $db_or->condition('n.uid', $user->uid);
            $db_or->condition('n.status', 0);
            $db_or->condition('n.status', 1);
            //check tids
            $query->condition($db_or);
        }
    }else{
        $query->condition('n.status', 1);
    }

    //check tids
    if($parents){
        $query->condition('ca.field_category_tid', $tid, '=');

    }else{
        if($tids){
            $query->condition('ca.field_category_tid', $tids, 'in');
        }else{
            $query->condition('ca.field_category_tid', $tid, '=');
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
    if($parents){
        $data += artline_get_post_cate_other($tids);
    }
    return theme('post_list', array('nodes' => $data));
}

/**
 * @param $tid
 * @param int $page_num
 * @param int $page_size
 * @return bool|string
 */
function artline_get_post_cate_other($tids, $page_num = 0, $page_size = 8)
{
    global $user;
    $data = array();

    $query = db_select('node', 'n');
    $query->fields('n');
    $query->innerJoin('field_data_field_category', 'ca', 'n.nid = ca.entity_id');

    //add or
    if($user->uid > 0){
        if(in_array('admin',$user->roles) || in_array('administrator',$user->roles)){
            $db_or = db_or();
            $db_or->condition('n.status', 0);
            $db_or->condition('n.status', 1);
            //check tids
            $query->condition($db_or);
        }else{
            $db_or = db_or();
            $db_or->condition('n.uid', $user->uid);
            $db_or->condition('n.status', 0);
            $db_or->condition('n.status', 1);
            //check tids
            $query->condition($db_or);
        }
    }else{
        $query->condition('n.status', 1);
    }

    //check tids
        $query->condition('ca.field_category_tid', $tids, 'in');
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
    $page_size = 8;
    global $user;
    if ($_POST['page_num']) {

        $page_num = $page_size * $_POST['page_num'];
    }
    $tid = $_POST['tid'];
    $children = taxonomy_get_children($tid);
    $tids = array();
    if ($children) {
        foreach ($children as $child) {
            if($child->tid != $tid){
                $tids[] = $child->tid;
            }
        }

    }
    $query = db_select('node', 'n');
    $query->fields('n');
    $query->innerJoin('field_data_field_category', 'ca', 'n.nid = ca.entity_id');

    //add or
    if($user->uid > 0){
        if(in_array('admin',$user->roles) || in_array('administrator',$user->roles)){
            $db_or = db_or();
            $db_or->condition('n.status', 0);
            $db_or->condition('n.status', 1);
            //check tids
            $query->condition($db_or);
        }else{
            $db_or = db_or();
            $db_or->condition('n.uid', $user->uid);
            $db_or->condition('n.status', 0);
            $db_or->condition('n.status', 1);
            //check tids
            $query->condition($db_or);
        }
    }else{
        $query->condition('n.status', 1);
    }

    $parents = taxonomy_get_parents($tid);
    if($parents){
        $parent = reset($parents);
        $tids[] = $parent->tid;
        $children_ = taxonomy_get_children($parent->tid);
        if ($children_) {
            foreach ($children_ as $child_) {
                if($child_->tid != $tid){
                    $tids[] = $child_->tid;
                }
            }

        }
    }

    //check tids
    if ($tids) {
        $query->condition('ca.field_category_tid', $tids, 'in');
    } else {
        $query->condition('ca.field_category_tid', $tid, '=');
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
    if($parents){
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
function artline_get_my_post($page_num = 0, $page_size = 8)
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
        drupal_set_message('Bạn vẫn chưa đăng bài viết.','status');
        drupal_goto('<front>');
    }
}

/**
 * post pager user
 */

function artline_get_my_post_pager()
{
    $page_num = 0;
    $page_size = 8;
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
function artline_list_100_post_store(){
    $query = db_select('node','n');
    $query->fields('n');
    $query->condition('type','article');
    $query->range(0,200);
    $query->orderBy('created','DESC');
    $result = $query->execute()->fetchAllAssoc('nid');
    $data = array();
    if($result){
        foreach($result as $n){
            $data[] = node_load($n->nid);
        }
        return theme('100_post_store',array('nodes'=>$data));
    }else{
        return false;
    }
}