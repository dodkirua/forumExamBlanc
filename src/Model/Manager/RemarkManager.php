<?php

namespace Dodkirua\Forum\Model\Manager;

use Dodkirua\Forum\Model\DB;
use Dodkirua\Forum\Model\Entity\Remark;
use PDOStatement;

class RemarkManager extends Manager{
    /**
     * return a Remark by id
     * @param int $id
     * @return Remark|null
     */
    public static function getById (int $id) : ?Remark{
        $request = DB::getInstance()->prepare("SELECT * FROM remark where rm_id= :id");
        $request->bindValue(":id",$id);
        return self::getOne($request);
    }

    /**
     * return all Remark by user
     * @param int $user_id
     * @return array|null
     */
    public static function getAllByUser(int $user_id): ?array    {
        $request = DB::getInstance()->prepare("SELECT * FROM remark where rm_user_id = :user");
        $request->bindValue(":user", $user_id);
        return self::getMany($request);
    }

    /**
     * return an array with all the Remark
     * @return array
     */
    public static function getAll() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM remark");
        return self::getMany($request);
    }

    /**
     * update on DB with id
     * @param int $id
     * @param array|null $var
     * @return bool
     */
    public static function update(int $id, array $var = null) : bool {
        if (is_null($var['date']) || is_null($var['text']) || is_null($var['topic_id']) || is_null($var['user_id']))
        {
            $data = self::getById($id);
            if (is_null($var['date'])) {
                $var['date'] = $data->getDate();
            }
            if (is_null($var['text']) ) {
                $var['text'] = $data->getText();
            }
            if (is_null($var['topic_id']) ) {
                $var['topic_id'] = $data->getTopic()->getId();
            }
            if (is_null($var['user_id']) ) {
                $var['user_id'] = $data->getUser()->getId();
            }
        }

        $request = DB::getInstance()->prepare("UPDATE remark
                    SET rm_date = :date, rm_text = :text, rm_topic_id = :topic, rm_user_id = :user
                    WHERE rm_id = :id
                    ");
        $request->bindValue(":id",$id);
        $request->bindValue(":date",intval($var['date']));
        $request->bindValue(":text",mb_strtolower($var['text']));
        $request->bindValue(':topic', intval($var['topic_id']));
        $request->bindValue(":user",intval($var['user_id']));

        return $request->execute();
    }

    /**
     * insert  in DB
     * @param int $date
     * @param string $text
     * @param int $topic_id
     * @param int $user_id
     * @return bool
     */

    public static function add(int $date, string $text, int $topic_id, int $user_id) : bool {
        $request = DB::getInstance()->prepare("INSERT INTO remark
        (rm_date, rm_text, rm_topic_id, rm_user_id)
        VALUES (:date, :text, :topic, :user)
        ");
        $request->bindValue(":text",mb_strtolower($text));
        $request->bindValue(':date', $date);
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
        $request = DB::getInstance()->prepare("DELETE FROM remark WHERE rm_id = :id");
        $request->bindValue(':id',$id);
        return $request->execute();
    }

    /**
     * private request for the getBy
     * @param PDOStatement $request
     * @return Remark|null
     */
    private static function getOne(PDOStatement $request ) : ?Remark {
        $request->execute();
        $data = $request->fetch();
        if ($data) {
            $user = UserManager::getById($data['rm_user_id']);
            $topic = TopicManager::getById($data['rm_topic_id']);
            return new Remark(intval($data['rm_id']), intval($data['rm_date']), $data['rm_text'], $topic, $user);
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
                    $user = UserManager::getById($data['rm_user_id']);
                    $topic = TopicManager::getById($data['rm_topic_id']);
                    $item = new Remark(intval($data['rm_id']), intval($data['rm_date']), $data['rm_text'], $topic, $user);
                    $array[] = $item;
                }
            }
        }
        return $array;

    }
}