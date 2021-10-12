<?php

namespace Model\Manager;

use Model\DB;
use Model\Entity\Closed;
use PDOStatement;

class ClosedManager extends Manager{

    /**
     * return a Closed by id
     * @param int $id
     * @return Closed|null
     */
    public static function getById (int $id) : ?Closed{
        $request = DB::getInstance()->prepare("SELECT * FROM closed where cl_id= :id");
        $request->bindValue(":id",$id);
        return self::getOne($request);
    }

    /**
     * return an array by user_id
     * @param int $user_id
     * @return array
     */
    public static function getAllByUser(int $user_id): array{
        $request = DB::getInstance()->prepare("SELECT * FROM closed where cl_user_id = :user");
        $request->bindValue(":user",$user_id);
        return self::getMany($request);
    }

    /**
     * return an array with all the Closed
     * @return array
     */
    public static function getAll() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM closed");
        return self::getMany($request);
    }

    /**
     * update on DB with id
     * @param int $id
     * @param array|null $var
     * @return bool
     */
    public static function update(int $id, array $var = null) : bool{
        if (is_null($var['date']) || is_null($var['topic_id']) || is_null($var['user_id']) ) {
            $data = self::getById($id);
            if (is_null($var['date'])) {
                $var['date'] = $data->getDate();
            }
            if (is_null($var['topic_id']) ) {
                $var['remark_id'] = $data->getTopic()->getId();
            }
            if (is_null($var['user_id']) ) {
                $var['user_id'] = $data->getUser()->getId();
            }
        }

        $request = DB::getInstance()->prepare("UPDATE closed
                    SET cl_date = :date, cl_topic_id = :topic, cl_user_id = :user
                    WHERE cl_id = :id
                    ");
        $request->bindValue(":id",$id);
        $request->bindValue(":date",intval($var['date']));
        $request->bindValue(":remark",intval($var['topic_id']));
        $request->bindValue(":user",intval($var['user_id']));

        return $request->execute();
    }

    /**
     * insert  in DB
     * @param int $date
     * @param int $topic_id
     * @param int $user_id
     * @return bool
     */
    public static function add(int $date, int $topic_id, int $user_id) : bool {
        $request = DB::getInstance()->prepare("INSERT INTO closed
        (cl_date, cl_topic_id, cl_user_id)
        VALUES (:date, :topic, :user)
        ");

        $request->bindValue(":date", $date);
        $request->bindValue(":topic", $topic_id);
        $request->bindValue(":user", $user_id);

        return $request->execute();
    }

    /**
     * delete  by id
     * @param int $id
     * @return bool
     */
    public static function delete(int $id) : bool {
        $request = DB::getInstance()->prepare("DELETE FROM closed WHERE cl_id = :id");
        $request->bindValue(':id',$id);
        return $request->execute();
    }

    /**
     * private request for the getBy
     * @param PDOStatement $request
     * @return Closed|null
     */
    private static function getOne(PDOStatement $request ) : ?Closed {
        $request->execute();
        $data = $request->fetch();
        if ($data) {
            $topic = topicManager::getById($data['cl_topic_id']);
            $user = UserManager::getById($data['cl_user_id']);
            return new Closed(intval($data['cl_id']), $data['cl_date'],$topic, $user);
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
                    $topic = topicManager::getById($data['cl_topic_id']);
                    $user = UserManager::getById($data['cl_user_id']);
                    $item = new Closed(intval($data['cl_id']), $data['cl_date'],$topic, $user);
                    $array[] = $item;
                }
            }
        }
        return $array;

    }
}