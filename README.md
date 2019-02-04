# Documentation

Unfortunately, I am returning the test unfinished, as I am a student and currently have no free time (assignements, projects, looking for an internship and applying in my possible future schools). Most of the work has been done, and what remains to be done is actually quite redundant (update and delete routes for the comments).

Please find in this repository the requested API having two functions :       

* Checking the type of a triangle based on the size of it sides,         
* CRUD enpoints for a blog, dealing with 2 entities : post and comment.

I chose to use PHP to create this API, and more precisely the Lumen framework (based on Laravel). The database was created in MySQL, you will be able to find its creation script in the `DOCS/` folder.

## Database

The database is made of 2 tables. One for the posts, and one for the comments.

![Table post](https://github.com/tsarrere/APISportCompass/blob/master/DOCS/post.png)

![Table comment](https://github.com/tsarrere/APISportCompass/blob/master/DOCS/comment.png)

The **COMMENT** table have a foreign key referencing *IDPOST* on the **POST** table : every comments must be attached to one and only one post.

## Routes

You will be able to find the routes in the `routes/` directory of Lumen. The callback functions are stored in the `app/Http/Controllers/BlogController.php` file.      
Here are the following requests you can send to the API.

### Triangle route

**Request : GET URL/triangle/{a}/{b}/{c}**   -- with a b and c being the sides of the triangle, must be numbers      
**Result** : a string with the type of the triangle made by these variables (equilateral, isosceles, scalene or incorrect)

### CRUD endpoints for a blog

#### Posts

##### Get a list of all posts :

**Request : GET URL/posts**  
    **Result** : a JSON array of posts    
        `{   
            idpost ,   
            postdate ,   
            postcontent ,   
            postauthor 
        }`

##### Get a specific post :

**Request : GET URL/posts/{id}**    -- with id being the id of the specific post wanted         
    **Result** : a JSON array with the request status, and the specific post    
        `{ "status" : false, "message" : "XXXX" }` if the data are incorrect (id)
        `{ "status" : true,  "post" : 
            {   
                idpost ,   
                postdate ,   
                postcontent ,   
                postauthor 
            }   
        }` with the specific post requested

##### Add a new post :

**Request : POST URL/posts**    -- with id being the id of the specific post wanted     
    **Data** : a JSON object with a post properties
        `{   
            idpost ,   
            postdate ,   
            postcontent ,   
            postauthor 
        }`       
    **Result** : a JSON array with the request status, and the newly created post    
        `{ "status" : false, "message" : "XXXX" }` if the data are incorrect
        `{ "status" : true,  "post" : 
            {   
                idpost ,   
                postdate ,   
                postcontent ,   
                postauthor 
            }   
        }` with the newly created post

##### Delete a specific post :

**Request : DELETE URL/posts/{id}**   -- with id being the id of the specific post deleted    
    **Result** :
        `{ "status" : false, "message" : "Selected post does not exist" }`
        `{ "status" : true,  "message" : "The post was deleted" }`

##### Update a post (id must not be changed) :

**Request : PUT URL/posts**
    **Data** : a JSON object with a post properties
        `{   
            idpost ,   
            postdate ,   
            postcontent ,   
            postauthor 
        }`       
    **Result** : a JSON array with the request status, and the newly created post    
        `{ "status" : false, "message" : "XXXX" }` if the data are incorrect
        `{ "status" : true,  "message" : "Selected post was updated" }`

#### Comment

##### Get a list of all comments :

**Request : GET URL/posts/{id}/comments**  -- with id being the id of the selected post    
    **Result** : a JSON array of comments    
        `{   
            idcomment ,  
            idpost ,     
            commentdate ,   
            commentcontent ,   
            commentauthor 
        }`

##### Get a specific comment :

**Request : GET URL/posts/{id}/comments/{idcom}**    -- with id being the id of the selected post and idcom being the id of its specific comment      
    **Result** : a JSON array with the request status, and the specific comment    
        `{ "status" : false, "message" : "XXXX" }` if the data are incorrec
        `{ "status" : true,  "com" : 
            {   
                idcomment ,  
                idpost ,     
                commentdate ,   
                commentcontent ,   
                commentauthor 
            }   
        }` with the specific comment requested

##### Add a new comment :

**Request : POST URL/posts/{id}/comments**    -- with id being the id of the selected post   
    **Data** : a JSON object with a comment properties
        `{   
            idcomment ,  
            idpost ,     
            commentdate ,   
            commentcontent ,   
            commentauthor 
        }`       
    **Result** : a JSON array with the request status, and the newly created post    
        `{ "status" : false, "message" : "XXXX" }` if the data are incorrect
        `{ "status" : true,  "com" : 
            {   
                idcomment ,  
                idpost ,     
                commentdate ,   
                commentcontent ,   
                commentauthor 
            }   
        }` with the newly created comment

## Bonus point

To have images as part of posts, I would have tried 2 solutions :

* **Uploading the picture in the server, then sending its URI through the API** : probably the most efficient one since the only limiting factor would be the free space on the server. But it also requires to do this in 2 steps.

* **Encoding the image as a string, and sending it directly through the API** : this solution is probably not optimal, since it would make requests longer and would not be viable for images having big resolutions. But doing so would send the image directly and would make it possible to store the image in the database.

## Tests

Tests have been conducted using the software Advanced Rest Client. Every route developed right now should be working using the previously specified routes and data.

This screen is an example using Advanced Rest Client to add a new comment : the request is made using a POST method on the corresponding route of the API,sending the required data in JSON (a post ID, the comment author) + the content of the comment. As you can see, the API returned a 200 HTTP code (succes) with the data of the new comment created.

![Screenshot de test utilisant Advanced Rest Client](https://github.com/tsarrere/APISportCompass/blob/master/DOCS/ScreenARC1.png)
