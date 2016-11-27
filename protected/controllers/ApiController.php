<?php
/**
 * APP REST API 1.0
 * OUTPUT JSON REST
 * DATA LOAD FROM SQLLITE DATABASE
 * DATA IMPORTED FROM CITIES.CSV
 * GET /                  - APP NAME, TIMESTAMP
 * GET /cities            - ALL CITIES, LIMIT = 50
 * GET /cities/:page      - ALL CITIES, LIMIT = 50, :PAGE
 * GET /cities/:ID        - ALL INFORMATION ABOUT CITY BY :ID
 */

class ApiController extends Controller
{
	private $page_limit = 50;
    
    public function actionIndex()
	{	
		$output = array('app'=>Yii::app()->name, 'timestamp'=> strtotime("now"));
		$this->_sendResponse(200, CJSON::encode($output));
	}

	public function actionCities()
	{	
		if(!isset($_GET['id']))
		{
			$criteria = new CDbCriteria();
			$count = Cities::model()->count($criteria);
			if(isset($_GET['page']))
			{
			    $pages = new CPagination($count);
			    $pages->pageSize = $this->page_limit;
			    $pages->applyLimit($criteria);
			} else {
				$criteria->limit = $this->page_limit;
			}

			$cities = Cities::model()->findAll($criteria);

			if(is_null($cities))
				$this->_sendResponse(404, 'No Items found with');
			else
		        $this->_sendResponse(200, CJSON::encode($cities));

		} else {
			$id = (int) $_GET['id'];
			$citi = Cities::model()->findByPk($id);

			if(is_null($citi))
		        $this->_sendResponse(404, 'No Item found with id '.$_GET['id']);
			else
		        $this->_sendResponse(200, CJSON::encode($citi));
		}
	}

	private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
	{
	    $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
	    header($status_header);
	    header('Content-type: ' . $content_type);
	 
	    if($body != '')
	    {
	        echo $body;
	    } else {
	        $message = '';

	        $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

	        $body = '
				<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
				<html>
				<head>
				    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
				    <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
				</head>
				<body>
				    <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
				    <p>' . $message . '</p>
				    <hr />
				    <address>' . $signature . '</address>
				</body>
				</html>';
				 
	        echo $body;
	    }
	    Yii::app()->end();
	}

	private function _getStatusCodeMessage($status)
	{
	    $codes = Array(
	        200 => 'OK',
	        400 => 'Bad Request',
	        404 => 'Not Found',
	        500 => 'Internal Server Error',
	    );
	    return (isset($codes[$status])) ? $codes[$status] : '';
	}

	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
}