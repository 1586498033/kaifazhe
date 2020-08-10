<?php
/*
 * Redis 缓存数据
 * 1、先从Redis中查询数据，如果redis中没有则查询数据库
 * 2、查询结果再次刷新至redis中
 * */
if(!defined('IN_PHPMYWIND')) exit('Request Error!');
class RedisPackage
{
    private static $handler = null;
    private static $_instance = null;
    private static $options = [
        'host' => '127.0.0.1',// 连接redis出错 速度导致变慢 redis得开启
        //'host' => '47.101.134.0',
        //'port' => 6380,
        'port' => 6379,
        'password' => '!QE%^E3323BDfdd5we1839',
        //'password' => '',
        'select' => 1,
        'timeout' => 60,
        'expire' => 0,
        'persistent' => false,
        'prefix' => '',
    ];

    private function __construct($options = [])
    {
        if (!extension_loaded('redis')) {
            throw new \BadFunctionCallException('not support: redis');      //判断是否有扩展
        }
        if (!empty($options)) {
            self::$options = array_merge(self::$options, $options);
        }
        $func = self::$options['persistent'] ? 'pconnect' : 'connect';     //长链接
        self::$handler = new \Redis;

        self::$handler->$func(self::$options['host'], self::$options['port'], self::$options['timeout']);

        if ('' != self::$options['password']) {
            self::$handler->auth(self::$options['password']);
        }

        if (0 != self::$options['select']) {
            self::$handler->select(self::$options['select']);
        }
    }

    /**@return Redis|null 对象
     * @param array $options
     * @return Redis|null
     */
    public static function getInstance($options = [])
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self($options);
        }
        return self::$_instance;
    }

    /**
     * 禁止外部克隆
     */
    public function __clone()
    {
        trigger_error('Clone is not allow!',E_USER_ERROR);
    }

    /**
     * 写入缓存
     * @param string $key 键名
     * @param string $value 键值
     * @param int $exprie 过期时间 0:永不过期
     * @return bool
     */

    public static function set($key, $value, $exprie = 0)
    {
        if ($exprie == 0) {
            $set = self::$handler->set($key, $value);
        } else {
            $set = self::$handler->setex($key, $exprie, $value);
        }
        return $set;
    }

    /**
     * 读取缓存
     * @param string $key 键值
     * @return mixed
     */
    public static function get($key)
    {
        $fun = is_array($key) ? 'Mget' : 'get';
        return self::$handler->{$fun}($key);
    }

    /**
     * 删除缓存
     * @param string $key 键名
     * @return bool
     */
    public static function del($key)
    {
        return self::$handler->del($key);
    }
    /**
     * 获取值长度
     * @param string $key
     * @return int
     */
    public static function lLen($key)
    {
        return self::$handler->lLen($key);
        self::$handler->zRangeByScore();
    }

    /**
     * 列表(List)：将一个或多个值插入到列表头部
     * @param $key
     * @param $value
     * @return int
     */
    public static function lPush($key, $value)
    {
        return self::$handler->lPush($key, $value);
    }

    /**
     * 移出并获取列表的第一个元素
     * @param string $key
     * @return string
     */
    public static function lPop($key)
    {
        return self::$handler->lPop($key);
    }
    /**
     * 获取key值的列表
     */
    public function lRange($key, $start=0, $end=-1){

        return self::$handler->lRange($key, $start, (int)($end));
    }
    /**
     * 有序集合(sorted set)：向有序集合添加一个成员，或者更新已存在成员的份数
     * @param string $key
     * @param float $score
     * @param string $value
     * @return int
     */
    public static function zAdd($key, $score, $value){

        return self::$handler->zAdd( $key, $score, $value);
    }

    /**
     * 返回有序集合中指定份数区间的成员列表
     * @param string $key
     * @param float $start
     * @param float $end
     * @param array $options
     * @return array
     */
    public static function zRange($key, $start, $end, $options='' ){

        return  self::$handler->zRange($key, $start, $end, $options);

    }

    /**
     * 返回有序集合：逆序排列所有成员
     * @param string $key
     * @param string +inf -inf
     * @param array $options
     * @return array zrevrangebyscore
     */
    public static function zRevrangeByScore($key){

        return  self::$handler->ZREVRANGEBYSCORE($key, '+inf', '-inf');

    }

    /**返回有序集合中指定份数区间的成员列表
     * @param string $key
     * @param float $start
     * @param float $end
     * @param array $options
     * @return array
     */
    public static function zRangeByScore($key, $start, $end, array $options= [] ){

        return  self::$handler->zRangeByScore($key, $start, $end, $options);

    }

    /**移除有序集中，指定份数（score）区间内的所有成员
     * @param string $key
     * @param float $start
     * @param float $end
     * @return int
     */
    public static function zRemRangeByScore($key, $start, $end ){

        return  self::$handler->zRemRangeByScore($key, $start, $end );
    }

    /**移除有序集中的一个成员
     * @param $key
     * @param $member1
     * @return int
     */
    public static function zRem($key, $member){

        return self::$handler->zRem($key, $member);
    }

    /**
     * 保存数组
     */
    public function setArr($key,$data){
        $this->set($key,json_encode($data));
    }

    /**
     * 获取数组
     */
    public function getArr($key){
        return json_decode($this->get($key));
    }

}