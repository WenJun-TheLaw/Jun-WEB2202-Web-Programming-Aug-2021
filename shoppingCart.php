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
     * Finds a `user` from the `user` list
     * 
     * @param int $userID   The ID of the user being searched
     * @return $userResult  An array containing the game (could return `null`)
     */
    function findUser($userID)
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
     * Finds a `game` from a `user`'s shopping `cart`
     * 
     * @param int $gameID The ID of the game being searched
     * @param int $userID   The ID of the owner to the shopping cart
     * @return $cartResult  An array containing the game (could return `null`)
     */
    function findGameinCart($gameID, $userID)
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
     * Adds a `game` into a `user`'s shopping `cart`
     * 
     * @param int $userID   The ID of the owner to the shopping cart
     * @param int $gameID The ID of the game being searched
     */
    function addToCart($userID, $gameID)
    {
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
    }

    /**
     * Removes a `game` from a `user`'s shopping `cart`
     * 
     * @param int $userID   The ID of the owner to the shopping cart
     * @param int $gameID The ID of the game being searched
     */
    function deleteCartItem($userID, $gameID)
    {
        $query = "DELETE FROM tbl_cart WHERE userID = ? AND gameID = ?";
        
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
    }

    /**
     * Completely removes all `games` from a `user`'s shopping `cart`
     * 
     * @param int $userID   The ID of the owner to the shopping cart
     */
    function emptyCart($userID)
    {
        $query = "DELETE FROM cart WHERE userID = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $userID
            )
        );
        
        $this->updateDB($query, $params);
    }
}
