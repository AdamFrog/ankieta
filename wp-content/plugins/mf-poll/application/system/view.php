<?php

class MFPView{

	public static $path = null;
	
	public static function get($name, array $param = array()){

		if(!is_array($param)){
			return 'Brak parametrów';
		}

		extract($param);

		return include(MFPPATH . '/view/' . $name . '.php');

	}

	public static function render($name, array $param = array())
	{
	    // Import the view variables to local namespace
	    extract($param, EXTR_SKIP);
	 
	    // Capture the view output
	    ob_start();
	 
	    try
	    {
	        // Load the view within the current scope
	        include MFPPATH . '/view/' . $name . '.php';
	    }
	    catch (Exception $e)
	    {
	        // Delete the output buffer
	        ob_end_clean();
	 
	        // Re-throw the exception
	        throw $e;
	    }
	 
	    // Get the captured output and close the buffer
	    return ob_get_clean();
	}
}