<?php
/**
 * Created by PhpStorm.
 * User: edz
 * Date: 2017-06-22
 * Time: 4:56 PM
 */

namespace Application\Controller\Model;

class Picture{

    private $id;
    private $authorName;
    private $pictureTitle;
    private $pictureDescription;
    private $filename;
    private $pictureInstagram;

    /**
     * @return mixed
     */
    public function getPictureInstagram()
    {
        return $this->pictureInstagram;
    }

    /**
     * @param mixed $pictureInstagram
     */
    public function setPictureInstagram($pictureInstagram)
    {
        $this->pictureInstagram = $pictureInstagram;
    }

    /**
     * @return mixed
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param mixed $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return mixed
     */
    public function getPictureTitle()
    {
        return $this->pictureTitle;
    }

    /**
     * @param mixed $pictureTitle
     */
    public function setPictureTitle($pictureTitle)
    {
        $this->pictureTitle = $pictureTitle;
    }

    /**
     * @return mixed
     */
    public function getPictureDescription()
    {
        return $this->pictureDescription;
    }

    /**
     * @param mixed $pictureDescription
     */
    public function setPictureDescription($pictureDescription)
    {
        $this->pictureDescription = $pictureDescription;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function getJSONArray(){
        return [
          'id' => $this->getId(),
          'authorName' => $this->getAuthorName(),
          'pictureTitle' => $this->getPictureTitle(),
          'pictureDescription' => $this->getPictureDescription(),
          'filename' => $this->getFilename(),
          'pictureInstagram' => $this->getPictureInstagram()
        ];
    }

    public function getArray(){
        return [
            'pictures_id' => $this->getId(),
            'authors_id' => $this->getAuthorName(),
            'pictures_title' => $this->getPictureTitle(),
            'pictures_filename' => $this->getFilename(),
            'pictures_description' => $this->getPictureDescription(),
            'pictures_instagram' => $this->getPictureInstagram()
        ];
    }

}