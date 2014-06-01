<?php

/** 
 * LICENSE: ##LICENSE##
 * 
 * @category   Anahita
 * @package    Com_Hashtags
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @copyright  2008 - 2014 rmdStudio Inc.
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.anahitapolis.com
 */

/**
 * Hashtag Router
 * 
 * @category   Anahita
 * @package    Com_Hashtags
 */
class ComHashtagsRouter extends ComBaseRouterDefault
{
    /**
     * Parse the segments of a URL.
     *
     * @param   array   The segments of the URL to parse.
     * @return  array   The URL attributes to be used by the application.
     */
    public function parse(&$segments)
    {	
    	$vars = array();
    	
    	if(empty($segments)) 
    	{
            $vars['view'] = $this->getIdentifier()->package;
        }
        else if ( count($segments) == 1 ) 
        {
	    	$identifier = array_pop($segments);

	    	if(is_numeric($identifier))
	    	{
	    		$vars['id'] = (int) $identifier;
	    	}
	 		else 
	 		{
	 			$hashtag = KService::get('com://site/hashtags.domain.entity.hashtag')->getRepository()->fetch(array('alias'=>$identifier));
	    		$vars['id'] = $hashtag->id;
	 		}

	 		$vars['view'] = KInflector::singularize($this->getIdentifier()->package);
    	}
 			
    	return $vars;
    }
    
    /**
     * Build the route
     *
     * @param   array   An array of URL arguments
     * @return  array   The URL arguments to use to assemble the subsequent URL.
     */
    public function build(&$query)
    {
    	$segments = array();
    	
    	if(isset($query['view']) && !KInflector::isPlural($query['view']))
    	{
    		unset($query['view']);
    	}
    	
		if(isset($query['id']))
    		unset($query['id']);
    	
    	if(isset($query['alias']))
    	{
    		$segments[] = $query['alias'];
    		unset($query['alias']);
    	}
    	
    	
    	return $segments;
    }
}