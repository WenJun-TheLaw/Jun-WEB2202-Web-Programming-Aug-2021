<?php
require_once "DBController.php";

class ShoppingCart extends DBController
{
    /**
     * Returns ALL the `games` in an array 
     * 
     * @return $gameResult An array of games
     */
    function getAllGames()
    {
        $query = "SELECT * FROM games";

        $gameResult = $this->getDBResult($query);
        return $gameResult;
    }
    /**
     * Returns all the `games` from a `user`'s shopping `cart`
     * 
     * @param int $userID   The ID of the owner to the shopping cart
     * @return $cartResult  An array of games
     */
    function getUserCart($userID)
    {
        $query = "SELECT games.* FROM games, cart WHERE cart.userID = ? AND games.gameID = cart.gameID ";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $userID
            )
        );
        
        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
    }
    /**
     * Returns all the `games` from a `user`'s `library`
     * 
     * @param int $userID       The ID of the owner to the shopping cart
     * @return $libraryResult   An array of games
     */
    function getUserLibrary($userID)
    {
        $query = "SELECT games.* FROM games, library WHERE library.userID = ? AND games.gameID = library.gameID ";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $userID
            )
        );

        $libraryResult = $this->getDBResult($query, $params);
        return $libraryResult;
    }
    /**
     * Finds a `game` from the `games` list
     * 
     * @param int $gameID   The ID of the game being searched
     * @return $gameResult  An array containing the game (could return `null`)
     */
    function findGame($gameID)
    {
        $query = "SELECT * FROM games WHERE gameID = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $gameID
            )
        );

        $gameResult = $this->getDBResult($query, $params);
        return $gameResult;
    }
    /**
     * Finds a `user` from the `user` list with ID
     * 
     * @param int $userID   The ID of the user being searched
     * @return $userResult  An array containing the user (could return `null`)
     */
    function findUserByID($userID)
    {
        $query = "SELECT * FROM user WHERE userID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $userID
            )
        );

        $userResult = $this->getDBResult($query, $params);
        return $userResult;
    }
    /**
     * Finds a `user` from the `user` list with email
     * 
     * @param   string $userEmail       The email of the user being searched
     * @return  array|null $userResult  An array containing the user (could return `null`)
     */
    function findUserByEmail($userEmail)
    {
        $query = "SELECT * FROM user WHERE email = ?";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $userEmail
            )
        );

        $userResult = $this->getDBResult($query, $params);
        return $userResult;
    }
    /**
     * Finds a `developer` from the `developer` list with ID
     * 
     * @param int $developerID  The ID of the developer being searched
     * @return $devResult       An array containing the user (could return `null`)
     */
    function findDeveloper($developerID)
    {
        $query = "SELECT * FROM developer WHERE developerID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $developerID
            )
        );

        $devResult = $this->getDBResult($query, $params);
        return $devResult;
    }
    /**
     * Finds a `game` from a `user`'s `library`.
     * 
     * @param int $userID       The ID of the owner to the shopping cart
     * @param int $gameID       The ID of the game being searched
     * @return $libraryResult   An array containing the game (could return `null`)
     */
    function findGameinLibrary($userID, $gameID)
    {
        $query = "SELECT * FROM library WHERE gameID = ? AND userID = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $gameID
            ),
            array(
                "param_type" => "i",
                "param_value" => $userID
            )
        );
        
        $libraryResult = $this->getDBResult($query, $params);
        return $libraryResult;
    }
    /**
     * Finds a `game` from a `user`'s shopping `cart`.
     * 
     * @param int $userID   The ID of the owner to the shopping cart
     * @param int $gameID   The ID of the game being searched
     * @return $cartResult  An array containing the game (could return `null`)
     */
    function findGameinCart($userID, $gameID)
    {
        $query = "SELECT * FROM cart WHERE gameID = ? AND userID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $gameID
            ),
            array(
                "param_type" => "i",
                "param_value" => $userID
            )
        );

        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
    }

    /**
     * Adds a `game` into a `user`'s shopping `cart`. 
     * 
     * Checks if:
     * 1. the user exist
     * 2. the game exists
     * 3. the user is of type "Gamer" 
     * 4. whether the game is already in the cart<br>
     * 
     * @param int $userID       The ID of the owner to the shopping cart
     * @param int $gameID       The ID of the game being searched
     * 
     * @return bool $success    Whether the operation was successful
     */
    function addToCart($userID, $gameID)
    {
        $user = $this->findUserByID($userID);
        $userExists = !is_null($user);
        $gameExists = !is_null($this->findGame($gameID));
        if(!is_null($user)){
            $userIsGamer = strcasecmp($user[0]["userType"], "Gamer") == 0;
        }
        $gameInCart = is_null($this->findGameinCart($userID, $gameID));
        //ONLY IF ALL: user exists, game exists, user is a "Gamer" and game is not already in cart
        if($userExists && $gameExists && $userIsGamer && $gameInCart){
            $query = "INSERT INTO cart (userID, gameID) VALUES (?, ?)";

            $params = array(
                array(
                    "param_type" => "i",
                    "param_value" => $userID
                ),
                array(
                    "param_type" => "i",
                    "param_value" => $gameID
                )
            );

            $this->updateDB($query, $params);
            return true;
        }
        else{
            return false;
        }

    }

    /**
     * Removes a `game` from a `user`'s shopping `cart`
     * 
     * @param int $userID       The ID of the owner to the shopping cart
     * @param int $gameID       The ID of the game being searched
     * 
     * @return bool $success    Whether the operation was successful
     */
    function deleteCartItem($userID, $gameID)
    {
        $gameExists = $this->findGameInCart($userID, $gameID);
        if(!is_null($gameExists)){
            $query = "DELETE FROM cart WHERE userID = ? AND gameID = ?";

            $params = array(
                array(
                    "param_type" => "i",
                    "param_value" => $userID
                ),
                array(
                    "param_type" => "i",
                    "param_value" => $gameID
                )
            );

            $this->updateDB($query, $params);
            return true;
        }
        else{
            return false;
        }
        
    }

    /**
     * Completely removes all `games` from a `user`'s shopping `cart`
     * 
     * @param int $userID       The ID of the owner to the shopping cart
     * 
     * @return bool $success    Whether the operation was successful
     */
    function emptyCart($userID)
    {
        $isCartEmpty = $this->getUserCart($userID);
        if(!is_null($isCartEmpty)){
            $query = "DELETE FROM cart WHERE userID = ?";

            $params = array(
                array(
                    "param_type" => "i",
                    "param_value" => $userID
                )
            );

            $this->updateDB($query, $params);
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Checkouts the `user`'s `cart`.
     * 
     * Adds all the `games` from `user`'s `cart` into the `user`'s `library`.
     * 
     * Then completely removes all `games` from a `user`'s shopping `cart`. 
     * 
     * @param int $userID       The ID of the owner to the shopping cart
     * 
     * @return bool $success    Whether the operation was successful
     */
    function checkOut($userID)
    {
        $cart = $this->getUserCart($userID);
        //If cart isn't empty
        if(!is_null($cart)){
            foreach($cart as $key => $value){
                //Adding games to library
                $query = "INSERT INTO library (userID, gameID)
                VALUES (?, ?)";

                $params = array(
                    array(
                        "param_type" => "i",
                        "param_value" => $userID
                    ),
                    array(
                        "param_type" => "i",
                        "param_value" => $cart[$key]["gameID"],
                    )
                );

                $this->updateDB($query, $params);

                //Incrementing developer's revenue
                $game = $this->findGame($cart[$key]["gameID"]);
                $this->addRevenue($game[0]["developerID"], $game[0]["price"]);
            }
            //Emptying cart
            $this->emptyCart($userID);
            return true;
        }
        //Cart is empty
        else{
            return false;
        }
    }
    /**
     * Adds a new `user` into the `user` table
     * 
     * @param string $email     The email of the user
     * @param string $password  The password (hashed) of the user
     * @param string $name      The name of the user
     * @param string $type      The type of the user: Gamer/ Developer/ Admin
     * @return bool  $success   Whether the operation was successful
     */
    private function addUser($email, $password, $name, $type)
    {
        //Check if user exists already
        $registered = $this->findUserByEmail($email);
        //User does not exist
        if(is_null($registered)){
            $query = "INSERT INTO user (email, password, name, userType)
                VALUES (?, ?, ?, ?)";

            $params = array(
                array(
                    "param_type" => "s",
                    "param_value" => $email
                ),
                array(
                    "param_type" => "s",
                    "param_value" => $password,
                ),
                array(
                    "param_type" => "s",
                    "param_value" => $name,
                ),
                array(
                    "param_type" => "s",
                    "param_value" => $type
                )
            );

            $this->updateDB($query, $params);
            return true;
        }
        else{
            return false;
        }
       
    }
    /**
     * Adds a new `gamer` into the `user` and `gamer` table 
     * 
     * @param string $email     The email of the gamer
     * @param string $password  The password (hashed) of the gamer
     * @param string $name      The name of the gamer
     * @return bool  $success   Whether the operation was successful
     */
    function addGamer($email, $password, $name)
    {
        //Add into `user` table first
        if ($this->addUser($email, $password, $name, 'Gamer')){
            //Get ID of the new user
            $user = $this->findUserByEmail($email);
            $userID = $user[0]['userID'];

            $query = "INSERT INTO gamer (userID, currency)
                VALUES (?, ?)";

            $params = array(
                array(
                    "param_type" => "s",
                    "param_value" => $userID,
                ),
                array(
                    "param_type" => "i",
                    "param_value" => 0
                )
            );

            $this->updateDB($query, $params);
            return true;
        }
        //Add user operation failed
        else{
            return false;
        }

       
    }
    /**
     * Adds a new `developer` into the `user` and `developer` table 
     * 
     * @param string $email         The email of the developer
     * @param string $password      The password (hashed) of the developer
     * @param string $name          The name of the developer
     * @param string $companySSN    The SSN of the developer's company
     * @return bool  $success       Whether the operation was successful
     */
    function addDeveloper($email, $password, $name, $companySSN)
    {
        //Add into `user` table first
        if($this->addUser($email, $password, $name, 'Developer')){
            //Get ID of the new user
            $user = $this->findUserByEmail($email);
            $developerID = $user[0]['userID'];

            //Default to 0 revenue and unverified (0)
            $query = "INSERT INTO developer (developerID, revenue, verified, companySSN)
                    VALUES (?, 0, 0, ?)";

            $params = array(
                array(
                    "param_type" => "s",
                    "param_value" => $developerID,
                ),
                array(
                    "param_type" => "s",
                    "param_value" => $companySSN
                )
            );

            $this->updateDB($query, $params);
            return true;
        }
        //Add user operation failed
        else{
            return false;
        }
    }
    /**
     * Increments a `developer`'s revenue  
     * 
     * @param string $developerID   The id of the developer
     * @param string $revenue       The amount to increment
     * @return bool  $success       Whether the operation was successful
     */
    function addRevenue($developerID, $revenue)
    {
        $developer = $this->findDeveloper($developerID);
        //Check whether the developer exists
        if(strcasecmp($developer[0]["developerID"], $developerID) == 0){
            //Increment revenue
            $totalRevenue = $revenue + $developer[0]["revenue"];
            echo "Total revenue: $totalRevenue";

            $query = "UPDATE developer
                    SET revenue = ?
                    WHERE developerID = ?";

            $params = array(
                array(
                    "param_type" => "d",
                    "param_value" => $totalRevenue,
                ),
                array(
                    "param_type" => "i",
                    "param_value" => $developerID
                )
            );

            $this->updateDB($query, $params);
            return true;
        }
        //Add revenue operation failed
        else {
            return false;
        }
    }

}
