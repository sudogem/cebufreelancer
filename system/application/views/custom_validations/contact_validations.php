<?php
$this->form_validation->set_rules('subject', 'Subject', 'trim|required') ;
$this->form_validation->set_rules('message', 'Message', 'trim|required') ;
$this->form_validation->set_rules('seccode', 'Verification code', 'required|callback_captcha_check') ;
