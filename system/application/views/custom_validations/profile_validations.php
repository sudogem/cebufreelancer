<?php
$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|min_length[4]|max_length[50]') ;
$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email') ;
// $this->form_validation->set_rules('company', 'company', 'trim|max_length[100]') ;
// $this->form_validation->set_rules('gender', 'gender', 'trim|required|max_length[11]') ;
