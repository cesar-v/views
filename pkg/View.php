<?php namespace CesarV\Views;

use CesarV\Views\Exceptions\NotFound;

class View 
{
    /**
     * Class options.
     * 
     * @var array 
     */
    protected $options = array();
    
    // ---------------------------------------------------------------------------------------------
    
    /**
     * Constructor.
     * 
     * @param array $options See README.md
     * @throws \LogicException If required options are missing.
     */
    public function __construct($options)
    {
        if ( ! array_key_exists('views.dir', $options))
        {
            throw new \LogicException("Must pass 'views.dir' option.");
        }
        
        $this->options = $options;
    }
    
    // ---------------------------------------------------------------------------------------------
    
    /**
     * Render views.
     * 
     * Renders the desired view and passes any variables to it.
     * 
     * @param string $view View path using a 'dot' notation. 
     * I.e. Template.Header => $viewDir/Template/Header.phtml
     * @param array $vars array('var' => 'value') be passed to view as $var = $value
     * @return boolean
     * @throws NotFound If view is not found.
     */
    public function render($view, $vars = array())
    {        
        // Prefixed with an under score to prevent variable name collisions in scope.
        $_file = str_replace('.', '/', $view);
        $_file = $view . '.phtml';
        
        $_file = rtrim($this->options['views.dir'], '/') . '/' . $_file;
        
        if ( ! \file_exists($_file))
        {
            throw new NotFound('View not found - ' . $view);
        }
        unset($view); // Unsetting to prevent name collision.
        
        \ob_start();
        
        // Pass variables to view scope.
        $_vars = $vars;
        unset($vars);
        foreach ($_vars as $_var => $_value)
        {
            $$_var = $_value;
        }
        unset($_vars, $_var, $_value);
        
        require $_file;
        
        return \ob_get_clean();
    }
    
    // ---------------------------------------------------------------------------------------------
    
    /**
     * Get the current views directory.
     * 
     * @return string
     */
    public function getViewsDir()
    {
        return $this->options['views.dir'];
    }
    
    // ---------------------------------------------------------------------------------------------
    
    /**
     * Set the current views directory.
     * 
     * @param string $dir
     * @return \CesarV\Views\View
     */
    public function setViewDir($dir)
    {
        $this->options['views.dir'] = $dir;
        
        return $this;
    }
}