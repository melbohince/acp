<?php
  // log_message('error', 'form_validation called');
  $config = array(
                 'login' => array(
                                    array(
                                            'field' => 'username',
                                            'label' => 'Username',
                                            'rules' => 'trim|required|min_length[3]|max_length[25]|xss_clean'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'Password',
                                            'rules' => 'trim|required|min_length[3]|max_length[16]'
                                         )
                                    ),
  
                 'lookup_cpn' => array(
                                    array(
                                            'field' => 'product_code',
                                            'label' => 'Product Code',
                                            'rules' => 'trim|required|min_length[2]|max_length[20]'
                                         )
                                    ),
	
                 'lookup_line' => array(
                                    array(
                                            'field' => 'product_line',
                                            'label' => 'Product Line',
                                            'rules' => 'trim|required|min_length[2]|max_length[20]'
                                         )
                                    ),
                                    
                 'lookup_order' => array(
                                    array(
                                            'field' => 'po_number',
                                            'label' => 'Purchase Order',
                                            'rules' => 'trim|required|min_length[2]|max_length[30]'
                                         )
                                    ),
                                    
                'lookup_desc' => array(
                                    array(
                                            'field' => 'product_desc',
                                            'label' => 'Product Description',
                                            'rules' => 'trim|required|min_length[2]|max_length[80]'
                                         )
                                    ),
                                    
                'lookup_cpn_by_shipto' => array(
                                    array(
                                            'field' => 'shipto',
                                            'label' => 'ShipTo City',
                                            'rules' => 'trim'
                                         )
                                    ),
                                    
                 'update_user' => array(
                                    array(
                                            'field' => 'username',
                                            'label' => 'User Name',
                                            'rules' => 'trim|required|min_length[2]|max_length[20]'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'Password',
                                            'rules' => 'trim|required|min_length[3]|max_length[16]|matches[passwordcf]'
                                         ),
                                    array(
                                            'field' => 'passwordcf',
                                            'label' => 'Confirm Password',
                                            'rules' => 'trim|required|min_length[3]|max_length[16]'
                                         ),
                                    array(
                                            'field' => 'email',
                                            'label' => 'Email Address',
                                            'rules' => 'trim|required|min_length[7]|max_length[128]|valid_email'
                                         ),
                                    array(
                                            'field' => 'access_filter',
                                            'label' => 'Access Filter',
                                            'rules' => 'trim|required|numeric|exact_length[5]'
                                         ),
                                    array(
                                            'field' => 'admin_indicator',
                                            'label' => 'Administrator Indicator',
                                            'rules' => 'trim|required|integer|min_length[1]|max_length[1]'
                                         )
                                    ),

                 'change_password' => array(
                                    array(
                                            'field' => 'password',
                                            'label' => 'Password',
                                            'rules' => 'trim|required|min_length[6]|max_length[16]'
                                         ),
                                    array(
                                            'field' => 'new_password',
                                            'label' => 'New Password',
                                            'rules' => 'trim|required|min_length[6]|max_length[16]|matches[passwordcf]'
                                         ),
                                    array(
                                            'field' => 'passwordcf',
                                            'label' => 'Confirm Password',
                                            'rules' => 'trim|required|min_length[6]|max_length[16]'
                                         ),
                                    ),
                                    
                 'email_message' => array(
                                            array(
                                                    'field' => 'subject',
                                                    'label' => 'Subject',
                                                    'rules' => 'trim|required|min_length[5]|max_length[40]'
                                                 ),
                                            array(
                                                    'field' => 'body',
                                                    'label' => 'Message Body',
                                                    'rules' => 'trim|required|min_length[1]|max_length[255]'
                                                 )
                                    ),
                                    
                'pallet_lookup' => array(
                                           array(
                                                      'field' => 'pallet_id',
                                                      'label' => 'Pallet',
                                                      'rules' => 'trim|required|integer|min_length[20]|max_length[22]'
                                                 ),

                                         ),
                                         
                 'update_pallet' => array(
                                            array(
                                                    'field' => 'pallet_id',
                                                    'label' => 'Pallet ID',
                                                    'rules' => 'trim|required|min_length[20]|max_length[30]'
                                                 ),
                                            array(
                                                    'field' => 'date_received',
                                                    'label' => 'Date Received',
                                                    'rules' => 'trim'
                                                 ),
                                            array(
                                                    'field' => 'date_issued',
                                                    'label' => 'Date Issued',
                                                    'rules' => 'trim'
                                                 )
                                    ),                                         
                                         
                                         
               );
               
?>