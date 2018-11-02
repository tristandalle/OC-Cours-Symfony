<?php

namespace TRI\PlatformBundle\Antispam;

class TRIAntispam
{
    private $mailer;
    private $locale;
    private $minLength;

    public function _construct(\Swift_Mailer $mailer, $locale, $minLength)
    {
        $this->mailer = $mailer;
        $this->locale = $locale;
        $this->minLength = (int) $minLength;
    }

    public function isSpam($text)
    {
        return strlen($text) < $this->minLength;
    }
}