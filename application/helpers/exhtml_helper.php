<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('title_tag'))
{
	/**
	 * load head tag
	 *
	 * Generates an HTML heading tag.
	 *
	 * @param	string	content
	 * @param	int	heading level
	 * @param	string
	 * @return	string
	 */
	function title_tag($title = '')
	{
	    if (!empty($title)) {
	        $title = '<title>'.$title.'</title>';
	    } else {
	        $title = '';
	    }
	    return $title."\n";
	}
}

if ( ! function_exists('script_tag'))
{
	/**
	 * load head tag
	 *
	 * Generates an HTML heading tag.
	 *
	 * @param	string	content
	 * @param	int	heading level
	 * @param	string
	 * @return	string
	 */
	function script_tag($src = '')
	{
	   $link = '<script ';

		if (is_array($src))
		{
			foreach ($src as $k => $v)
			{
				if ($k === 'src' && ! preg_match('#^([a-z]+:)?//#i', $v))
				{
					$link .= 'src="'.$v.'" ';
				}
				else
				{
					$link .= $k.'="'.$v.'" ';
				}
			}
		}
		else
		{
			if (preg_match('#^([a-z]+:)?//#i', $src))
			{
				$link .= 'src="'.$src.'" ';
			}
			else
			{
				$link .= 'src="'.$src.'" ';
			}
		}

		return $link."></script>\n";
	}
}


if ( ! function_exists('exlink_tag'))
{
	/**
	 * load head tag
	 *
	 * Generates an HTML heading tag.
	 *
	 * @param	string	content
	 * @param	int	heading level
	 * @param	string
	 * @return	string
	 */
	function exlink_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '')
	{
		$link = '<link ';

		if (is_array($href))
		{
			foreach ($href as $k => $v)
			{
				if ($k === 'href' && ! preg_match('#^([a-z]+:)?//#i', $v))
				{
					$link .= 'href="'.$v.'" ';
				}
				else
				{
					$link .= $k.'="'.$v.'" ';
				}
			}
		}
		else
		{
			if (preg_match('#^([a-z]+:)?//#i', $href))
			{
				$link .= 'href="'.$href.'" ';
			}
			else
			{
				$link .= 'href="'.$href.'" ';
			}

			$link .= 'rel="'.$rel.'" type="'.$type.'" ';

			if ($media !== '')
			{
				$link .= 'media="'.$media.'" ';
			}

			if ($title !== '')
			{
				$link .= 'title="'.$title.'" ';
			}
		}

		return $link."/>\n";
	}
}

?>