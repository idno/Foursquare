<?php

    /**
     * Facebook pages
     */

    namespace IdnoPlugins\Foursquare\Pages {

        /**
         * Default class to serve Facebook-related account settings
         */
        class Account extends \Idno\Common\Page
        {

            function getContent()
            {
                $this->gatekeeper(); // Logged-in users only
                $login_url = '';
                if ($foursquare = \Idno\Core\site()->plugins()->get('Foursquare')) {
                    $login_url = $foursquare->getAuthURL();
                }
                $t = \Idno\Core\site()->template();
                $body = $t->__(['login_url' => $login_url])->draw('account/foursquare');
                $t->__(['title' => 'Foursquare', 'body' => $body])->drawPage();
            }

            function postContent() {
                $this->gatekeeper(); // Logged-in users only
                if (($this->getInput('remove'))) {
                    $user = \Idno\Core\site()->session()->currentUser();
                    $user->foursquare = [];
                    $user->save();
                    \Idno\Core\site()->session()->addMessage('Your Foursquare settings have been removed from your account.');
                }
                $this->forward('/account/foursquare/');
            }

        }

    }