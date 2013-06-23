<?php

    namespace IdnoPlugins\Foursquare {

        class Main extends \Idno\Common\Plugin {

            function registerPages() {
                // Register the callback URL
                    \Idno\Core\site()->addPageHandler('foursquare/callback','\IdnoPlugins\Foursquare\Pages\Callback');
                // Register admin settings
                    \Idno\Core\site()->addPageHandler('admin/foursquare','\IdnoPlugins\Foursquare\Pages\Admin');
                // Register settings page
                    \Idno\Core\site()->addPageHandler('account/foursquare','\IdnoPlugins\Foursquare\Pages\Account');

                /** Template extensions */
                // Add menu items to account & administration screens
                    \Idno\Core\site()->template()->extendTemplate('admin/menu/items','admin/foursquare/menu');
                    \Idno\Core\site()->template()->extendTemplate('account/menu/items','account/foursquare/menu');
            }

            function registerEventHooks() {
                // Push checkins to Foursquare
                \Idno\Core\site()->addEventHook('post/place',function(\Idno\Core\Event $event) {
                    $object = $event->data()['object'];
                    if ($this->hasFoursquare()) {
                        $fsObj = $this->connect();
                        $name = $object->placename;
                        $ll = $object->lat . ',' . $object->long;
                        error_log($ll);
                        if ($venues = $fsObj->get('/venues/search', ['ll' => $ll, 'query' => $name, 'limit' => 1])) {
                            error_log('Venues exist');
                            if (!empty($venues->response->groups) && is_array($venues->response->groups)) {
                                error_log('Groups exist');
                                if (!empty($venues->response->groups[0]->items) && is_array($venues->response->groups[0]->items)) {
                                    $item = array_pop($venues->response->groups[0]->items);
                                    error_log(var_export($item,true));
                                    $fs_id = $item->id;
                                    if (!empty($item->location)) {
                                        $object->lat = $item->location->lat;
                                        $object->long = $item->location->lng;
                                        $object->name = $item->name;
                                        $object->save();
                                    }
                                    $shout = substr(strip_tags($object->body),0,140);
                                    if (empty($shout)) $shout = '';
                                    $result = $fsObj->post('/checkins/add',['venueId' => $fs_id, 'shout' => $shout]);
                                    if (!empty($result->responseText)) {
                                        if ($json = json_decode($result->responseText)) {
                                    		if (!empty($json->response->checkin->id)) {
                                    			$object->setPosseLink('foursquare','https://foursquare.com/forward/checkin/' . $json->response->checkin->id);
                                    			$object->save();
                                    		}
                                    	}
                                    }
                                }
                            }
                        }
                    }
                });
            }

            /**
             * Can the current user use Foursquare?
             * @return bool
             */
            function hasFoursquare() {
                if (\Idno\Core\site()->session()->currentUser()->foursquare) {
                    return true;
                }
                return false;
            }

            /**
             * Connect to Foursquare
             * @return bool|\Foursquare
             */
            function connect() {
                if (!empty(\Idno\Core\site()->config()->foursquare)) {
                    require_once(dirname(__FILE__) . '/external/foursquare-async/EpiCurl.php');
                    require_once(dirname(__FILE__) . '/external/foursquare-async/EpiFoursquare.php');
                    require_once(dirname(__FILE__) . '/external/foursquare-async/EpiSequence.php');
                    $foursquare = new \EpiFoursquare(\Idno\Core\site()->config()->foursquare['clientId'], \Idno\Core\site()->config()->foursquare['secret']);
                    if ($this->hasFoursquare()) {
                        if ($user = \Idno\Core\site()->session()->currentUser()) {
                            $foursquare->setAccessToken($user->foursquare['access_token']);
                        }
                    }
                    return $foursquare;
                }
                return false;
            }

        }

    }
