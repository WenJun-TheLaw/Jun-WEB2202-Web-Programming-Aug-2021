<?php
require_once "DBController.php";

class ShoppingCart extends DBController
{

    function findAllGames()
    {
        $query = "SELECT * FROM games";
        
        $productResult = $this->getDBResult($query);
        return $productResult;
    }

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

    function getProductByCode($gameCode)
    {
        $query = "SELECT * FROM games WHERE code = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $gameCode
            )
        );
        
        $productResult = $this->getDBResult($query, $params);
        return $productResult;
    }

    function getCartItemByProduct($gameCode, $userID)
    {
        $query = "SELECT * FROM tbl_cart WHERE gameCode = ? AND userID = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $gameCode
            ),
            array(
                "param_type" => "i",
                "param_value" => $userID
            )
        );
        
        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
    }

    function addToCart($cartID, $userID, $gameCode)
    {
        $query = "INSERT INTO cart (cartID, userID, gameCode) VALUES (?, ?, ?)";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $cartID
            ),
            array(
                "param_type" => "i",
                "param_value" => $userID
            ),
            array(
                "param_type" => "i",
                "param_value" => $gameCode    
            )
        );
        
        $this->updateDB($query, $params);
    }

    function updateCartQuantity($quantity, $cart_id)
    {
        $query = "UPDATE tbl_cart SET  quantity = ? WHERE id= ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $quantity
            ),
            array(
                "param_type" => "i",
                "param_value" => $cart_id
            )
        );
        
        $this->updateDB($query, $params);
    }

    function deleteCartItem($cart_id)
    {
        $query = "DELETE FROM tbl_cart WHERE id = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $cart_id
            )
        );
        
        $this->updateDB($query, $params);
    }

    function emptyCart($userID)
    {
        $query = "DELETE FROM tbl_cart WHERE userID = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $userID
            )
        );
        
        $this->updateDB($query, $params);
    }
}
