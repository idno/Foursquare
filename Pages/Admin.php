<?php

    /**
     * Foursquare admin
     */

    namespace IdnoPlugins\Foursquare\Pages {

        /**
         * Default class to serve Facebook settings in administration
         */
        class Admin extends \Idno\Common\Page
        {

            function getContent()
            {
                $this->adminGatekeeper(); // Admins only
                $t = \Idno\Core\site()->template();
                $body = $t->draw('admin/foursquare');
                $t->__(array('title' => 'Foursquare', 'body' => $body))->drawPage();
            }

            function postContent() {
                $this->adminGatekeeper(); // Admins only
                $clientId = $this->getInput('clientId');
                $secret = $this->getInput('secret');
                \Idno\Core\site()->config->config['foursquare'] = array(
                    'clientId' => $clientId,
                    'secret' => $secret
                );
                \Idno\Core\site()->config()->save();
                \Idno\Core\site()->session()->addMessage('Your Foursquare application details were saved.');
                $this->forward('/admin/foursquare/');
            }

        }

    }