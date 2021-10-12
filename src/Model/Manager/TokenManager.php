<?php

namespace Dodkirua\Forum\Model\Manager;

use Dodkirua\Forum\Model\DB;
use Dodkirua\Forum\Model\Entity\Token;
use PDOStatement;

class TokenManager extends Manager{

    /**
     * return a Token by id
     * @param int $id
     * @return Token|null
     */
    public static function getById (int $id) : ?Token{
        $request = DB::getInstance()->prepare("SELECT * FROM token where tk_id= :id");
        $request->bindValue(":id",$id);
        return self::getOne($request);
    }

    /**
     * return a Token by user
     * @param int $user_id
     * @return Token|null
     */
    public static function getByUser(int $user_id): Token{
        $request = DB::getInstance()->prepare("SELECT * FROM token where tk_user_id = :user");
        $request->bindValue(":user",$user_id);
        return self::getOne($request);
    }

    /**
     * return an array with all the Token
     * @return array
     */
    public static function getAll() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM token");
        return self::getMany($request);
    }

    /**
     * return all token by validity
     * @param int $date
     * @return array
     */

     public static function getAllByCategory(int $date) : array {
         $request = DB::getInstance()->prepare("SELECT * FROM token WHERE tk_validity < :date");
         $request->bindValue(":date",$date);
         return self::getMany($request);
     }

    /**
     * update on DB with id
     * @param int $id
     * @param array|null $var
     * @return bool
     */
    public static function update(int $id, array $var = null) : bool{
        if (is_null($var['token']) || is_null($var['validity']) || is_null($var['user_id']) ) {
            $data = self::getById($id);
            if (is_null($var['token'])) {
                $var['token'] = $data->getToken();
            }
            if (is_null($var['validity']) ) {
                $var['validity'] = $data->getValidity();
            }
            if (is_null($var['user_id']) ) {
                $var['user_id'] = $data->getUser()->getId();
            }
        }

        $request = DB::getInstance()->prepare("UPDATE token
                    SET tk_token = :token, tk_user_id = :user, tk_validity = :val
                    WHERE tk_id = :id
                    ");
        $request->bindValue(":id",$id);
        $request->bindValue(":token",mb_strtolower($var['token']));
        $request->bindValue(":val",intval($var['validity']));
        $request->bindValue(":user",intval($var['user_id']));

        return $request->execute();
    }

    /**
     * insert  in DB
     * @param string $token
     * @param int $validity
     * @param int $user_id
     * @return bool
     */
    public static function add(string $token, int $validity, int $user_id) : bool {
        $request = DB::getInstance()->prepare("INSERT INTO token
        (tk_token, tk_validity, tk_user_id)
        VALUES (:token, :val, :user)
        ");
        $request->bindValue(":token",$token);
        $request->bindValue(":val",$validity);
        $request->bindValue(":user",$user_id);

        return $request->execute();
    }

    /**
     * delete  by id
     * @param int $id
     * @return bool
     */
    public static function delete(int $id) : bool {
        $request = DB::getInstance()->prepare("DELETE FROM token WHERE tk_id = :id");
        $request->bindValue(':id',$id);
        return $request->execute();
    }

    /**
     * private request for the getBy
     * @param PDOStatement $request
     * @return Token|null
     */
    private static function getOne(PDOStatement $request ) : ?Token {
        $request->execute();
        $data = $request->fetch();
        if ($data) {
            $user = UserManager::getById($data['tk_user_id']);
            return new Token(intval($data['tk_id']), $data['tk_token'], intval($data['tk_validity']), $user);
        }
        return null;
    }

    /**
     * private request for the getAll
     * @param PDOStatement $request
     * @return array
     */
    private static function getMany(PDOStatement $request) : array {
        $array = [];
        $result = $request->execute();
        if ($result){
            $datum = $request->fetchAll();
            if ($datum) {
                foreach ($datum as $data) {
                    $user = UserManager::getById($data['tk_user_id']);
                    $item = new Token(intval($data['tk_id']), $data['tk_token'], intval($data['tk_validity']), $user);
                    $array[] = $item;
                }
            }
        }
        return $array;

    }

}