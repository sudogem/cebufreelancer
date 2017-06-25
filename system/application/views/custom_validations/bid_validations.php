<?php
$rules['amount'] = 'trim|required|max_lenght[8]' ;
$rules['delivery_within'] = 'trim|required|numeric';
$rules['message'] = 'trim|max_lenght[199]' ;
$this->validation->set_rules( $rules ) ; 
$fields['amount'] = 'bid amount' ;
$fields['message'] = 'message' ;
$fields['delivery_within'] = 'delivery days' ;
$this->validation->set_fields( $fields ) ;
?>