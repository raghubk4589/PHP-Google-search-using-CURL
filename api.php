<?php
	IF($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$status = [];
		$flag = true;
		$query = trim($_POST['query']);
		if(empty($query))
		{
			$status['error'] = "Please enter your keyword";
			$flag = false;
		}
		if($flag)
		{
			$query = urlencode($query);
			$url = "https://www.googleapis.com/customsearch/v1?key=AIzaSyB5QU36ZM7rhj8xt4dRFr5UYwHSSvQrsjI&cx=d1f393294de8789bd&num=10&q=".$query;
			$ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
		    $data = json_decode(curl_exec($ch));
		    if($data->searchInformation->totalResults > 0)
		    {
		    	$output_file_excel = 'output.csv';
		    	$status['details'] = $data->items;
		    	$status['success'] = 1;
		    	$f = fopen($output_file_excel, 'w');
		    	$firstLineKeys = false;
		    	foreach ($status['details'] as $key => $value) {
		    		$line_array = array($value->title);
		    		array_push($line_array,$value->snippet);
    				fputcsv($f, $line_array);
		    	}
		    }
		    else{
		    	$status['error'] = "No results found";
		    }
		    curl_close($ch);
		}
		echo json_encode($status);
	}
	else{
		Location("index.php");
	}
?>