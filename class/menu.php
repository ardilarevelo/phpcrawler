<?php

// No direct access
defined('_DIACCESS') or die;

// Class to manage the admin menu
class menu{
    
    // Define options to show the specific content
    public static function get(){
        $admin_menu = array();
        
        // Process URL
        $admin_menu[] = array('name' => 'Web crawler'
            ,'description' => 'Web crawler from given website'
            ,'class' => 'fa-list-alt'
            ,'panel_class' => 'panel-success'
            ,'panel_call' => 'Set the URL'
            ,'panel_attributes' => ' data-toggle="modal" data-target="#myModal"'
            ,'panel_url' => '/crawler'
            ,'submenu' => array(
                array('name' => 'Scan URL'
                    ,'class' => 'fa-child'
                    ,'url' => '/crawler'
                    ,'url_attributes' => ' data-toggle="modal" data-target="#myModal"'
                )
                ,array('name' => 'View Results'
                    ,'class' => 'fa-cubes'
                    ,'url' => '/crawler/results'
                )
            )
        );
        
        // Profile
        $admin_menu[] = array('name' => 'Profile'
            ,'description' => 'Daniel Ardila profile'
            ,'class' => 'fa-user'
            ,'panel_class' => 'panel-warning'
            ,'panel_call' => 'See profile'
            ,'panel_url' => '/profile'
            ,'url' => '/profile'
        );
        
        return $admin_menu;
    }
}

