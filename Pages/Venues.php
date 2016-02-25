<?php

    /**
     * Plugin administration
     */

    namespace IdnoPlugins\Foursquare\Pages {

        class Venues extends \Idno\Common\Page
        {
		function getContent()
		{
			$this->gatekeeper();
			$foursquare = \Idno\Core\site()->plugins()->get('Foursquare');
			$response = array();
			$ll = $this->getInput('ll');
			if (!empty($ll)) {
				$icon = (!empty($venue->categories) ? $venue->categories[0]->icon->prefix . "bg_32". $venue->categories[0]->icon->suffix : "https://foursquare.com/img/categories_v2/none_bg_32.png");
				if ($venues = $foursquare->getVenues($ll)) {
					foreach ($venues as $venue) {
						$response[] = array(
							'id'      => $venue->id,
							'name'    => $venue->name,
							'lat'     => $venue->location->lat,
							'long'    => $venue->location->lng,
							'address' => implode(" ",$venue->location->formattedAddress),
							'icon32'  => $icon
						);
							
					}
				}
			}
			header('Content-type: text/json');
			echo json_encode($response, JSON_PRETTY_PRINT);
		}
        }

    }
