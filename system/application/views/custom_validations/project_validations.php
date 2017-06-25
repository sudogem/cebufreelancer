<?php
$rules['title'] = 'trim|required|xss_clean' ;
$rules['description'] = 'trim|required|min_length[20]|xss_clean' ; 
$rules['budget'] = 'trim|required|min_length[2]|max_length[12]|xss_clean' ; 
$rules['payment_detail'] = 'trim|min_length[3]|xss_clean' ;
$rules['duration'] = 'trim|required|max_length[255]|xss_clean' ;  
$rules['category'] = 'required|isset' ;
$this->validation->set_rules( $rules ) ; 

$fields['title'] = 'project title' ;
$fields['description'] = 'description' ;
$fields['budget'] = 'budget' ;
$fields['payment_detail'] = 'payment detail' ;
$fields['numofdays'] = 'number of days' ;
$fields['duration'] = 'deadline' ;
$fields['category'] = 'job type' ;
$fields['duration'] = 'duration/deadline' ;
$this->validation->set_fields( $fields ) ;
?>