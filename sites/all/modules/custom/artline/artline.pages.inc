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
function artline_get_post($page_num=0, $page_size=8){
    global $user;
    $query = db_select('node','n');
    $query->fields('n');
    $db_or = db_or();
    $db_or->condition('uid', $user->uid , '=');
    $db_or->condition('type','article');
    $db_or->condition('status',0);
    $query->condition($db_or);
    $query->condition('type','article');
    $query->condition('status',1);
    $query->range($page_num,$page_size);
    $query->orderBy('created','DESC');
    $result = $query->execute()->fetchAllAssoc('nid');
    $data = array();
    if($result){
        foreach($result as $n){
            $data[] = node_load($n->nid);
        }
        return theme('post_list',array('nodes'=>$data));
    }else{
        return false;
    }
}

/**
 * get post list query
 * @param int $page_num
 * @param int $page_size
 * @return bool|string
 */
function artline_get_post_pager(){

    $page_num=0;
    $page_size=8;
    global $user;
    if($_POST['page_num']){

        $page_num = $page_size * $_POST['page_num'];
    }
    $query = db_select('node','n');
    $query->fields('n');
    $db_or = db_or();
    $db_or->condition('uid', $user->uid , '=');
    $db_or->condition('type','article');
    $db_or->condition('status',0);
    $query->condition($db_or);
    $query->condition('type','article');
    $query->condition('status',1);
    $query->range($page_num,$page_size);
    $query->orderBy('created','DESC');
    $result = $query->execute()->fetchAllAssoc('nid');

    $data = array();
    if($result){
        foreach($result as $n){
            $data[] = node_load($n->nid);
        }
        print (render(theme('post_list_pager',array('nodes'=>$data))));
        drupal_exit();
    }else{
        print 'ko';
        drupal_exit();
    }
}

function artline_get_post_cate($tid, $page_num=0, $page_size=8){
    global $user;
    $children = taxonomy_get_children($tid);
    $tids = array();
    if($children){
        foreach($children as $child){
            $tids[] = $child->tid;
        }

    }
    $query = db_select('node','n');
    $query->fields('n');
    $query->innerJoin('field_data_field_category','ca','n.nid = ca.entity_id');

    //add or
    $db_or = db_or();
    $db_or->condition('n.uid', $user->uid , '=');
    $db_or->condition('n.type','article');
    $db_or->condition('n.status',0);
    //check tids
    if($tids){
        $db_or->condition('ca.field_category_tid',$tids,'in');
    }else{
        $db_or->condition('ca.field_category_tid',$tid,'=');
    }
    $query->condition($db_or);

    //check tids
    if($tids){
        $query->condition('ca.field_category_tid',$tids,'in');
    }else{
        $query->condition('ca.field_category_tid',$tid,'=');
    }
    $query->condition('n.type','article');
    $query->condition('n.status',1);
    $query->range($page_num,$page_size);
    $query->orderBy('n.created','DESC');
    $result = $query->execute()->fetchAllAssoc('nid');
    $data = array();
    if($result){
        foreach($result as $n){
            $data[] = node_load($n->nid);
        }
        return theme('post_list',array('nodes'=>$data));
    }else{
        return false;
    }
}

/**
 * get post list query
 * @param int $page_num
 * @param int $page_size
 * @return bool|string
 */
function artline_get_post_pager_category(){

    $page_num=0;
    $page_size=8;
    global $user;
    if($_POST['page_num']){

        $page_num = $page_size * $_POST['page_num'];
    }
    $tid = $_POST['tid'];
    $children = taxonomy_get_children($tid);
    $tids = array();
    if($children){
        foreach($children as $child){
            $tids[] = $child->tid;
        }

    }
    $query = db_select('node','n');
    $query->fields('n');
    $query->innerJoin('field_data_field_category','ca','n.nid = ca.entity_id');

    //add or
    $db_or = db_or();
    $db_or->condition('n.uid', $user->uid , '=');
    $db_or->condition('n.type','article');
    $db_or->condition('n.status',0);
    //check tids
    if($tids){
        $db_or->condition('ca.field_category_tid',$tids,'in');
    }else{
        $db_or->condition('ca.field_category_tid',$tid,'=');
    }
    $query->condition($db_or);

    //check tids
    if($tids){
        $query->condition('ca.field_category_tid',$tids,'in');
    }else{
        $query->condition('ca.field_category_tid',$tid,'=');
    }
    $query->condition('n.type','article');
    $query->condition('n.status',1);
    $query->range($page_num,$page_size);
    $query->orderBy('n.created','DESC');
    $result = $query->execute()->fetchAllAssoc('nid');

    $data = array();
    if($result){
        foreach($result as $n){
            $data[] = node_load($n->nid);
        }
        print (render(theme('post_list_pager',array('nodes'=>$data))));
        drupal_exit();
    }else{
        print 'ko';
        drupal_exit();
    }
}


function artline_get_my_post($page_num=0, $page_size=8){
    global $user;
    $query = db_select('node','n');
    $query->fields('n');

    $query->condition('type','article');
    $query->condition('uid',$user->uid);
    $query->range($page_num,$page_size);
    $query->orderBy('created','DESC');
    $result = $query->execute()->fetchAllAssoc('nid');
    $data = array();
    if($result){
        foreach($result as $n){
            $data[] = node_load($n->nid);
        }
        return theme('post_list',array('nodes'=>$data));
    }else{
        return false;
    }
}

function artline_get_my_post_pager(){
    $page_num=0;
    $page_size=8;
    global $user;
    if($_POST['page_num']){
        $page_num = $page_size * $_POST['page_num'];
    }
    $query = db_select('node','n');
    $query->fields('n');
    $query->condition('uid', $user->uid , '=');
    $query->condition('type','article');
    $query->range($page_num,$page_size);
    $query->orderBy('created','DESC');
    $result = $query->execute()->fetchAllAssoc('nid');

    $data = array();
    if($result){
        foreach($result as $n){
            $data[] = node_load($n->nid);
        }
        print (render(theme('post_list_pager',array('nodes'=>$data))));
        drupal_exit();
    }else{
        print 'ko';
        drupal_exit();
    }
}

function _post_list_detail($node){
    return theme('post_list_detail',array('node'=>$node));
}