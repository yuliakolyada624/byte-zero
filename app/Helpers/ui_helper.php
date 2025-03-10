<?php

/* Indenting a tree element based on its depth */
function UiHelperMakeTreeIndent($string){
	$pattern = "%{([0-9]{1,20}+)}%is";
	preg_match($pattern, $string, $matches);
	if ($matches){
		$count = $matches[1];
		($count > 1) ? $width = ((($count-2)*18)+12) : $width = 0;
		$indent = '<div style="width: '.$width.'px;" class="tree-node">&nbsp;</div>';
		$res = preg_replace($pattern, '', $indent.$string);
	} 
	else
	{
		$res = $string;
	}
	return $res;
}

/* Padding a tree element based on its depth for a select form element */
function UiHelperMakeTreeIndentForSelect($string)
{
	$pattern = "%{([0-9]{1,20}+)}%is";
	preg_match($pattern, $string, $matches);
	if ($matches){
		$count = $matches[1];
			$indent = '';
			for($i = 1; $i < $count; $i++)
			{
				$indent .= "&mdash;";
			}
		$res = preg_replace($pattern, '', $indent." ".$string);
	} 
	else
	{
		$res = $string;
	}
	return $res;
}