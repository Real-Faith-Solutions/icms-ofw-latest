<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'icms/index';

if (!empty($this->config->config['is_sub_domain']) !== false) {

    // get sub domain
    $sSubDomain = strtolower(explode('.', $_SERVER['SERVER_NAME'])[0]);

    // set as string
    $sSubDomain = preg_replace('/[^A-Za-z0-9\-]/', '', $sSubDomain);

    
    
    // initial value 
    $sSubPanel = DEFAULT_ROUTE; 
    if (in_array($sSubDomain, $this->config->config['valid_sub_domain']) !== false) {

        // check if exist on $config['dns_sub_domain']
        if (!empty($this->config->config['dns_sub_domain'][$sSubDomain]) !== false) {
            $sSubPanel = $this->config->config['dns_sub_domain'][$sSubDomain];
        }
    } else {

        // out of equation
        $sSubPanel = DEFAULT_ROUTE;
    }


    // sub domain as route variable declaration
    $this->config->config['active_sub_domain'] = $sSubPanel;

    // setting up defult controller 
    $route['default_controller'] = $sSubPanel;

    if (!empty($_GET['type']) !== false || !empty($_POST['type']) !== false) {
        $route['(:any)'] = $sSubPanel . "/$1";
    } else {
        $iFlexUrlBuilder = count((array) $this->uri->segments);
        $iFUB_counter = 2;
        $sRouteFlex = '(:any)';
        $sUrlFlex = '/$1';
        if ($iFlexUrlBuilder > 1) {
            while ($iFUB_counter <= $iFlexUrlBuilder) {
                $sRouteFlex .= "/(:any)";
                $sUrlFlex .= "/$" . $iFUB_counter;
                $iFUB_counter++;
            }
        }
        $route[$sRouteFlex] = $sSubPanel . $sUrlFlex;
    }
}


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// route mode for auto redirection || for seeker level
$mUserAgent = "";
if (!empty($_SERVER['HTTP_USER_AGENT']) !== false) {
    $mUserAgent = $_SERVER['HTTP_USER_AGENT'];
}

// clean url request | auto redirect for invalid request of url's 
$route['main_panel'] = array('agency', 'administrator', 'developer', 'icms');
if (!empty($this->uri->segment(1))) {

    if (in_array($this->uri->segment(1), $route['main_panel']) !== false) {
        $sExtensionURL = str_replace(DS . $this->uri->segment(1), "", $_SERVER['REQUEST_URI']);
        @header('Location: ' . SITE_SCHEME . $this->uri->segment(1) . '.' . DOMAIN_NAME . $sExtensionURL);
        exit;
    }
}


