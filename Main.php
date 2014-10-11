<?php

    namespace IdnoPlugins\Foursquare {

        class Main extends \Idno\Common\Plugin
        {

            function registerPages()
            {
                // Register the deauth URL
                \Idno\Core\site()->addPageHandler('foursquare/deauth', '\IdnoPlugins\Foursquare\Pages\Deauth');
                // Register the callback URL
                \Idno\Core\site()->addPageHandler('foursquare/callback', '\IdnoPlugins\Foursquare\Pages\Callback');
                // Register admin settings
                \Idno\Core\site()->addPageHandler('admin/foursquare', '\IdnoPlugins\Foursquare\Pages\Admin');
                // Register settings page
                \Idno\Core\site()->addPageHandler('account/foursquare', '\IdnoPlugins\Foursquare\Pages\Account');

                /** Template extensions */
                // Add menu items to account & administration screens
                \Idno\Core\site()->template()->extendTemplate('admin/menu/items', 'admin/foursquare/menu');
                \Idno\Core\site()->template()->extendTemplate('account/menu/items', 'account/foursquare/menu');
                \Idno\Core\site()->template()->extendTemplate('onboarding/connect/networks', 'onboarding/connect/foursquare');
            }

            function registerEventHooks()
            {

                \Idno\Core\site()->syndication()->registerService('foursquare', function () {
                    return $this->hasFoursquare();
                }, ['place']);

                // Push checkins to Foursquare
                \Idno\Core\site()->addEventHook('post/place/foursquare', function (\Idno\Core\Event $event) {
                    $eventdata = $event->data();
                    $object = $eventdata['object'];
                    if ($this->hasFoursquare()) {
                        try {
                            $fsObj = $this->connect();
                            /* @var \EpiFoursquare $fsObj */
                            $name = $object->placename;
                            $ll   = $object->lat . ',' . $object->long;
                            if ($venues = $fsObj->get('/venues/search', ['ll' => $ll, 'query' => $name, 'limit' => 1, 'v' => '20131031'])) {
                                if (!empty($venues->response->venues) && is_array($venues->response->venues)) {
                                    if (!empty($venues->response->venues[0])) {
                                        $item  = $venues->response->venues[0];
                                        $fs_id = $item->id;
                                        if (!empty($item->location)) {
                                            $object->lat  = $item->location->lat;
                                            $object->long = $item->location->lng;
                                            $object->name = $item->name;
                                            $object->save();
                                        }
                                        $shout = substr(strip_tags($object->body), 0, 140);
                                        if (empty($shout)) $shout = '';
                                        $result = $fsObj->post('/checkins/add', ['venueId' => $fs_id, 'shout' => $shout, 'v' => '20131031']);
                                        if (!empty($result->response)) {
                                            if ($json = $result) {
                                                if (!empty($json->response->checkin->id)) {
                                                    $object->setPosseLink('foursquare', 'https://foursquare.com/forward/checkin/' . $json->response->checkin->id);
                                                    $object->save();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } catch (\Exception $e) {
                            \Idno\Core\site()->session()->addMessage("Unfortunately your post couldn't be syndicated to Foursquare.");
                        }
                    }
                });
            }

            /**
             * Can the current user use Foursquare?
             * @return bool
             */
            function hasFoursquare()
            {
                if (!empty(\Idno\Core\site()->session()->currentUser()->foursquare['access_token'])) {
                    return true;
                }

                return false;
            }

            /**
             * The URL to authenticate with the API
             * @return string
             */
            function getAuthURL()
            {

                $foursquare = $this;
                $login_url  = '';
                if (!$foursquare->hasFoursquare()) {
                    if ($fs = $foursquare->connect()) {
                        $login_url = $fs->getAuthorizeUrl(\Idno\Core\site()->config()->url . 'foursquare/callback');
                    }
                }

                return $login_url;

            }

            /**
             * Connect to Foursquare
             * @return bool|\Foursquare
             */
            function connect()
            {
                if (!empty(\Idno\Core\site()->config()->foursquare)) {
                    $foursquare = new \EpiFoursquare(\Idno\Core\site()->config()->foursquare['clientId'], \Idno\Core\site()->config()->foursquare['secret']);
                    if ($this->hasFoursquare()) {
                        if ($user = \Idno\Core\site()->session()->currentUser()) {
                            try {
                                $foursquare->setAccessToken($user->foursquare['access_token']);
                            } catch (\Exception $e) {
                                \Idno\Core\site()->session()->addMessage("Unfortunately we couldn't connect to Foursquare.");
                            }
                        }
                    }

                    return $foursquare;
                }

                return false;
            }

        }

    }

    namespace {
        require_once(dirname(__FILE__) . '/external/foursquare-async/EpiCurl.php');
        require_once(dirname(__FILE__) . '/external/foursquare-async/EpiFoursquare.php');
        require_once(dirname(__FILE__) . '/external/foursquare-async/EpiSequence.php');
    }