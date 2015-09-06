<?php
namespace prayer\models;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="nim_prayer")
 */
class Prayer
{
	/**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

   	/**
   	* @ORM\Column(type="date", name="`date`", unique=true, nullable=false)
   	*/
   	protected $date;

    /**
    * @ORM\Column(type="string", length=10000, name="`prayer_request`", nullable=false)
    */
    protected $prayerRequest;

    /**
    * @ORM\Column(type="string", name="`verse`", nullable=false)
    */
    protected $verse;

    /**
    * @ORM\Column(type="string", length=10000, name="`verse_message`", nullable=false)
    */
    protected $verseMessage;

    /**
    * @ORM\Column(type="string", name="`image_url`", nullable=false)
    */
    protected $imageURL;

    public function getId()
    {
    	return $this->id;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setPrayerRequest($pr)
    {
        $this->prayerRequest = $pr;
    }

    public function getPrayerRequest()
    {
        return $this->prayerRequest;
    }

    public function setVerse($verse)
    {
        $this->verse = $verse;
    }

    public function getVerse()
    {
        return $this->verse;
    }

    public function setVerseMessage($verseMsg)
    {
        $this->verseMessage = $verseMsg;
    }

    public function getVerseMessage()
    {
        return $this->verseMessage;
    }

    public function setImageURL($url)
    {
        $this->imageURL = $url;
    }

    public function getImageURL()
    {
        return $this->imageURL;
    }
}
