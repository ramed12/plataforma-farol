<?php


if ( ! function_exists('Graficos'))
{
	function Graficos($id = null)
	{
        return "
        <option value='1'". ($id == 1 ? "selected" : '')."> Colunas </option>
        <option value='2'". ($id == 2 ? "selected" : '')."> Linha </option>
        <option value='3'". ($id == 3 ? "selected" : '')."> Pizza </option>
        <option value='4'". ($id == 4 ? "selected" : '')."> Radar </option>
        <option value='5'". ($id == 5 ? "selected" : '')."> Por área</option>";
	}
}

