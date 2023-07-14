<?php

if ( ! function_exists('Anos'))
{
	function Anos()
	{
        $array = [];
        for ($i = 2021; $i <= date('Y'); $i++) {
            array_push($array, $i);
        }

        return $array;

	}
}

