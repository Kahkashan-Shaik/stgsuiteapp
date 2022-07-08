<?php
/**
 * @package stgsuiteapp
 * 
 * */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class SettingsCallbacks extends BaseController
{

    public function inputsanitizations( $input )
    {

        $frompath = 'http://localhost/sunrise/wp-content/uploads/2022/06/gsuitephpclient.zip';
        $topath = get_stylesheet_directory().'/';
        $unzip_file = unzip_file( $frompath, $topath );
        if( !is_wp_error($unzip_file) )
        {
            update_option( 'stgsuiteapp_settings', array( 'status', true ) );
        }
        else
        {
            update_option( 'stgsuiteapp_settings', array( 'status', false ) );
            return $unzip_file;
        }
        return $input;

        /**
         * Uplaoding Quick Start file
         * */
        // if( $_FILES['gsuiteapp_zipfile']['name'] != null ){
        //     $dir = get_stylesheet_directory();
        //     $file_ext = strtolower(pathinfo($_FILES["gsuiteapp_zipfile"]["name"],PATHINFO_EXTENSION));
        //     if($file_ext === 'zip')
        //     {
        //         $target_file = $dir.'/gsuitephpclient.'.$file_ext;
        //         if( move_uploaded_file($_FILES["gsuiteapp_zipfile"]["tmp_name"], $target_file) )
        //         {
                        // update_option( 'stgsuiteapp_settings', array( 'status', true ) );
        //         }
        //         else
        //         {
        //             update_option( 'stgsuiteapp_settings', array( 'status', false ) );
        //         }
        //     }    
        // }

       
    }

    public function adminSectionManager()
    {
        echo 'Manage Gsuite App Settings Status';
    }

    public function textField( $args )
    {

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );

        echo '<input type="text" class="regular-text" id="'.$name.'" name="'.$option_name. '['.$name .']'.'" placeholder=" '.$args['placeholder'].' "><span>Exntentions allowed ( '. $args['extentions'] .' )</span>';

    }


    // public function fileUpload( $args )
    // {
    //     $name = $args['label_for'];
    //     $option_name = $args['option_name'];
    //     $input = get_option( $option_name );

        
    //     echo '<input type="file" class="regular-text" id="'.$name.'" name="' .$name .'" ><span>Exntentions allowed ( '. $args['extentions'] .' )</span>';
    // }

    // public function textField( $args )
    // {
    //     $name = $args['label_for'];
    //     $option_name = $args['option_name'];
    //     $input = get_option( $option_name );

    //     echo '<input type="hidden" class="regular-text" id="'.$name.'" name="' .$option_name. '[' .$name .']'.'" value="1">';
    // }

}