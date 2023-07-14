<?php


if ( ! function_exists('GrupoUser'))
{
	function GrupoUser($id)
	{
        $grupos = \DB::table('grupo_users')
        ->whereJsonContains('users', ["{$id}"])
    ->get();

        if($grupos->isEmpty()){
            return "<div class='aler alert-warning'> em nenhum grupo </div>";
        }
        foreach(json_decode($grupos, true) as $row){
            return $row['name'];
        }
	}
}

