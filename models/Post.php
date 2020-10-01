<?php
    class Post {
        //db stuff
        private $conn;
        private $table = 'posts';

        //post properties
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        //constructor with db
        public function __construct($db){
            $this->conn = $db;
        }

        //method to get posts
        public function read(){
            //create query (A JOIN IS USED)
            $query = 
            'SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at 
            FROM 
                ' .$this->table. ' p  
            LEFT JOIN
                categories c ON p.category_id = c.id
            ORDER BY
                p.created_at DESC
            ';

            //create prepared statement | #stmt == statement
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();

            return $stmt;
        }

        //GET SINGLE POST
        public function read_single_post() {
            //uses a positional param
            $query = 
            'SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at 
            FROM 
                ' .$this->table. ' p  
            LEFT JOIN
                categories c ON p.category_id = c.id
            WHERE 
                p.id = ?
            LIMIT 0,1
            ';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind id
            $stmt->bindParam(1, $this->id);

            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            //set properties
            $this->title = $title;
            $this->body = $body;
            $this->author = $author;
            $this->category_id = $category_id;
            $this->category_name = $category_name;
        }

        //CREATE POST
        public function create(){
            //create query | (USES NAMED PARAMS)
            $query = 
            '
            INSERT INTO '. $this->table .'
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
            ';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            //bind the data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);

            //execute query
            if($stmt->execute()){
                return true;
            } 

            //print error if error
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

        //UPDATE POST 
        public function update(){
            //create query | (USES NAMED PARAMS)
            $query = 
            '
            UPDATE '. $this->table .'
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
            WHERE 
                id = :id
            ';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind the data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);

            //execute query
            if($stmt->execute()){
                return true;
            } 

            //print error if error
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

        //DELETE POST
        public function delete(){
            $query = 
            '
            DELETE FROM '.$this->table.'
            WHERE id= :id
            ';

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()){
                return true;
            }

            printf("Error : %s.\n", $stmt->error);
            return false;

        }

    }