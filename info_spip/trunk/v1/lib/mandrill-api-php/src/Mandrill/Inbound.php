<?php

class Mandrill_Inbound {
    public function __construct(Mandrill $master) {
        $this->master = $master;
    }

    /**
     * List the domains that have been configured for inbound delivery
     * @return array the inbound domains associated with the account
     *     - return[] array the individual domain info
     */
    public function domains() {
        $_params = array();
        return $this->master->call('inbound/domains', $_params);
    }

    /**
     * List the mailbox routes defined for an inbound domain
     * @param string $domain the domain to check
     * @return array the routes associated with the domain
     *     - return[] struct the individual mailbox route
     *         - pattern string the search pattern that the mailbox name should match
     *         - url string the webhook URL where inbound messages will be published
     */
    public function routes($domain) {
        $_params = array("domain" => $domain);
        return $this->master->call('inbound/routes', $_params);
    }

    /**
     * Take a raw MIME document destined for a domain with inbound domains set up, and send it to the inbound hook exactly as if it had been sent over SMTP
$sparam string $to[] the email address of the recipient @validate trim
     * @param string $raw_message the full MIME document of an email message
     * @param array|null $to optionally define the recipients to receive the message - otherwise we'll use the To, Cc, and Bcc headers provided in the document
     * @return array an array of the information for each recipient in the message (usually one) that matched an inbound route
     *     - return[] struct the individual recipient information
     *         - email struct the email address of the matching recipient
     *         - pattern struct the mailbox route pattern that the recipient matched
     *         - url struct the webhook URL that the message was posted to
     */
    public function sendRaw($raw_message, $to=null) {
        $_params = array("raw_message" => $raw_message, "to" => $to);
        return $this->master->call('inbound/send-raw', $_params);
    }

}


