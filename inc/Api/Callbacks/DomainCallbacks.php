<?php
/**
 * @package stgsuiteapp
 * 
 * */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class DomainCallbacks extends BaseController
{

     public function adminSectionManager()
    {
        echo 'Add/Manage Gsuite App Domains';
    }
    
    public function  inputsanitizations( $input )
    {   
        
        $output = get_option('stgsuiteapp_dashbaord');
        /**
         * Creating a domain direcotry same as domain name
         * */
        $dirname = substr($input['domain_name'], 0, strpos($input['domain_name'], '.'));
        $dir = get_stylesheet_directory().'/'.$dirname.'/';
        if ( !is_dir( $dir ) ) {
                mkdir( $dir );       
        }
        /**
         * Uplaoding Quick Start file
         * */
        if( $_FILES['quickstart_file']['name'] != null ){
            $file_ext = strtolower(pathinfo($_FILES["quickstart_file"]["name"],PATHINFO_EXTENSION));
            if($file_ext === 'php')
            {
                $target_file = $dir.'/quickstart.'.$file_ext;
                move_uploaded_file($_FILES["quickstart_file"]["tmp_name"], $target_file);
            }    
        }
        
        /**
         * Uploading Token sJson File
         * */
        if( $_FILES['credentailsjson_file']['name'] != null ){
            $file_ext = strtolower(pathinfo($_FILES["credentailsjson_file"]["name"],PATHINFO_EXTENSION));
            if($file_ext === 'json')
            {
                $target_file = $dir.'/credentails.'.$file_ext;
                move_uploaded_file($_FILES["credentailsjson_file"]["tmp_name"], $target_file);
            }    
        }

        if(! empty($output)){
           foreach ( $output as $key => $value ) {

                if( $input['domain_name'] === $key )
                {
                    $output[$key] = $input;
                }
                else
                {
                    $output[$input['domain_name']] = $input;
                }
            }     
        }
        else
        {
            $output[$input['domain_name']] = $input;
        } 
        return $output;
    }

   

    public function textField( $args )
    {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
        // $value = (isset($input[$name]) ? ($input[$name] ? $input[$name] : '' ) : '');

        echo '<input type="text" class="regular-text" id="'.$name.'" name="' .$option_name. '[' .$name .']'.'" placeholder="' .$args[ 'placeholder' ]. '" >';

    }

    public function fileUpload( $args )
    {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );

        echo '<input type="file" class="regular-text" id="'.$name.'" name="' .$name .'" ><span>Exntentions allowed ( '. $args['extentions'] .' )</span>';
    }

}