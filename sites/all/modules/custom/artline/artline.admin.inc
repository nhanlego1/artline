<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 11/2/16
 * Time: 11:13 PM
 */
function artline_admin(){
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
    $form['cndk']['logo_cndk'] = array(
        '#type'=>'managed_file',
        '#title' => 'Upload Logo đăng ký',
        '#upload_location' => 'public://',
        '#default_value' => variable_get('logo_cndk')
    );

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
    return system_settings_form($form);
}