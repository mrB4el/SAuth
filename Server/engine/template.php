<?php
   class Tpl
   {
        protected static $instance;
    
        protected $vars   = array( );
        protected $config = array( );
    
        public static function instance( array $config = null )
        {
            return (is_null(static::$instance)
                ? static::$instance = new static($config)
                : static::$instance
            );
        }
    
        protected function __construct( array $config )
        {
            $this->config = $config;
        }
    
        protected function __clone()
        {
            //...
        }
    
        protected function __wakeup()
        {
            //...
        }
        
        public function __set( $key, $value )
        {
            $this->vars[ $key ] = $value;
        }
    
        public function __get( $key )
        {
            return (isset($this->vars[ $key ]) ? $this->vars[ $key ] : null);
        }
    
        public function __isset( $key )
        {
            return isset($this->vars[ $key ]);
        }
    
        public function __unset( $key )
        {
            unset($this->vars[ $key ]);
        }
        
        public function render( $template, array $vars = null, $key = null )
        {
            if (is_array($vars)) {
                $this->vars = $vars += $this->vars;
            }
    
            ob_start();
    
            if (is_file($this->config['dir'] . '/' . $template . '.' . $this->config['ext'])) {
                include $this->config['dir'] . '/' . $template . '.' . $this->config['ext'];
    
                if (is_null($key)) {
                    return ob_get_clean();
                }
    
                $this->$key = ob_get_clean();
    
                return $this;
            }
    
            throw new Exception("Template file '{$template}' not found.");
        }
    }
    
    $tpl = Tpl::instance(array(
        // путь к папке с шаблонами
        'dir' => './template',
        // расширение файлов шаблонов
        'ext' => 'tpl',
    ));
?>