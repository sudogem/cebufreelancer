<?php
$this->form_validation->set_rules('profile[fullname]', 'Fullname', 'trim|required|min_length[4]|max_length[50]') ;
$this->form_validation->set_rules('profile[location]', 'Address', 'trim|required') ;
$this->form_validation->set_rules('profile[job_objective]', 'Summary', 'trim|required') ;
$this->form_validation->set_rules('profile[specialties]', 'Specialties', 'trim|required') ;
$this->form_validation->set_rules('profile[company]', 'Company', 'trim|max_length[100]') ;
$this->form_validation->set_rules('profile[email]', 'Email', 'trim|required|valid_email') ;
$this->form_validation->set_rules('profile[gender]', 'Gender', 'trim|required|max_length[11]') ;

$this->form_validation->set_rules('workexperience[company][]', 'Company name', 'trim') ;
$this->form_validation->set_rules('workexperience[jobtitle][]', 'Job title', 'trim') ;
// $this->form_validation->set_rules('workexperience[jobdetails][]', 'Work exp. job details', 'trim|required') ;

