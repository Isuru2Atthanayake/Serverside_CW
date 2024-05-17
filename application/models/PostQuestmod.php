<?php
defined('BASEPATH') or exit('No direct script access allowed');

//model for post related database tasks
class PostQuestmod extends CI_Model
{
    public function __construct()// this is used to load thedatabase
    {
        parent::__construct();
        $this->load->database();
    }
    //insert rows to post table trhis creates a post for a user


    // tHIS IS USED TO create post function with question
    function createPost($username, $questtagid, $questtitle, $question)
    {
        $users = $this->db->get_where('users', array('Username' => $username));
        $userId= $users->row()->UserId;
        $data = array('UserId' => $userId, 'QuesttagId' => $questtagid, 'Question' => $question,'QuestTitle' => $questtitle);
        if ($this->db->insert('posts', $data)) {
            return True;
        } else {
            return False;
        }
    }

    //query post table to get posted questions related to a user
    function getPostsfromUsername($username)
    {
        $users = $this->db->get_where('users', array('Username' => $username));
        $userId= $users->row()->UserId;
        $query=$this->db->query( "SELECT * FROM posts WHERE UserId=".$userId." ORDER BY Timestamp DESC");
        return $query->result();
    }
    //get all the questiontags from db
    function getQuesttag(){
        $query = $this->db->get('questtag');
        if ($query) {
            return $query->result();
        }
        return NULL;
    }
    //get all the posted questions from db
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


    //query table to get the comments related to the posted question
    function getComments($postid){
        $comments = $this->db->query( "SELECT comments.*,users.Username FROM comments JOIN users ON users.UserId=comments.UserId WHERE PostId=".$postid." ORDER BY Timestamp DESC");
        return $comments->result();
    }
    //used to add comments to the posted questions
    function addComments($postid, $comment, $username){
        $users = $this->db->get_where('users', array('Username' => $username));
        $userId= $users->row()->UserId;
        $posts = $this->db->get_where('posts', array('PostId' => $postid));
        $postuser= $posts->row()->UserId;
        $query=$this->db->insert('comments', array('UserId' => $userId,'PostId' => $postid,'CommentBody' => $comment));
        return $query;
    }
    //this query including the rate table is used to check if a user has rated a posted question
    public function checkratings($username, $postid){
        $users = $this->db->get_where('users', array('Username' => $username));
        $userId= $users->row()->UserId;
        $res = $this->db->get_where('ratings', array('UserId' => $userId,'PostId' => $postid));
        if ($res->num_rows() == 1){
            return true;
        }
        else{
            return false;
        }
    }
    //this is used to rate a posted question
    public function ratepost($username, $postid){
        $users = $this->db->get_where('users', array('Username' => $username));
        $userId= $users->row()->UserId;
        $posts = $this->db->get_where('posts', array('PostId' => $postid));
        $postuser= $posts->row()->UserId;
        $res = $this->db->get_where('ratings', array('UserId' => $userId,'PostId' => $postid));
        if ($res->num_rows() == 1){
            $query=$this->db->delete('ratings', array('UserId' => $userId,'PostId' => $postid));
            return "deleted";
        }
        else{
            $query=$this->db->insert('ratings', array('UserId' => $userId,'PostId' => $postid));
            return "added";
        }
    }

    public function ratecount($postid){
        $res2 = $this->db->get_where('ratings', array('PostId' => $postid));
        $ratings=$res2->num_rows();
        return $ratings;
    }
    //query post table to get posts from tags
    // get by the tag name

//used in posts.php controller
    public function postsFromQuesttag($questtagid){
        $res = $this->db->get_where('posts', array('QuesttagId' => $questtagid));
        return $res->result();
    }
    //  This is used to get the questtag by the related id
    public function getQuesttagbyId($questtagid){
        $res = $this->db->get_where('questtag', array('QuesttagId' => $questtagid));
        return $res->row();
    }

//this is used to get the postedquestion details from the id
    public function postfromid($postid){
        $res = $this->db->query( "SELECT posts.*, users.Username, users.UserImage, questtag.QuesttagName FROM posts JOIN users ON users.UserId=posts.UserId JOIN questtag ON questtag.QuesttagId=posts.QuesttagId WHERE posts.PostId =".$postid);
        return $res->row();
    }

}