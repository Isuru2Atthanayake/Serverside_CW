<?php
defined('BASEPATH') or exit('No direct script access allowed');

//model for post related database tasks
class Postmod extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    //insert rows to post table trhis creates a post for a user


    // create post function with question
    function createPost($username, $questtagid, $caption, $question)
    {
        $users = $this->db->get_where('users', array('Username' => $username));
        $userId= $users->row()->UserId;
        $data = array('UserId' => $userId, 'QuesttagId' => $questtagid, 'Question' => $question,'Caption' => $caption);
        if ($this->db->insert('posts', $data)) {
            return True;
        } else {
            return False;
        }
    }

    //query post table to get posts from a user
    function getPostsfromUsername($username)
    {
        $users = $this->db->get_where('users', array('Username' => $username));
        $userId= $users->row()->UserId;
        $query=$this->db->query( "SELECT * FROM posts WHERE UserId=".$userId." ORDER BY Timestamp DESC");
        return $query->result();
    }
    //get all tags from db
    function getQuesttag(){
        $query = $this->db->get('questtag');
        if ($query) {
            return $query->result();
        }
        return NULL;
    }

    //query database to get posts from users

//    function getPostsofFollowing($username){
//        $users = $this->db->get_where('users', array('Username' => $username));
//        $userId= $users->row()->UserId;
//        $query=$this->db->query("SELECT posts.*, users.Username, questtag.QuesttagName
//        FROM posts
//        JOIN users ON posts.UserId = users.UserId
//        JOIN questtag ON posts.QuesttagId = questtag.QuesttagId
//        ORDER BY posts.Timestamp DESC");
//        return $query->result();
//    }

        function getPostsofQuestions($username){
        $users = $this->db->get_where('users', array('Username' => $username));
        $userId= $users->row()->UserId;
        $query=$this->db->query("SELECT posts.*, users.Username, questtag.QuesttagName 
        FROM posts 
        JOIN users ON posts.UserId = users.UserId 
        JOIN questtag ON posts.QuesttagId = questtag.QuesttagId 
        ORDER BY posts.Timestamp DESC");
        return $query->result();
    }


    //query table to get the comments per post
    function getComments($postid){
        $comments = $this->db->query( "SELECT comments.*,users.Username FROM comments JOIN users ON users.UserId=comments.UserId WHERE PostId=".$postid." ORDER BY Timestamp DESC");
        return $comments->result();
    }
    //insert rows to comments table
    function addComments($postid, $comment, $username){
        $users = $this->db->get_where('users', array('Username' => $username));
        $userId= $users->row()->UserId;
        $posts = $this->db->get_where('posts', array('PostId' => $postid));
        $postuser= $posts->row()->UserId;
        $query=$this->db->insert('comments', array('UserId' => $userId,'PostId' => $postid,'CommentBody' => $comment));
//        $this->db->insert('notification', array('FromUser' => $userId,'UserId' => $postuser, 'PostId' => $postid, 'CommentBody' => $comment));
        return $query;
    }
    //query like table to check if a user has liked a post
    public function checklikes($username, $postid){
        $users = $this->db->get_where('users', array('Username' => $username));
        $userId= $users->row()->UserId;
        $res = $this->db->get_where('likes', array('UserId' => $userId,'PostId' => $postid));
        if ($res->num_rows() == 1){
            return true;
        }
        else{
            return false;
        }
    }
    //insert row to likes and notification tables
    public function likepost($username, $postid){
        $users = $this->db->get_where('users', array('Username' => $username));
        $userId= $users->row()->UserId;
        $posts = $this->db->get_where('posts', array('PostId' => $postid));
        $postuser= $posts->row()->UserId;
        $res = $this->db->get_where('likes', array('UserId' => $userId,'PostId' => $postid));
        if ($res->num_rows() == 1){
            $query=$this->db->delete('likes', array('UserId' => $userId,'PostId' => $postid));
//            $this->db->delete('notification', array('FromUser' => $userId,'UserId' => $postuser, 'PostId' => $postid, 'Notification'=>'Liked your post!'));
            return "deleted";
        }
        else{
            $query=$this->db->insert('likes', array('UserId' => $userId,'PostId' => $postid));
//            $this->db->insert('notification', array('FromUser' => $userId,'UserId' => $postuser, 'PostId' => $postid, 'Notification'=>'Liked your post!'));
            return "added";
        }
    }
    //query post table to get posts from tags
    // get by the tag name
//    public function postsFromLocation($questtagid){
//        $res = $this->db->get_where('posts', array('QuesttagId' => $questtagid));
//        return $res->result();
//    }
//

//used in posts.php controller
    public function postsFromQuesttag($questtagid){
        $res = $this->db->get_where('posts', array('QuesttagId' => $questtagid));
        return $res->result();
    }
    //query tags by tag Id
    public function getQuesttagbyId($questtagid){
        $res = $this->db->get_where('questtag', array('QuesttagId' => $questtagid));
        return $res->row();
    }
    //query posts by post id
    // get by the tag name , remove image
    public function postfromid($postid){
        $res = $this->db->query( "SELECT posts.*, users.Username, users.UserImage, questtag.QuesttagName FROM posts JOIN users ON users.UserId=posts.UserId JOIN questtag ON questtag.QuesttagId=posts.QuesttagId WHERE posts.PostId =".$postid);
        return $res->row();
    }
    //get number of rows from likes table according to post id
    public function likeCount($postid){
        $res2 = $this->db->get_where('likes', array('PostId' => $postid));
        $likes=$res2->num_rows();
        return $likes;
    }
} 