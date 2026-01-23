<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
Use Exception;

trait Common {

    public function getUrl($path)
    {
        $url = "";
        if( !empty($path) && Storage::disk('public')->exists($path) )
            $url = Storage::url($path);
        return $url;
    }

    /*********Menu Links***********/
    public function menulinks()
    {
        $links = array();
        $menulinks = \DB::table('menu_links')
                        ->select('*')
                        ->where('status', 1)
                        ->orderBy('position', 'ASC')
                        ->get();
                        
        foreach($menulinks as $eachmenu){ 
                if(0 == $eachmenu->parentid){
                    $links[$eachmenu->id] = $eachmenu;
                    $links[$eachmenu->id]->child = null; 
                }else
                    $links[$eachmenu->parentid]->child[] = $eachmenu; 

        }
        return $links;            
    }
    /*******************************/

    /*********Role Access Links***********/

    public function getRolesCapableLinks($role_id)
    {
        $rights = null;
        
        $access = \DB::table('role_has_links')->select('link_id')
                                            ->where('role_id', $role_id)
                                            ->get();
        if($access->isNotEmpty()){
            foreach($access as $eacacc){
                $rights[] =  $eacacc->link_id;
            }
        }     
        
        return $rights;
    }

    /*******************************/

    

}