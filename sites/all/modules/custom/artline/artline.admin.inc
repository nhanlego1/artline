<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 11/2/16
 * Time: 11:13 PM
 */
function artline_admin($form, &$form_state){
    $form = array();
    $form['footer'] = array(
        '#type'         => 'fieldset',
        '#title'        => t('Quản lý thông tin footer'),
        '#collapsible'  => TRUE,
        '#collapsed'    => FALSE,
    );
    $form['footer']['company_name'] = array(
        '#type'=>'textfield',
        '#title' => 'Tên công ty',
        '#default_value'=>variable_get('company_name'),
    );
    $form['footer']['address'] = array(
        '#type' => 'textfield',
        '#title' => 'Địa chỉ',
        '#default_value'=>variable_get('address'),
    );
    $form['footer']['phone'] = array(
        '#type' => 'textfield',
        '#title' => 'Điện thoại',
        '#default_value'=>variable_get('phone'),
    );
    $form['footer']['fax'] = array(
        '#type' => 'textfield',
        '#title' => 'Fax',
        '#default_value'=>variable_get('fax'),
    );
    $form['footer']['hotline'] = array(
        '#type' => 'textfield',
        '#title' => 'Hotline',
        '#default_value'=>variable_get('hotline'),
    );
    $form['footer']['email_company'] = array(
        '#type' => 'textfield',
        '#title' => 'Email',
        '#default_value'=>variable_get('email_company'),
    );
    $form['social'] = array(
        '#type'         => 'fieldset',
        '#title'        => t('Quản lý thông tin social link'),
        '#collapsible'  => TRUE,
        '#collapsed'    => FALSE,
    );
    $form['social']['facebook_link'] = array(
        '#type' => 'textfield',
        '#title' => 'Facebook Link',
        '#default_value'=>variable_get('facebook_link'),
    );
    $form['social']['facebook_fanpage'] = array(
        '#type' => 'textfield',
        '#title' => 'Facebook Fanpage',
        '#default_value'=>variable_get('facebook_fanpage'),
    );
    $form['social']['google_plus'] = array(
        '#type' => 'textfield',
        '#title' => 'Google plus',
        '#default_value'=>variable_get('google_plus'),
    );

    $form['social']['youtube_link'] = array(
        '#type' => 'textfield',
        '#title' => 'Youtube Link',
        '#default_value'=>variable_get('youtube_link'),
    );

    $form['cndk'] = array(
        '#type'         => 'fieldset',
        '#title'        => t('Quản lý thông tin chứng nhận'),
        '#collapsible'  => TRUE,
        '#collapsed'    => FALSE,
    );
//    $form['cndk']['logo_cndk'] = array(
//        '#type'=>'managed_file',
//        '#title' => 'Upload Logo đăng ký',
//        '#upload_location' => 'public://',
//        '#default_value' => variable_get('logo_cndk')
//    );

    $form['setting'] = array(
        '#type'         => 'fieldset',
        '#title'        => t('Quản lý cấu hình hệ thống'),
        '#collapsible'  => TRUE,
        '#collapsed'    => FALSE,
    );
    $form['setting']['timeline_view'] = array(
        '#type'=>'textfield',
        '#title'=>'Giới hạn thời gian đếm cho partner, store',
        '#default_value'=> variable_get('timeline_view')
    );
    $form['setting']['filter_word'] = array(
        '#type'=>'textarea',
        '#title'=>'Lọc từ khoá tục tỉu',
        '#default_value'=> variable_get('filter_word')
    );

    //set default value

    $form['setting']['xu_like'] = array(
        '#type'=>'textfield',
        '#title'=>'Số điểm khi like',
        '#default_value'=> variable_get('xu_like',10)
    );
    $form['setting']['xu_post'] = array(
        '#type'=>'textfield',
        '#title'=>'Số điểm khi đăng bài',
        '#default_value'=> variable_get('xu_post',20)
    );
    $form['setting']['xu_share_social'] = array(
        '#type'=>'textfield',
        '#title'=>'Số điểm khi share bài',
        '#default_value'=> variable_get('xu_share_social',20)
    );
    $form['setting']['xu_comment'] = array(
        '#type'=>'textfield',
        '#title'=>'Số điểm khi bình luận',
        '#default_value'=> variable_get('xu_comment',20)
    );
    $form['setting']['xu_click'] = array(
        '#type'=>'textfield',
        '#title'=>'Số điểm khi xem bài viết của bạn',
        '#default_value'=> variable_get('xu_click',10)
    );
    $form['setting']['xu_register'] = array(
        '#type'=>'textfield',
        '#title'=>'Số điểm khi đăng ký tài khoản',
        '#default_value'=> variable_get('xu_register',20)
    );
    $form['setting']['xu_friend'] = array(
        '#type'=>'textfield',
        '#title'=>'Số điểm khi giới thiệu bạn bè đăng ký',
        '#default_value'=> variable_get('xu_friend',10)
    );
    $form['setting']['owner_post'] = array(
        '#type'=>'textfield',
        '#title'=>'Số điểm khi tác giả bài post nhận được',
        '#default_value'=> variable_get('owner_post',2)
    );
    $form['setting']['rule_game'] = array(
        '#type'=>'text_format',
        '#title'=>'Thể lệ và nội quy',
        '#default_value'=> variable_get('rule_game')
    );
    $form['setting']['email_processcing'] = array(
        '#type'=>'text_format',
        '#title'=>'',
        '#default_value'=> variable_get('email_processcing')
    );
    $form['setting']['email_compeleted'] = array(
        '#type'=>'text_format',
        '#title'=>'',
        '#default_value'=> variable_get('email_compeleted')
    );
    $form['submit'] = array(
        '#type'=>'submit',
        '#value'=>'Save'
    );
    return $form;
}

function artline_admin_submit($form, &$form_state){
    $data = $form_state['values'];
    variable_set('company_name', $data['company_name']);
    variable_set('address', $data['address']);
    variable_set('phone', $data['phone']);
    variable_set('fax', $data['fax']);
    variable_set('hotline', $data['hotline']);
    variable_set('email_company', $data['email_company']);
    variable_set('facebook_link', $data['facebook_link']);
    variable_set('facebook_fanpage', $data['facebook_fanpage']);
    variable_set('google_plus', $data['google_plus']);
    variable_set('youtube_link', $data['youtube_link']);
    variable_set('timeline_view', $data['timeline_view']);
    variable_set('filter_word', $data['filter_word']);
    variable_set('xu_like', $data['xu_like']);
    variable_set('xu_post', $data['xu_post']);
    variable_set('xu_share_social', $data['xu_share_social']);
    variable_set('xu_comment', $data['xu_comment']);
    variable_set('xu_click', $data['xu_click']);
    variable_set('xu_register', $data['xu_register']);
    variable_set('xu_friend', $data['xu_friend']);
    variable_set('owner_post', $data['owner_post']);
    variable_set('rule_game', $data['rule_game']['value']);
}