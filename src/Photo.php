<?php


namespace App;

class Photo extends Media
{
    private string $altText;
    private string $url;
    private Tweet $tweet;

    public function __construct(string $caption, int $width, int $height, string $altText)
    {
        $this->altText = $altText;
        parent::__construct($caption, $width, $height);
    }

    /**
     * @return string
     */
    public function getAltText(): string
    {
        return $this->altText;
    }

    /**
     * @param string $altText
     */
    public function setAltText(string $altText): void
    {
        $this->altText = $altText;
    }

    function getSummary(): string
    {
        return "<p>{$this->getCaption()} ({$this->getAltText()}) [{$this->getWidth()}x{$this->getHeight()}]</p>";
    }

    public function setUrl(string $url):void
    {
        $this->url = $url;
    }

    public function getUrl():string
    {
        return $this->url;
    }

    public function setTweet(Tweet $tweet):void
    {
        $this->tweet = $tweet;
    }

    public function getTweet():Tweet
    {
        return $this->tweet;
    }
}