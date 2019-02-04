<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    // ------------------- POST -------------------

    /**
     * Return a list of all posts
     * 
     * @return json => Array of posts
     */
    public function postList(){
        $postsArray = array();
        $posts = DB::select('SELECT * FROM POST');
        foreach ($posts as $post) {
            $postsArray[] = get_object_vars($post);
        }
        return response()->json($postsArray);
    }

    /**
     * Return a specific post selected by its ID
     * @param int $idpost => ID of the selected post
     * @return json => Status, post
     */
    public function post($idpost){
        // Check if post exists
        $res = DB::select("SELECT COUNT(*) AS nb FROM POST WHERE IDPOST=?",[$idpost]);
        if ($res[0]->nb == 0) {
            return response()->json(["status"=>false,"message"=>"Selected post does not exist"],200);
        }
        // Select the post
        $post = DB::select("SELECT * FROM POST WHERE IDPOST=?",[$idpost]);
        return response()->json(["status"=>true, "post"=>$post[0]]);
    }

    /**
     * Add a new post
     * @param Request $request => json object of the new post
     * @return json => Status, post
     */
    public function postAdd(Request $request){
        // Check if required values are valid
        $validator = Validator::make($request->all(), [
            'postauthor' => 'required|string'
            ]);
            
        // If validator fails, return errors
        if ($validator->fails()) {
            $errors = json_encode($validator->errors()->all());
            return response()->json(["status"=>false, "message"=>"The post was not added".$errors], 200);
        }
        // Create an incremented ID, not required if value is AI in database
        $data = $request->all();
        $id = DB::select("SELECT MAX(IDPOST) AS maximum FROM POST");
        $data["idpost"] = $id[0]->maximum + 1;
        // Add today's datetime to postDate
        $data["postdate"] = date("Y-m-d H:i:s");
        // Add the new post to the database
        $result=DB::table('POST')->insert($data);
        return response()->json(["status"=>true, "post"=>$data]);
    }

    /**
     * Delete a post selected by its id
     * @param int $idpost => ID of the selected post
     * @return json => Status, message
     */
    public function postDelete($idpost){
        // Check if post exists
        $res = DB::select("SELECT COUNT(*) AS nb FROM POST WHERE IDPOST=?",[$idpost]);
        if ($res[0]->nb == 0) {
            return response()->json(["status"=>false,"message"=>"Selected post does not exist"],200);
        }
        // Delete the post
        $result = DB::table('POST')->where('IDPOST','=',$idpost)->delete();
        return response()->json(["status"=>true,"message"=>"The post was deleted"],200);
    }

    /**
     * Update an existing post
     * @param Request $request => json object of the post updated
     * @return json => Status, message
     */
    public function postUpdate(Request $request){
        // Check if required values are valid
        $validator = Validator::make($request->all(), [
            'idpost' => 'required|integer',
            'postauthor' => 'required|string'
            ]);
    
        // If validator fails, return errors
        if ($validator->fails()) {
            $errors = json_encode($validator->errors()->all());
            return response()->json(["status"=>false, "message"=>"Selected post was not updated".$errors], 200);
        }
        $data = $request->all();
        $idpost = $data["idpost"];

        // Check if post exists
        $res = DB::select("SELECT COUNT(*) AS nb FROM POST WHERE IDPOST=?",[$idpost]);
        if ($res[0]->nb == 0) {
            return response()->json(["status"=>false,"message"=>"Selected post does not exist"],200);
        }
        // Update post
        $result=DB::table('POST')->where('IDPOST',$idpost)->update($data);
        return response()->json(["status"=>true,"message"=>"Selected post was updated"]);
    }

    // ------------------ COMMENTS ------------------
    /**
     * Return all comments from a post selected by its ID
     * @param int $idpost => ID of the selected post
     * @return json => Array of comments
     */
    public function comList($idpost){
        $comsArray = array();
        // Check if post exists
        $res = DB::select("SELECT COUNT(*) AS nb FROM POST WHERE IDPOST=?",[$idpost]);
        if ($res[0]->nb == 0) {
            return response()->json(["status"=>false,"message"=>"Selected post does not exist"],200);
        }
        // Select the comments        
        $coms = DB::select("SELECT * FROM COMMENT WHERE IDPOST=?",[$idpost]);
        foreach ($coms as $com) {
            $comsArray[] = get_object_vars($com);
        }
        return response()->json($comsArray);
    }

    /**
     * Return a specific comment selected by its ID from a specific post
     * @param int $idpost $idcom => ID of the selected post, ID of the selected comment
     * @return json => Status, com
     */
    public function com($idcom, $idpost){
        // Check if post exists
        $resPost = DB::select("SELECT COUNT(*) AS nb FROM POST WHERE IDPOST=?",[$idpost]);
        if ($resPost[0]->nb == 0) {
            return response()->json(["status"=>false,"message"=>"Selected post does not exist"],200);
        }

        // Check if comment exists
        $resCom = DB::select("SELECT COUNT(*) AS nb FROM COMMENT WHERE IDPOST=? AND IDCOMMENT=?",[$idpost, $idcom]);
        if ($resCom[0]->nb == 0) {
            return response()->json(["status"=>false,"message"=>"Selected comment does not exist"],200);
        }

        // Select the comment
        $com = DB::select("SELECT * FROM COMMENT WHERE IDPOST=? AND IDCOMMENT=?",[$idpost, $idcom]);
        return response()->json(["status"=>true, "com"=>$com[0]]);
    }

    /**
     * Add a new comment
     * @param Request $request => json object of the new comment
     * @return json => Status, com
     */
    public function comAdd(Request $request){
        // Check if required values are valid
        $validator = Validator::make($request->all(), [
            'idpost' => 'required|integer',
            'commentauthor' => 'required|string'
            ]);
            
        // If validator fails, return errors
        if ($validator->fails()) {
            $errors = json_encode($validator->errors()->all());
            return response()->json(["status"=>false, "message"=>"The comment was not added".$errors], 200);
        }
        
        // Create an incremented ID, not required if value is AI in database
        $data = $request->all();
        $id = DB::select("SELECT MAX(COMMENT.IDCOMMENT) AS maximum FROM COMMENT INNER JOIN POST ON COMMENT.IDPOST = POST.IDPOST"
        . " WHERE COMMENT.IDPOST = ?", [$data["idpost"]]);
        $data["idcomment"] = $id[0]->maximum + 1;
        // Add today's datetime to commentDate
        $data["commentdate"] = date("Y-m-d H:i:s");
        // Add the new comment to the database
        $result=DB::table('COMMENT')->insert($data);
        return response()->json(["status"=>true, "com"=>$data]);
    }
}