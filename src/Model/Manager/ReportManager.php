<?php

namespace Dodkirua\Forum\Model\Manager;

use Dodkirua\Forum\Model\DB;
use Dodkirua\Forum\Model\Entity\Report;
use PDOStatement;

class ReportManager extends Manager{
    /**
     * return a Report by id
     * @param int $id
     * @return Report|null
     */
    public static function getById (int $id) : ?Report{
        $request = DB::getInstance()->prepare("SELECT * FROM report where rp_id= :id");
        $request->bindValue(":id",$id);
        return self::getOne($request);
    }

    /**
     * return all Report by user
     * @param int $user_id
     * @return array|null
     */
    public static function getAllByUser(int $user_id): ?array    {
        $request = DB::getInstance()->prepare("SELECT * FROM report where rp_user_id = :user");
        $request->bindValue(":user", $user_id);
        return self::getMany($request);
    }

    /**
     * return an array with all the Report
     * @return array
     */
    public static function getAll() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM report");
        return self::getMany($request);
    }

    /**
     * update on DB with id
     * @param int $id
     * @param array|null $var
     * @return bool
     */
    public static function update(int $id, array $var = null) : bool {
        if (is_null($var['date']) || is_null($var['reason']) || is_null($var['remark_id']) || is_null($var['user_id']))
        {
            $data = self::getById($id);
            if (is_null($var['date'])) {
                $var['date'] = $data->getDate();
            }
            if (is_null($var['reason']) ) {
                $var['text'] = $data->getReason();
            }
            if (is_null($var['remark_id']) ) {
                $var['topic_id'] = $data->getRemark()->getId();
            }
            if (is_null($var['user_id']) ) {
                $var['user_id'] = $data->getUser()->getId();
            }
        }

        $request = DB::getInstance()->prepare("UPDATE report
                    SET rp_date = :date, rp_reason = :text, rp_remark_id = :topic, rp_user_id = :user
                    WHERE rp_id = :id
                    ");
        $request->bindValue(":id",$id);
        $request->bindValue(":date",intval($var['date']));
        $request->bindValue(":reason",mb_strtolower($var['reason']));
        $request->bindValue(':remark', intval($var['remark_id']));
        $request->bindValue(":user",intval($var['user_id']));

        return $request->execute();
    }

    /**
     * insert  in DB
     * @param int $date
     * @param string $reason
     * @param int $user_id
     * @param int $remark_id
     * @return bool
     */

    public static function add(int $date, string $reason, int $user_id, int $remark_id) : bool {
        $request = DB::getInstance()->prepare("INSERT INTO report
        (rp_date, rp_reason, rp_user_id, rp_remark_id)
        VALUES (:date, :reason, :user, :remark)
        ");
        $request->bindValue(":reason",mb_strtolower($reason));
        $request->bindValue(':date', $date);
        $request->bindValue(":remark", $remark_id);
        $request->bindValue(":user", $user_id);

        return $request->execute();
    }

    /**
     * delete  by id
     * @param int $id
     * @return bool
     */
    public static function delete(int $id) : bool {
        $request = DB::getInstance()->prepare("DELETE FROM report WHERE rp_id = :id");
        $request->bindValue(':id',$id);
        return $request->execute();
    }

    /**
     * private request for the getBy
     * @param PDOStatement $request
     * @return Report|null
     */
    private static function getOne(PDOStatement $request ) : ?Report {
        $request->execute();
        $data = $request->fetch();
        if ($data) {
            $user = UserManager::getById($data['rp_user_id']);
            $remark = TopicManager::getById($data['rp_remark_id']);
            return new Report(intval($data['rp_id']), intval($data['rp_date']), $data['rp_reason'], $user, $remark);
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
                    $user = UserManager::getById($data['rp_user_id']);
                    $remark = TopicManager::getById($data['rp_remark_id']);
                    $item = new Report(intval($data['rp_id']), intval($data['rp_date']), $data['rp_reason'], $user, $remark);
                    $array[] = $item;
                }
            }
        }
        return $array;

    }
}