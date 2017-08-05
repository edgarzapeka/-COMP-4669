<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\Model\Author;
use Application\Controller\Model\Comment;
use Application\Database\AuthorsTable;
use Application\Database\CommentsTable;
use Application\Database\PicturesTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Controller\Model\Picture;
use Instagram\Auth;
use Instagram\Instagram;

class IndexController extends AbstractActionController
{
    private $authorsTable;
    private $picturesTable;
    private $commentsTable;

    private $auth;

    public function __construct()
    {
        $this->auth = new Auth([
            'client_id' => '',
            'client_secret' => '',
            'redirect_uri' => 'http://localhost:8888/import',
            'scope' => ['public_content']
        ]);

       $this->authorsTable = new AuthorsTable('assignment2', 'root', '');
       $this->picturesTable = new PicturesTable('assignment2', 'root', '');
       $this->commentsTable = new CommentsTable('assignment2', 'root', '');

    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function getPicturesAction(){

        $posts = [];
        $start = 1;
        $count = 8;

        $pictures = $this->picturesTable->getPictures();

        foreach ($pictures as $picture){
            if ($start++ > $count){
                break;
            }

            $post = new Picture();
            $post->setId($picture['pictures_id']);
            $post->setFilename($picture['pictures_filename']);
            $post->setPictureDescription($picture['pictures_description']);
            $post->setPictureTitle($picture['pictures_title']);
            $post->setPictureInstagram($picture['pictures_instagram']);

            $author = $this->authorsTable->getAuthor($picture['authors_id']);
            $post->setAuthorName(($author->valid()) ? $author->current()['authors_firstname'] . " " . $author->current()['authors_lastname'] : Null);

            $posts[] = $post->getJSONArray();
        }

        return new JsonModel($posts);
    }

    public function getPicturesIntervalAction(){

        //sorry for duplication

        $start = $this->getRequest()->getQuery('start');
        $count = $this->getRequest()->getQuery('count');

        $posts = [];
        $flag = 1;
        $pictures = $this->picturesTable->getPictures();

        foreach ($pictures as $picture){
            $post = new Picture();
            $post->setId($picture['pictures_id']);
            $post->setFilename($picture['pictures_filename']);
            $post->setPictureDescription($picture['pictures_description']);
            $post->setPictureTitle($picture['pictures_title']);
            $post->setPictureInstagram($picture['pictures_instagram']);

            $author = $this->authorsTable->getAuthor($picture['authors_id']);
            $post->setAuthorName(($author->valid()) ? $author->current()['authors_firstname'] . " " . $author->current()['authors_lastname'] : Null);

            $posts[] = $post->getJSONArray();
        }

        return new JsonModel(array_slice($posts, $start, $count));
    }

    public function commentsAction(){
        $data = [];

        $pictureId = $this->getRequest()->getQuery('pictures_id');
        $comments = $this->commentsTable->getComments($pictureId);

        foreach($comments as $comment){
            $data[] = ['comment' => $comment['comments_comment']];
        }

        return new JsonModel(['comments' => $data]);
    }

    public function searchAction(){
        $posts = [];

        $word = $this->getRequest()->getQuery('word');

        $pictures = $this->picturesTable->getPictures();

        foreach ($pictures as $picture){
            if ( $word == "" || preg_match("/$word/i", $picture['pictures_title'])){
                $post = new Picture();
                $post->setId($picture['pictures_id']);
                $post->setFilename($picture['pictures_filename']);
                $post->setPictureDescription($picture['pictures_description']);
                $post->setPictureTitle($picture['pictures_title']);
                $post->setPictureInstagram($picture['pictures_instagram']);

                $author = $this->authorsTable->getAuthor($picture['authors_id']);
                $post->setAuthorName(($author->valid()) ? $author->current()['authors_firstname'] . " " . $author->current()['authors_lastname'] : Null);

                $posts[] = $post->getJSONArray();
            }
        }

        return new JsonModel($posts);
    }

    public function authorizeAction(){
        $this->auth->authorize();
    }

    public function importAction(){
        $data = [];

        //Yeah, I know that this approach is not very robust, but for the assignment3 looks good enough.
        //I didn't want to retrieve id after the author was inserted to the database and was assigned autoincrement id.
        //If you know another way to do it I would be fantastic to get a feedback from you :)
        $authorId = rand(1, 99999);

        $code = $this->getRequest()->getQuery('code');

        $token = $this->auth->getAccessToken($code);


        $instagram = new Instagram();
        $instagram->setAccessToken($token);

        $user = $instagram->getCurrentUser();
        $media = $user->getMedia();

        $pictureTmp = new Picture();
        $pictureTmp->setPictureTitle('');
        $pictureTmp->setPictureDescription('');
        $pictureTmp->setAuthorName($authorId);
        $pictureTmp->setFilename('');

        $commentTmp = new Comment();

        $authorTmp = new Author();
        $authorTmp->setId($authorId);
        $authorTmp->setLastName("");
        $authorTmp->setFirstName($media[0]->getUser()->getFullName());

        $this->authorsTable->insertAuthor($authorTmp->getArray());


        foreach ($media as $picture){
            $pictureId = rand(1, 99999);

            $pictureTmp->setPictureInstagram($picture->getStandardRes()->url);
            $pictureTmp->setId($pictureId);

            if ($picture->getComments()->getData() != []){
                $commentTmp->setPictureId($pictureId);
                foreach ($picture->getComments()->getData() as $comment){
                        $commentTmp->setComment($comment->text);
                        $this->commentsTable->insertComment($commentTmp->getArray());
                }
            }

            $this->picturesTable->insertPicture($pictureTmp->getArray());
        }

        return $this->redirect()->toRoute('/');
    }

}
