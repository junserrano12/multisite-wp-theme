<?php
	
	return array(

			'name'  => 'Iframe',
			'tag'  => '[get_iframe]',
			'type' => 'Dynamic',
			'desc' => 'Renders an iframe container from a specified 3rd party source',
			'param' => array(
								'name' => 'Optional. Can be unique. The iframe class name. (Default e.g. "iframe-container")',
								'src' => 'Required. The iframe source. 3rd party website url source. (e.g. "http://www.domain.com"). (Default e.g. "")',
								'style ' => 'Optional. The style and dimension of the iframe. Inline css rules. (e.g. "width: 450px; height:250px"). (Default e.g. "")',
								'param' => 'Optional. Iframe html additional properties goes here. (Default e.g. "")'

							),
			'data' => 'Based on tag parameters',
			'usage' => ' [get_iframe name="iframe-container-1" src="http://hwp.directwithhotels.com/" style="width:500px; height:250px"]',
			'notes' => 'Verify 3rd party url source is active. Default iframe dimension is 300px X 150px.'

			);

?>