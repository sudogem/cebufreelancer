<?php
$rules['username'] = 'trim|required|min_length[4]|max_length[20]|callback_username_checkforavailability|alpha_numeric' ;
$rules['fullname'] = 'trim|required|min_length[4]|max_length[20]' ;
$rules['password'] = 'trim|required|min_length[4]|max_length[255]|callback_password_check' ;
$rules['seccode'] = 'required|callback_captcha_check' ;
$rules['email'] = 'trim|required|valid_email|callback_email_check' ;
$this->validation->set_rules( $rules ) ;
$fields['fullname'] = 'fullname' ; 
$fields['seccode'] = 'verification code' ; 
$this->validation->set_fields( $fields ) ;
?>