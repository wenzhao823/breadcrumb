<?php
class BreadCrumb
{
	private $_crumb;

	public function __construct($controller, $action)
	{
		$this->init();
		$this->makeCrumb($controller, $action);
	}

	public function init()
	{
		$this->_crumb = array();
	}

    /**
     * 创建导航条
     * @param type $controller
     * @param type $action
     */
    public function makeCrumb ($controller, $action) {
        $method = new \ReflectionMethod($controller."Controller", $action.'Action');
        $result = $this->parseDocComment($method->getDocComment());
        
        if (empty($this->_crumb)) {
            $this->_crumb = array("{$controller}:{$action}:{$result['title']}");
        } else {
            $this->_crumb[] = "{$controller}:{$action}:{$result['title']}";
        }
        
        if (isset($result['controller'])) {
            
            $this->makeCrumb($result['controller'], $result['action']);
            
        } else {
            $this->_crumb[] = "::主面板";
        }

        return $this->_crumb;
    }

    /**
     * 解析函数注释，获取父导航
     * @param type $doc
     * @return boolean
     */
    public function parseDocComment ($doc) {
        $result = array();
        
        //先取注释第一行
        $matches = array();
        preg_match("/([^\s\*\n\r\/].*?)/U", $doc, $matches);
        $result['title'] = @$matches[1];
        
        //再取父导航
        preg_match("/@ParentNav\s+(\w+)\/(\w+?)[\s]+?([^\*\s]*?)/U", $doc, $matches); 
        if (count($matches) == 4) {
            $result ['controller'] = $matches[1];
            $result ['action'] = $matches[2];
            !empty($matches[3]) && $result ['title'] = $matches[3];
        }
        
        return $result;
    }

    
    /**
     * 转换导航为html结构
     */
    public function render () {
        $html = '';
        if (is_array($this->_crumb) && count($this->_crumb)) {
            $this->_crumb = array_reverse($this->_crumb);
            $count= count($this->_crumb);
            foreach ($this->_crumb as $k => $nav) {
                list($controller, $action, $title) = explode(':', $nav);
                if ($k == $count-1) {
                    $html .= '<li>'.$title.'</li>';
                } else {
                	if($k == 0) {
                		$html .= '<li><a href="/'.$controller.($action?'/'.$action:'').'"><i class="icofont-home"></i>'.$title.'</a><span class="divider">›</span></li>';
                	} else {
                		$html .= '<li><a href="/'.$controller.($action?'/'.$action:'').'">'.$title.'</a><span class="divider">›</span></li>';
                	}
                }
            }
        }
        return $html;
    }

    
    /**
     * 输出导航为html结构
     */
    public function display () {
    	echo $this->render($this->_crumb);
    }
}