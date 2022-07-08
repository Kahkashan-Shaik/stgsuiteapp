<?php /* Template Name: Gsuite Account Managment Template */?>

<?php 

get_header(); 
// nectar_page_header($post->ID); 

//full page$choice

// $fp_options = nectar_get_full_page_options();
// extract($fp_options);
$check = get_query_var('entry-id', 0);
if($check){
    
?>

<div class="container-wrap" style="padding: 100px">
    <?php
       
    
        $entry_id = get_query_var('entry-id', 0);
        // echo "<p>". "entry_id ", $entry_id . "</p>";
        
        $lead = RGFormsModel::get_lead( $entry_id );

        $domain = explode("@", $lead["5"]);
        $domain = strtolower($domain[1]);

        $domain_dirname =  (explode(".", (explode("@", $lead["5"])[1])));
        // print_r($domain_dirname);
        // echo $lead["5"];
        $domain_dirname = strtolower($domain_dirname[0]);

        // echo $domain_dirname;

        $token_file_in_json = file_get_contents(get_stylesheet_directory().'/'.$domain_dirname.'/token.json');
        $token_file = json_decode($token_file_in_json);
        // echo "<p> access_token ". $token_file->access_token . "</p>";
        // echo get_stylesheet_directory().'/'.$domain_dirname;
        
        $choice = $lead["1"]; //Change these values base on id of the form fields
        // echo "<p>". "choice ", $choice . "<p>";
        
        $add_to_group = $lead["7.1"];
        // echo "<p>". "add to group value ", $add_to_group . "<p>";
        
        $first_name = $lead["2.3"]; //Change these values base on id of the form fields
        // echo "<p>". "first_name ", $first_name . "</p>";
        
        $last_name = $lead["2.6"]; //Change these values base on id of the form fields
        // echo "<p>". "last_name ", $last_name. "</p>";
        
        $email = $lead["4"] . $lead["5"]; ////Change these values base on id of the form fields
        // echo "<p>". "email ", $email, "\n" . "</p>";
        // here lead[4] is email address provided by client & lead[5] is domain provided by us.
        
        $password = $lead["6"]; //Change these values base on id of the form fields
        // echo "<p>". "password ", $password . "<p>";
    
    
          if($choice == "Create Account"){
                $url = 'https://www.googleapis.com/admin/directory/v1/users?domain='.$domain.'&access_token='. $token_file->access_token;
                // echo "<p>". "Create Account Section ". "<p>";
                
                $array_with_parameters = array(
                	"name"=> array(
                		"familyName" => $last_name, 
                		"givenName" => $first_name
                		), 
                	"password" => $password, 
                	"primaryEmail" =>  $email
                	);
                	
                // print_r($array_with_parameters);
                
                $remote_post_array = wp_remote_post($url, array(
                    'headers'     => 
                    array(
                        'Content-Type' => 'application/json; charset=utf-8', 
                    ),
                    'body'        => json_encode($array_with_parameters),
                    'method' => 'POST',
                    'data' => 'body',
                    'timeout'     => 45,
                    'sslverify'   => false,
                ));            
                
                $returned_body = json_decode(wp_remote_retrieve_body($remote_post_array));
                // print_r($returned_body);
                
                // if($returned_body->error->message){
                if(is_wp_error($returned_body)){
                	echo "<p>An error has occurred please read the error message, if you don't understand it Contact the Site Administrator</p>";
                	echo "<p> Error Message: ", $returned_body->error->message, "</p>";
                	
                }
                elseif ($returned_body->primaryEmail){
                	echo "<p>The Following account has been Created, below are the following details that are registered</p>";
                	echo "<p>Email: ", $returned_body->primaryEmail, "</p>";
                	echo "<p>Name: ", $returned_body->name->givenName, " ", $returned_body->name->familyName, "</p>";
                }
        }
        elseif($choice == "Account Password Reset"){
                // echo "<p>". "Account Password Reset Section ". "<p>";
                
            	$url = 'https://www.googleapis.com/admin/directory/v1/users/'. $email. '?access_token='. $token_file->access_token;
                $array_with_parameters = array(
                		"password" => $password,
                );
	
                $remote_post_array = wp_remote_request($url, array(
                    'headers'     => 
                	array(
                		'Content-Type' => 'application/json; charset=utf-8', 
                	),
                    'body'        => json_encode($array_with_parameters),
                    'method' => 'PUT',
                    'data' => 'body',
                	'timeout'     => 45,
                    'sslverify'   => false,
                ));
            	$returned_body = json_decode(wp_remote_retrieve_body($remote_post_array));
                if(is_wp_error($returned_body)){
                	echo "<p>An error has occurred please read the error message, if you don't understand it Contact the Site Administrator</p>";
                	echo "<p> Error Message: ", $returned_body->error->message, "</p>";
                }
                elseif ($returned_body->primaryEmail){
                	echo "<p>The Following account password has been reset, below are the following details of the user</p>";
                	echo "<p>Email: ", $returned_body->primaryEmail, "</p>";
                	echo "<p>Name: ", $returned_body->name->givenName, " ", $returned_body->name->familyName, "</p>";
                }
        }
        elseif($choice == "Add User to group"){
                // echo "<p>". "Add User to group ". "<p>";
                
                $url = 'https://admin.googleapis.com/admin/directory/v1/groups/all@'.$domain.'/members?access_token='. $token_file->access_token;
                
                $array_with_parameters = array(
                	"email" =>  $email,
                	"role" => "MEMBER"
                );
                
                $remote_post_array = wp_remote_post($url, array(
                    'headers'     => 
                    	array(
                    		'Content-Type' => 'application/json; charset=utf-8', 
                    	),
                    'body'      => json_encode($array_with_parameters),
                    'method'    => 'POST',
                    'data'      => 'body',
                	'timeout'   => 45,
                    'sslverify' => false,
                ));
                
                $returned_body = json_decode(wp_remote_retrieve_body($remote_post_array));
                // print_r($returned_body);
                
                if(is_wp_error($returned_body)){
                	echo "<p>An error has occurred please read the error message, if you don't understand it Contact the Site Administrator</p>";
                	echo "<p> Error Message: ", $returned_body->error->message, "</p>";
                }
                elseif ($returned_body->email){
                	echo "<p>The Following account has been added to the group all@".$domain.", below are the following details of the user added to the group</p>";
                	echo "<p>Email: ", $returned_body->email, "</p>";
                	echo "<p>Role: ", $returned_body->role, "</p>";
                }
        }
	
		elseif($choice == "Remove Member from Group all@".$domain){
                // echo "<p>". "Add User to group ". "<p>";
                
                $url = 'https://admin.googleapis.com/admin/directory/v1/groups/all@'.$domain.'/members/'. $email .'?access_token='. $token_file->access_token;
                
                $remote_post_array = wp_remote_request($url, array(
                    'headers'     => 
                    	array(
                    		'Content-Type' => 'application/json; charset=utf-8', 
                    	),
					'body' => '',
                    'method'    => 'DELETE',
                    'data'      => 'body',
                	'timeout'   => 45,
                    'sslverify' => false,
                ));
				
				$returned_header = wp_remote_retrieve_header($remote_post_array, "headers");
				$returned_body = json_decode(wp_remote_retrieve_body($remote_post_array));
				
// 				echo "response email ", $email;
// 				echo "<pre>";
				$response_code = wp_remote_retrieve_response_code($remote_post_array);
// 				var_export(wp_remote_retrieve_response_code($remote_post_array));
// 				echo "</pre>";
			
// 				echo "returned header ", "<pre>";
// 				var_export($returned_header);
// 				echo "returned header ended", "</pre>";
                
                if(is_wp_error($returned_body)){
                	echo "<p>An error has occurred please read the error message, if you don't understand it Contact the Site Administrator</p>";
                	echo "<p> Error Message: ", $returned_body->error->message, "</p>";
                }
				elseif($response_code == 204){
                	echo "<p>The account ". $email." has been removed from the group all@".$domain."</p>";
                }
        }
	
        elseif($choice == "Rename User"){
                // echo "<p>". "Rename User Section ". "<p>";
                
            	$url = 'https://www.googleapis.com/admin/directory/v1/users/'. $email. '?access_token='. $token_file->access_token;
                $array_with_parameters = array(
                		"name"=> array(
                		"familyName" => $last_name, 
                		"givenName" => $first_name
                		)
                );
	
                $remote_post_array = wp_remote_request($url, array(
                    'headers'     => 
                	array(
                		'Content-Type' => 'application/json; charset=utf-8', 
                	),
                    'body'        => json_encode($array_with_parameters),
                    'method' => 'PUT',
                    'data' => 'body',
                	'timeout'     => 45,
                    'sslverify'   => false,
                ));
            	$returned_body = json_decode(wp_remote_retrieve_body($remote_post_array));
                if(is_wp_error($returned_body)){
                	echo "<p>An error has occurred please read the error message, if you don't understand it Contact the Site Administrator</p>";
                	echo "<p> Error Message: ", $returned_body->error->message, "</p>";
                }
                elseif ($returned_body->primaryEmail){
                	echo "<p>The Following User has been renamed, below are the following details of the user</p>";
                	echo "<p>Email: ", $returned_body->primaryEmail, "</p>";
                	echo "<p>Name: ", $returned_body->name->givenName, " ", $returned_body->name->familyName, "</p>";
                }
        }
        elseif($choice == "Delete User"){
                // echo "<p>". "Delete User ". "<p>";
                
                $url = 'https://admin.googleapis.com/admin/directory/v1/users/'. $email. '?access_token='. $token_file->access_token;
                
                // $array_with_parameters = array();
                
                $remote_post_array = wp_remote_request($url, array(
                    'headers'     => 
                    	array(
                    		'Content-Type' => 'application/json; charset=utf-8', 
                    	),
                    'body'      => "",
                    'method'    => 'DELETE',
                    'data'      => 'body',
                	'timeout'   => 45,
                    'sslverify' => false,
                ));
                
                $returned_body = json_decode(wp_remote_retrieve_body($remote_post_array));
                // print_r($returned_body);
                
                if(is_wp_error($returned_body)){
                	echo "<p>An error has occurred please read the error message, if you don't understand it Contact the Site Administrator</p>";
                	echo "<p> Error Message: ", $returned_body->error->message, "</p>";
                }
                else{
                	echo "<p>The User account ". $email ." has been deleted </p>";
                }
        }
        elseif($choice == "View All"){
            $url = 'https://admin.googleapis.com/admin/directory/v1/users?domain='.$domain.'&maxResults=500&access_token='. $token_file->access_token;
            // $url = 'https://admin.googleapis.com/admin/directory/v1/users?domain='.$domain.'&maxResults=500&access_token=ya29.a0ARrdaM_5TgPkx0c-In5cD5RxvYDJ8SOEPL5N_BK3ia73vxxeU5fqNVmbS0Dm2QiNrtU4Gfn6eD24rhcQEzPk4ETarCMlY3luwBYChKDIv_Lbyt3guWOZWkZwSFV1clP89bS59QEbgl7iB-yLfzl2WU4qQ-NK';
            $remote_post_array = wp_remote_get($url, array(
                    'headers'     => 
                    	array(
                    		'Content-Type' => 'application/json; charset=utf-8', 
                    	
                    	),
                    'body'      => "",
                    'method'    => 'GET',
                    'data'      => 'body',
                	'timeout'   => 45,
                    'sslverify' => false,
                ));
                
            $returned_body = json_decode(wp_remote_retrieve_body($remote_post_array));
            
            if(is_wp_error($returned_body)){
                    echo $token_file->access_token;
                	echo "<p>An error has occurred please read the error message, if you don't understand it Contact the Site Administrators</p>";
                	echo "<p> Error Message: ", $returned_body->error->message, "</p>";
            }
            else{
                echo "<h1 style='text-align:center'> Users </h1> ";
                
                echo "<div class='users'>";?>
                <style>
                    .users{
                        display: flex;
                        flex-wrap: wrap;
                        gap: 30px;
                        margin-top: 30px;
                        justify-content: center
                    }
                    .user{
                        width: 30%;
                        border-radius: 10px;
                        padding: 30px;
                        text-align: center;
                        box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 50px;
                    }
                    .button{
                        width: 30%;
                        margin-top: 100px !important;
                        border-radius: 10px;
                        padding: 30px;
                        text-align: center;
                    }
                    @media only screen and (max-width: 980px){
                        .user,.button{
                            width: 45%;
                        }
                    }
                    @media only screen and (max-width: 768px){
                        .user,.button{
                            width: 100%;
                        }
                    }
                    
                </style>
                
                <?php
                foreach($returned_body->users as $user){
                    echo "<div class='user'>";
                    echo "<p> ". $user->name->fullName ."</p>";
                    echo "<p> ". $user->primaryEmail ."</p>";
                    echo "</div>";
                }
                echo "</div>";
                
            }
        }
        
        //check if add user to group checkbox is selected and add the user
        if($add_to_group == "Add User to Group all@".$domain){
                // echo "<p>". "Add User to group ". "<p>";
                
                $url = 'https://admin.googleapis.com/admin/directory/v1/groups/all@'.$domain.'/members?access_token='. $token_file->access_token;
                
                $array_with_parameters = array(
                	"email" =>  $email,
                	"role" => "MEMBER"
                );
                
                $remote_post_array = wp_remote_post($url, array(
                    'headers'     => 
                    	array(
                    		'Content-Type' => 'application/json; charset=utf-8', 
                    	),
                    'body'      => json_encode($array_with_parameters),
                    'method'    => 'POST',
                    'data'      => 'body',
                	'timeout'   => 45,
                    'sslverify' => false,
                ));
                
                $returned_body = json_decode(wp_remote_retrieve_body($remote_post_array));
                // print_r($returned_body);
                
                if(is_wp_error($returned_body)){
                	echo "<p>An error has occurred please read the error message, if you don't understand it Contact the Site Administrator</p>";
                	echo "<p> Error Message: ", $returned_body->error->message, "</p>";
                }
                elseif ($returned_body->email){
                	echo "<p>The Following account has been added to the group all@".$domain.", below are the following details of the user added to the group</p>";
                	echo "<p>Email: ", $returned_body->email, "</p>";
                	echo "<p>Role: ", $returned_body->role, "</p>";
                }
        }        


    ?>
    <div class="button">
        <p style="text-align:center !important;"><a style="background-color: red;color: #fff; border:1px solid #fff; text-align:center;padding: 15px 22px;cursor:pointer;margin-top: 20px !important;" href="https://gsuite.standardtouch.com/gsuite-app/">Click Go Back</a></p>
    </div>
</div>
  

<?php 
}
else
{
    header("Location: https://gsuite.standardtouch.com/gsuite-app/");
}
get_footer(); ?>