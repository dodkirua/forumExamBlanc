<?php

namespace DodkiDodkirua\Forum\rua\Forum\Model\Manager;

use Dodkirua\Forum\Model\DB;
use Dodkirua\Forum\Model\Entity\Role;
use Dodkirua\Forum\Model\Entity\User;
use PDOStatement;

class UserManager extends Manager{

    /**
     * return a User by id
     * @param int $id
     * @return User|null
     */
    public static function getById (int $id) : ?User{
        $request = DB::getInstance()->prepare("SELECT * FROM user where sd_id= :id");
        $request->bindValue(":id",$id);
        return self::getOne($request);
    }

    /**
     * return a User by mail
     * @param string $mail
     * @return User|null
     */
    public static function getByMail(string $mail) : ?User{
        $request = DB::getInstance()->prepare("SELECT * FROM user where sd_mail = :mail");
        $request->bindValue(":mail",$mail);
        return self::getOne($request);
    }

    /**
     * return an array with all the User
     * @return array
     */
    public static function getAll() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM user");
        return self::getMany($request);
    }

    /**
     * return all user unchecked
     * @return array
     */
    public static function getAllUnchecked() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM user WHERE sd_checked_date is null ");
        return self::getMany($request);
    }

    /**
     * update on DB with id
     * @param int $id
     * @param array|null $var
     * @return bool
     */
    public static function update(int $id, array $var = null) : bool {
        if (is_null($var['username']) || is_null($var['mail']) || is_null($var['pass']) || is_null($var['checked_date'])
            || is_null($var['role_id'])) {
            $data = self::getById($id);
            if (is_null($var['username'])) {
                $var['username'] = $data->getUsername();
            }
            if (is_null($var['mail']) ) {
                $var['mail'] = $data->getMail();
            }
            if (is_null($var['pass']) ) {
                $var['pass'] = $data->getPass();
            }
            if (is_null($var['checked_date']) ) {
                $var['user_id'] = $data->getCheckedDate();
            }
            if (is_null($var['role_id']) ) {
                $var['role_id'] = $data->getRole()->getId();
            }
        }

        $request = DB::getInstance()->prepare("UPDATE user
                    SET sd_username = :username, sd_mail = :mail, sd_pass = :pass, sd_checked_date = :date, sd_role_id = :role
                    WHERE sd_id = :id
                    ");
        $request->bindValue(":id",$id);
        $request->bindValue(":username",mb_strtolower($var['username']));
        $request->bindValue(":mail",mb_strtolower($var['mail']));
        $request->bindValue(':pass', $var['pass']);
        $request->bindValue(":date",intval($var['checked_date']));
        $request->bindValue(":role",intval($var['role_id']));

        return $request->execute();
    }

    /**
     * insert  in DB
     * @param string $username
     * @param string $mail
     * @param string $pass
     * @param int $checked_date
     * @param int $role_id
     * @return bool
     */

    public static function add(string $username, string $mail, string $pass, int $checked_date = 0, int $role_id = 3) : bool {
        $request = DB::getInstance()->prepare("INSERT INTO user
        (sd_username, sd_mail, sd_pass, sd_checked_date, sd_role_id)
        VALUES (:username, :mail, :pass, :date, :role)
        ");
        $request->bindValue(":username",mb_strtolower($username));
        $request->bindValue(":mail",mb_strtolower($mail));
        $request->bindValue(':pass', $pass);
        $request->bindValue(":date", $checked_date);
        $request->bindValue(":role", $role_id);

        return $request->execute();
    }

    /**
     * delete  by id
     * @param int $id
     * @return bool
     */
    public static function delete(int $id) : bool {
        $request = DB::getInstance()->prepare("DELETE FROM user WHERE sd_id = :id");
        $request->bindValue(':id',$id);
        return $request->execute();
    }

    /**
     * private request for the getBy
     * @param PDOStatement $request
     * @return User|null
     */
    private static function getOne(PDOStatement $request ) : ?User {
        $request->execute();
        $data = $request->fetch();
        if ($data) {
            $role = RoleManager::getById($data['sd_role_id']);
            return new User(intval($data['sd_id']), $data['sd_username'], $data['sd_mail'],
                $data['sd_pass'], intval($data['sd_checked_date']), $role);
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
                    $role = RoleManager::getById($data['sd_role_id']);
                    $item = new User(intval($data['sd_id']), $data['sd_username'], $data['sd_mail'],
                        $data['sd_pass'], intval($data['sd_checked_date']), $role);
                    $array[] = $item;
                }
            }
        }
        return $array;

    }
}