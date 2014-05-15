<?php
class ControllerExtensionInstaller extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/installer');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');
		$data['entry_upload'] = $this->language->get('entry_upload');
		$data['entry_overwrite'] = $this->language->get('entry_overwrite');
		$data['entry_progress'] = $this->language->get('entry_progress');
		$data['help_upload'] = $this->language->get('help_upload');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_clear'] = $this->language->get('button_clear');
		$data['button_continue'] = $this->language->get('button_continue');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ''
        );

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/installer', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
		);

		$data['token'] = $this->session->data['token'];

		$directories = glob(DIR_DOWNLOAD . 'temp-*', GLOB_ONLYDIR);

		if ($directories) {
			$data['error_warning'] = $this->language->get('error_temporary');
		} else {
			$data['error_warning'] = '';
		}
		
		$this->data = $data;
        $this->template = 'extension/installer.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render());
	}

	public function upload() {		
		$this->load->language('extension/installer');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'extension/installer')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			if (!empty($this->request->files['file']['name'])) {
				if (strrchr($this->request->files['file']['name'], '.') != '.zip') {
					$json['error'] = $this->language->get('error_filetype');
				}

				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
				}
			} else {
				$json['error'] = $this->language->get('error_upload');
			}
		}

		if (!$json) {
			// If no temp directory exists create it
			$path = 'temp-' . md5(mt_rand());

			if (!is_dir(DIR_DOWNLOAD . $path)) {
				mkdir(DIR_DOWNLOAD . $path, 0777);
			}

			// Set the steps required for installation
			$json['step'] = array();
			$json['overwrite'] = array();

			// If zip file copy it to the temp directory
			if (strrchr($this->request->files['file']['name'], '.') == '.zip') {
				$file = DIR_DOWNLOAD . $path . '/upload.zip';

				move_uploaded_file($this->request->files['file']['tmp_name'], $file);

				if (file_exists($file)) {					
					$zip = zip_open($file);

					if ($zip) {
						// Zip
						$json['step'][] = array(
							'text' => $this->language->get('text_unzip'),
							'url'  => str_replace('&amp;', '&', $this->url->link('extension/installer/unzip', 'format=raw&tmpl=component&token=' . $this->session->data['token'], 'SSL')),
							'path' => $path
						);

						// FTP
						$json['step'][] = array(
							'text' => $this->language->get('  '),
							'url'  => str_replace('&amp;', '&', $this->url->link('extension/installer/ftp', 'format=raw&tmpl=component&token=' . $this->session->data['token'], 'SSL')),
							'path' => $path
						);

						while ($entry = zip_read($zip)) {
							$zip_name = zip_entry_name($entry);

							// SQL
							if (substr($zip_name, 0, 11) == 'install.sql') {
								$json['step'][] = array(
									'text' => $this->language->get('text_sql'),
									'url'  => str_replace('&amp;', '&', $this->url->link('extension/installer/sql', 'format=raw&tmpl=component&token=' . $this->session->data['token'], 'SSL')),
									'path' => $path
								);
							}		

							// PHP
							if (substr($zip_name, 0, 11) == 'install.php') {
								$json['step'][] = array(
									'text' => $this->language->get('text_php'),
									'url'  => str_replace('&amp;', '&', $this->url->link('extension/installer/php', 'format=raw&tmpl=component&token=' . $this->session->data['token'], 'SSL')),
									'path' => $path
								);
							}

							// Compare admin files
							$file = MPATH_MIWOSHOP_OC .'/'. substr($zip_name,7);

                            //$file= str_replace("upload/","",$file);

							if (is_file($file) && strtolower(substr($zip_name, 0, 13)) == 'upload/admin/'){
								$json['overwrite'][] = substr($zip_name, 7);
							}

							// Compare catalog files
							$file = MPATH_MIWOSHOP_OC .'/'. substr($zip_name, 7);

							if (is_file($file) && strtolower(substr($zip_name, 0, 15)) == 'upload/catalog/') {
								$json['overwrite'][] = substr($zip_name, 7);
							}

							// Compare image files
							$file = MPATH_MIWOSHOP_OC .'/'. substr($zip_name,7);

							if (is_file($file) && strtolower(substr($zip_name, 0, 13)) == 'upload/image/') {
								$json['overwrite'][] = substr($zip_name, 7);
							}

							// Compare system files
							$file = MPATH_MIWOSHOP_OC .'/'. substr($zip_name, 7);

							if (is_file($file) && strtolower(substr($zip_name, 0, 14)) == 'upload/system/') {
								$json['overwrite'][] = substr($zip_name, 7);
							}

							// Compare vqmod files
							$file = MPATH_MIWOSHOP_OC .'/'. substr($zip_name, 7);

							if (is_file($file) && strtolower(substr($zip_name, 0, 13)) == 'upload/vqmod/') {
								$json['overwrite'][] = substr($zip_name, 7);
							}
						}
						 
						// Clear temporary files
						$json['step'][] = array(
							'text' => $this->language->get('text_remove'),
							'url'  => str_replace('&amp;', '&', $this->url->link('extension/installer/remove', 'format=raw&tmpl=component&token=' . $this->session->data['token'], 'SSL')),
							'path' => $path
						);	

						zip_close($zip);
					} else {
						$json['error'] = $this->language->get('error_unzip');
					}			
				} else {
					$json['error'] = $this->language->get('error_file');
				}			
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function unzip() {
		$this->load->language('extension/installer');

		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/installer')) {
			$json['error'] = $this->language->get('error_permission');
		}

		// Sanitize the filename	
		$file = DIR_DOWNLOAD . str_replace(array('../', '..\\', '..'), '', $this->request->post['path']) . '/upload.zip';

		if (!file_exists($file)) {
			$json['error'] = $this->language->get('error_file');
		}

		if (!$json) {
			// Unzip the files
			$zip = new ZipArchive();

			if ($zip->open($file)) {
				$zip->extractTo(DIR_DOWNLOAD . str_replace(array('../', '..\\', '..'), '', $this->request->post['path']));
				$zip->close();				
			} else {
				$json['error'] = $this->language->get('error_unzip');
			}

			// Remove Zip
			unlink($file);		
		}

		$this->response->setOutput(json_encode($json));
	}

	public function ftp() {
		$this->load->language('extension/installer');

		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/installer')) {
			$json['error'] = $this->language->get('error_permission');
		}

		$directory = DIR_DOWNLOAD . str_replace(array('../', '..\\', '..'), '', $this->request->post['path']) . '/upload/';
		if (!is_dir($directory)) {
		$directory = DIR_DOWNLOAD . str_replace(array('../', '..\\', '..'), '', $this->request->post['path']) . '/UPLOAD/';
		}
		if (!is_dir($directory)) {
		$directory = DIR_DOWNLOAD . str_replace(array('../', '..\\', '..'), '', $this->request->post['path']) . '/Upload/';
		}
		//echo $directory;
		if (!is_dir($directory)) {
			$json['error'] = $this->language->get('error_directory');
		}

		if (!$json) {
			// Get a list of files ready to upload
			$files = array();

			$path = array($directory . '*');

			while(count($path) != 0) {
				$next = array_shift($path);

				foreach(glob($next) as $file) {
					if (is_dir($file)) {
						$path[] = $file . '/*';
					}
					/*$edit_page_url = explode("upload", strtolower($file));
					$edit_page_url = 'upload'.$edit_page_url[1];
					$this->permission_control($edit_page_url);*/
                    $this->editFile($file);
					$files[] = $file;
				}
			}

            $root = ABSPATH.'wp-content/plugins/miwoshop/site/opencart/';

            foreach ($files as $file) {
                // Upload everything in the upload directory

                $destination = substr($file, strlen($directory));

                if (is_dir($file)) {
                    if (!is_dir($root.$destination)) {
                        if (!mkdir($root.$destination)) {
                            $json['error'] = sprintf($this->language->get('error_ftp_directory'), $destination);
                            exit();
                        }
                    }
                }

                if (is_file($file)) {
                    if (!copy($file, $root.$destination)) {
                        $json['error'] = sprintf($this->language->get('error_ftp_file'), $file);
                    }
                }
            }
		}

		$this->response->setOutput(json_encode($json));
	}

    public function editFile($path){

        $page         = $path;
      //  $edit_page    = html_entity_decode(file_get_contents($page));
        $edit_page    = file_get_contents($page);

        if ($edit_page!=""){
            $source = '';
            $edit_page_url = explode("upload", strtolower($page));
            $edit_page_url = 'upload'.$edit_page_url[1];

                if (strpos($edit_page_url, 'upload/admin')!== false){
                    $source = 'admin';
                }elseif(strpos($edit_page_url, 'upload/catalog')!== false){
                    $source = 'site';
                }elseif(strpos($edit_page_url, 'module') !== false){
                    $source = 'module';
                }elseif(strpos($edit_page_url, 'upload/vqmod') !== false){
                    $source = 'vqmod';
                }
            
            $image_control = explode('.',$edit_page_url);
            if((($image_control[1]!='png') AND ($image_control[1]!='gif') AND ($image_control[1]!='jpg'))){
				if(in_array("js",$image_control)){$source = 'js';}
				$edit_page = $this->replace($source,$edit_page);
				
                file_put_contents($page, $edit_page);
				// Controllers page check permission for Show Administrator automaticaly..
                $this->permission_control($edit_page_url);
            }
        }
    }

    public function replace($source,$edit_page){

        $replace_output['JPATH_MIJOSHOP'] 		                                                                = 'MPATH_MIWOSHOP';

    if ($source == 'admin') {
        $replace_output['"../components/com_mijoshop/opencart/admin']                                           = "MPATH_MIWOSHOP_OC.".'/admin';
        $replace_output['\'../components/com_mijoshop/opencart/admin']                                          = "MPATH_MIWOSHOP_OC."."/admin";
        $replace_output['"components/com_mijoshop/opencart/admin']                                              = "MPATH_MIWOSHOP_OC.".'/admin';
        $replace_output['\'components/com_mijoshop/opencart/admin']                                             = "MPATH_MIWOSHOP_OC."."/admin";
        $replace_output['((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . \'index.php?token=\''] 				= '"admin.php?page=miwoshop&option=com_miwoshop&token="';
        $replace_output['index.php?route='] 																	= 'index.php?option=com_miwoshop&route=';
        $replace_output['index.php?token='] 																	= 'index.php?option=com_miwoshop&token=';
       // $replace_output['((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . \'index.php?token=\''] 				= 'admin.php?page=miwoshop&option=com_miwoshop&token=';
        $replace_output['"<link rel="stylesheet" type="text/css" href="index.php?option=com_miwoshop&'] 		= '<link rel="stylesheet" type="text/css" href="<?php echo admin_url()?>/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&';
        $replace_output['\'<link rel="stylesheet" type="text/css" href="index.php?option=com_miwoshop&'] 		= '<link rel="stylesheet" type="text/css" href="<?php echo admin_url()?>/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&';
        $replace_output['$this->document->addStyle(\'view/'] 								        	        = "MiwoShop::get('base')->addHeader(MPATH_MIWOSHOP_OC . '/admin/view/";
        $replace_output["HTTP_SERVER . 'admin/"] 							                                	= "HTTP_SERVER . MPATH_MIWOSHOP_OC."."'/admin/";
    }

    if ($source == 'site') {
        $replace_output['"../components/com_mijoshop/opencart/']                                                = "MPATH_MIWOSHOP_OC. \"";
        $replace_output['\'../components/com_mijoshop/opencart/']                                               = "MPATH_MIWOSHOP_OC. \'";
        $replace_output['"components/com_mijoshop/opencart/']                                                   = "MPATH_MIWOSHOP_OC. \"";
        $replace_output['\'components/com_mijoshop/opencart/']                                                  = "MPATH_MIWOSHOP_OC. \'";
        $replace_output['"components/com_mijoshop/opencart/']                                                   = "MPATH_MIWOSHOP_OC. \"";
        $replace_output['class="box"'] 												                            = 'class="box_oc"';
        $replace_output['class="button_oc"'] 										                            = 'class="'.MiwoShop::getButton().'"';
        $replace_output['class="button"'] 											                            = 'class="'.MiwoShop::getButton().'"';
        $replace_output['id="button"'] 												                            = 'class="'.MiwoShop::getButton().'"';
        $replace_output[' src="catalog/'] 											                            = ' src="'.MURL_MIWOSHOP.'/site/opencart/catalog/';
        $replace_output[' src="image/'] 											                            = ' src="'.MURL_MIWOSHOP.'/site/opencart/image/';
    }
	
	if ($source == 'vqmod'){
		$replace_output["'../'. 'components/com_mijoshop/opencart"]												= "MPATH_MIWOSHOP_OC.'";
		$replace_output["'../'.'components/com_mijoshop/opencart"]												= "MPATH_MIWOSHOP_OC.'";
		$replace_output['HTTPS_CATALOG."components/com_mijoshop/opencart']										= "MPATH_MIWOSHOP_OC.\"";
		$replace_output['HTTP_CATALOG."components/com_mijoshop/opencart']										= "MPATH_MIWOSHOP_OC.\"";
	}

    if ($source == 'js'){
        $replace_output[": 'index.php?route="] 										                            = ":miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&route=";
        $replace_output[': "index.php?route='] 												                    = ":miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&route=";
        $replace_output[":'index.php?route="] 											                        = ":miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&route=";
        $replace_output[':"index.php?route='] 												                    = ":miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&route=";
		$replace_output[": 'index.php?option=com_mijoshop&route="] 										        = ":miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&route=";
        $replace_output[': "index.php?option=com_mijoshop&route='] 												= ":miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&route=";
        $replace_output[":'index.php?option=com_miwjshop&route="] 											    = ":miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&route=";
        $replace_output[':"index.php?option=com_mijoshop&route='] 											    = ":miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&route=";
    }

    if ($source == 'admin' || $source == 'site') {
        $replace_output["jQuery.post('index.php?route="] 									                    = "jQuery.post('miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
        $replace_output["jQuery.post('index.php?option=com_mijoshop&route="] 				                    = "jQuery.post('miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
        $replace_output[".load('index.php?option=com_mijoshop&route="] 			        	                    = ".load(miwiajaxurl + '?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
        $replace_output[".load('index.php?route="] 									                            = ".load(miwiajaxurl + '?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
        $replace_output[": 'index.php?option=com_mijoshop&route="] 					                            = ":miwiajaxurl + '?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
        $replace_output[': "index.php?option=com_mijoshop&route='] 				                                = ':miwiajaxurl + "?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=';
        $replace_output[": 'index.php?route="] 										                            = ":miwiajaxurl + '?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
        $replace_output[': "index.php?route='] 										                            = ':miwiajaxurl + "?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=';
        $replace_output[": 'index.php?option=com_mijoshop&format=raw"] 				                            = ":miwiajaxurl + '?action=miwoshop&option=com_miwoshop&format=raw";
        $replace_output[': "index.php?option=com_mijoshop&format=raw'] 			        	                    = ':miwiajaxurl + "?action=miwoshop&option=com_miwoshop&format=raw';

        $replace_output["ajaxurl = 'index.php?option=com_miwoshop&route"] 				                        = "ajaxurl = miwiajaxurl + '?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
        $replace_output['ajaxurl = "index.php?option=com_miwoshop&route'] 				                        = "ajaxurl = miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
        $replace_output["ajaxurl = 'index.php?route="] 					                                        = "ajaxurl = miwiajaxurl + '?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
        $replace_output['ajaxurl = "index.php?route='] 					                                        = "ajaxurl = miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
        $replace_output["ajaxurl = 'index.php?option=com_miwoshop&format=raw"] 				                    = "ajaxurl = miwiajaxurl + '?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component";
        $replace_output['ajaxurl = "index.php?option=com_miwoshop&format=raw'] 			                        = "ajaxurl = miwiajaxurl + \"?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component";
    }

        $replace_output['JPATH_MIJOSHOP_OC'] 		                                                            = 'MPATH_MIWOSHOP_OC';
        $replace_output['JPATH_MIJOSHOP_LIB'] 		                                                            = 'MPATH_MIWOSHOP_LIB';
        $replace_output['JPATH_MIJOSHOP_SITE'] 		                                                            = 'MPATH_MIWOSHOP_SITE';
        $replace_output['JPATH_MIJOSHOP_ADMIN'] 		                                                        = 'MPATH_MIWOSHOP_ADMIN';
        $replace_output['JConfig'] 		                                                                        = 'MConfig';
        $replace_output['JController'] 		                                                                    = 'MController';
        $replace_output['JRequest'] 		                                                                    = 'MRequest';
        $replace_output['JDatabase'] 		                                                                    = 'MDatabase';
        $replace_output['JDate'] 		                                                                    	= 'MDate';
        $replace_output['JEditor'] 		                                                                        = 'MEditor';
        $replace_output['JFactory'] 		                                                                    = 'MFactory';
        $replace_output['JFile'] 		                                                                        = 'MFile';
        $replace_output['JPath'] 		                                                                        = 'MPath';
        $replace_output['JRegistry'] 		                                                                    = 'MRegistry';
        $replace_output['JRoute'] 		                                                                        = 'MRoute';
        $replace_output['jimport(\'joomla.'] 		                                                            = 'mimport(\'framework.';
        $replace_output['jimport'] 		                                                                        = 'mimport';
        $replace_output['jexit'] 		                                                                        = 'mexit';
        $replace_output['Joomla.checkAll(this)'] 		                                                        = 'Miwi.checkAll(this)';
        $replace_output['JACTION'] 		                                               					        = 'MACTION';
        $replace_output['JAdministratorHelper'] 		                                               			= 'MAdministratorHelper';
        $replace_output['JApplication'] 		                                               					= 'MApplication';
        $replace_output['JArchive'] 		                                               						= 'MArchive';
        $replace_output['JArrayHelper'] 		                                               					= 'MArrayHelper';
        $replace_output['JBrowser'] 		                                               						= 'MBrowser';
        $replace_output['JCache'] 		                                               							= 'MCache';
        $replace_output['JDispatcher'] 		                                               						= 'MDispatcher';
        $replace_output['JDocument'] 		                                               						= 'MDocument';
        $replace_output['JError'] 		                                               							= 'MError';
        $replace_output['JFEATURED'] 		                                               						= 'MFEATURED';
        $replace_output['JTable'] 		                                               							= 'MTable';

        $replace_output['MijoShop'] 											                                = 'MiwoShop';
        $replace_output['mijoshop'] 											                                = 'miwoshop';

        $replace_output_regex['~JPATH_(ROOT|SITE)\s*.\s*("|\')/components/com_mijo([a-zA-Z0-9_\.\-]+)~'] 		                 = 'MPATH_WP_PLG.$2/miwo$3/site';
        $replace_output_regex['~JPATH_(ROOT|ADMINISTRATOR|SITE)\s*.\s*("|\')/(administrator/|)components/com_mijoshop~'] 		 = 'MPATH_WP_PLG.$2/miwo$4/admin';
        $replace_output_regex['~J(Uri|URI)::root\((true|false|)\)\s*.\s*("|\')(/|)components/com_mijoshop~'] 	                 = 'MURL_MIWO$5.$3/site/$6$7';
        $replace_output_regex['~<\?php echo J(Uri|URI)::root\((true|false|)\)(\W+)\?>(/|)components/com_mijoshop~'] 		     = '<?php echo MURL_MIWO$5; ?>/site/$6';
        $replace_output_regex['~(addStyleSheet|addScript|stylesheet|script)\(("|\')components/com_mijoshop~'] 		             = '$1(MURL_MIWO$3.$2/site';
        $replace_output_regex['~(href|src)\s*=\s*("|\')(/|)components/com_mijoshop~'] 		                                     = '$1=$2<?php echo MURL_MIWO$4; ?>/site';
        $replace_output_regex['~J(Show|SHOW|HIDE|Hide)~'] 		                                                                 = 'M$1';
        $replace_output_regex['~(JURI|JUri|Juri)~'] 		                                                                     = 'MUri';

        foreach($replace_output_regex as $key => $value) {
            $edit_page = preg_replace($key, $value, $edit_page);
        }

        foreach($replace_output as $key => $value) {
            $edit_page = str_replace($key, $value, $edit_page);
        }

        return $edit_page;
    }

    public function permission_control($edit_page_url){
        $search_page = array(
            'product' 				=> 'product.',
            'common' 				=> 'common',
            'design' 		    	=> 'design',
            'error' 				=> 'error',
            'extension' 			=> 'extension',
            'feed' 		        	=> 'feed',
            'localisation' 		    => 'localisation',
            'module' 	    		=> 'module',
            'payment' 				=> 'payment',
            'report'                => 'report',
            'sale' 				    => 'sale',
            'setting' 				=> 'setting',
            'shipping' 				=> 'shipping',
            'tool'   				=> 'tool',
            'total' 				=> 'total',
            'user' 				    => 'user'
        );
        foreach($search_page as $page)
        if (strpos($edit_page_url, 'upload/admin/controller/'.$page)!== false){

            $permissions_page = explode($page,$edit_page_url);
            $permissions_page = $page.str_replace('.php','',$permissions_page[1]);

            $this->permission($permissions_page);

        }

    }

    public function permission($page){
        $jdb = MiwoShop::get('db')->getDbo();

        //insert permission for support/support
        $jdb->setQuery("SELECT permission FROM `#__miwoshop_user_group` WHERE `user_group_id` = 1");
        $permission = $jdb->loadResult();
        $permission = unserialize($permission);

            if (!array_search($page, $permission['access'])){
                $permission['access'][] = $page;
                $permission['modify'][] = $page;
            }

        $permission = serialize($permission);

        $jdb->setQuery("UPDATE `#__miwoshop_user_group` SET `permission` = '".$permission."' WHERE `user_group_id` = 1");
        $jdb->query();
    }

	public function sql() {
		$this->load->language('extension/installer');

		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/installer')) {
			$json['error'] = $this->language->get('error_permission');
		}

		$file = DIR_DOWNLOAD . str_replace(array('../', '..\\', '..'), '', $this->request->post['path']) . '/install.sql';

		if (!file_exists($file)) {
			$json['error'] = $this->language->get('error_file');
		}

		if (!$json) {
			$lines = file($file);

			if ($lines) {
				try {	
					$sql = '';

					foreach($lines as $line) {
						if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')) {
							$sql .= $line;

							if (preg_match('/;\s*$/', $line)) {
								$sql = str_replace(" `oc_", " `" . DB_PREFIX, $sql);

								$this->db->query($sql);

								$sql = '';
							}
						}
					}
				} catch(Exception $exception) {
					$json['error'] = sprintf($this->language->get('error_exception'), $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine());
				}
			}
		}

		$this->response->setOutput(json_encode($json));							
	}

	public function php() {
		$this->load->language('extension/installer');

		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/installer')) {
			$json['error'] = $this->language->get('error_permission');
		}

		$file = DIR_DOWNLOAD . str_replace(array('../', '..\\', '..'), '', $this->request->post['path']) . '/install.php';

		if (!file_exists($file)) {
			$json['error'] = $this->language->get('error_file');
		}

		if (!$json) {
			try {
				include($file);
			} catch(Exception $exception) {
				$json['error'] = sprintf($this->language->get('error_exception'), $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine());
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function remove() {
		$this->load->language('extension/installer');

		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/installer')) {
			$json['error'] = $this->language->get('error_permission');
		}

		$directory = DIR_DOWNLOAD . str_replace(array('../', '..\\', '..'), '', $this->request->post['path']);

		if (!is_dir($directory)) {
			$json['error'] = $this->language->get('error_directory');
		}

		if (!$json) {
			// Get a list of files ready to upload
			$files = array();

			$path = array($directory . '*');

			while(count($path) != 0) {
				$next = array_shift($path);

				foreach(glob($next) as $file) {
					if (is_dir($file)) {
						$path[] = $file . '/*';
					}

					$files[] = $file;
				}
			}

			sort($files);

			rsort($files);

			foreach ($files as $file) {
				if (is_file($file)) {
					unlink($file);
				} elseif (is_dir($file)) {
					rmdir($file);	
				}
			}

			if (file_exists($directory)) {
				rmdir($directory);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->setOutput(json_encode($json));
	}

	public function clear() {
		$this->load->language('extension/installer');

		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/installer')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$directories = glob(DIR_DOWNLOAD . 'temp-*', GLOB_ONLYDIR);

			foreach($directories as $directory) {
				// Get a list of files ready to upload
				$files = array();

				$path = array($directory . '*');

				while(count($path) != 0) {
					$next = array_shift($path);

					foreach(glob($next) as $file) {
						if (is_dir($file)) {
							$path[] = $file . '/*';
						}

						$files[] = $file;
					}
				}

				sort($files);

				rsort($files);

				foreach ($files as $file) {
					if (is_file($file)) {
						unlink($file);
					} elseif (is_dir($file)) {
						rmdir($file);	
					}
				}

				if (file_exists($directory)) {
					rmdir($directory);
				}
			}

			$json['success'] = $this->language->get('text_clear');
		}

		$this->response->setOutput(json_encode($json));
	}
}