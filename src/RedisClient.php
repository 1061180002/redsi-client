<?php

/**
 * FileName:RedisClient.php
 * Author:张哲
 * Email:1061180002@qq.com
 * Date:2021/10/29 0029
 * Time:11:50
 */

declare(strict_types=1);

namespace Zhe\laravelRedisClient;

/**
 * NameSpace: Zhe\laravelRedisClient
 * ClassName: RedisClient
 * 描述:redis客户端
 */
class RedisClient {
    private $redis;
    private static $instance;

    private function __construct($host = "127.0.0.1", $port = 6379, $index = 0) {
        if (!extension_loaded("redis")) {
            throw new \RuntimeException('请开启redis 扩展');
        }
        $this->redis = new \Redis();
        $this->redis->connect($host, $port, 300);
        $this->redis->select($index);
    }

    private function __clone() {
    }

    public static function getInstance($host = "127.0.0.1", $port = 6379, $index = 0) {
        if (!self::$instance instanceof self) {
            self::$instance = new self($host, $port, $index);
        }
        return self::$instance;
    }

    /**
     * 获取指定key(键)的字符串 值
     * @param string $key 键
     * @return string
     */
    public function get(string $key): string {
        $str = $this->redis->get($key);
        if ($str) {
            return $str;
        } else {
            return "";
        }
    }

    /**
     * 设置指定key(键)的字符串 值
     * @param string $key 键
     * @param string $value 值
     * @param int $expire 过期时间(秒) 不传则为永久
     * @return boolean
     */
    public function set(string $key, string $value, int $expire = 0): bool {
        $bool = $this->redis->set($key, $value);
        if ($expire !== 0) {
            return !!$this->redis->expire($key, $expire);
        } else {
            return $bool;
        }
    }

    /**
     * 删除指定key(键)的字符串
     * @param string $key 键
     * @return boolean
     */
    public function del(string $key): bool {
        return !!$this->redis->del($key);
    }

    /**
     * 删除指定keys(键数组)的字符串
     * @param array $keys key数组
     * @return boolean
     */
    public function delByKeys(...$keys): bool {
        return !!$this->redis->del($keys);
    }

    /**
     * 判断指定key(键)的字符串是否存在
     * @param string $key 键
     * @return boolean
     */
    public function has($key): bool {
        return !!$this->redis->exists($key);
    }

    /**
     * 设置指定key的过期时间(使用所有类型)
     * @param string $key
     * @param int $timeout
     * @return bool
     */
    public function expire(string $key, int $timeout): bool {
        return !!$this->expire($key, $timeout);
    }

    /**
     * 设置指定key的自增数值
     * @param string $key 键
     * @param int $num 数字 默认1
     * @return bool
     */
    public function incrInteger(string $key, int $num = 1): bool {
        return !!$this->redis->incrBy($key, $num);
    }

    /**
     * 设置指定key的自减数值
     * @param string $key 键
     * @param int $num 数字 默认1
     * @return bool
     */
    public function decrInteger(string $key, int $num = 1): bool {
        return !!$this->redis->decrBy($key, $num);
    }

    /**
     * set集合添加数据
     * @param string $key 键
     * @param string|array $value 值数组
     * @return bool
     */
    public function sAdd(string $key, $value): bool {
        return !!$this->redis->sAdd($key, $value);
    }

    /**
     * set返回集合中所有成员。
     * @param string $key 键
     * @return array
     */
    public function sMembers(string $key): array {
        return $this->redis->sMembers($key);
    }

    /**
     * 判断set集合里是否存在指定元素，是返回true，否则返回false
     * @param string $key 键
     * @param string $value 值
     * @return bool
     */
    public function sIsMember(string $key, $value): bool {
        return !!$this->redis->sIsMember($key, $value);
    }

    /**
     * 返回set集合中元素的数量。
     * @param string $key 键
     * @return int
     */
    public function sCard(string $key): int {
        return $this->redis->sCard($key);
    }

    /**
     * 删除set集合中指定的一个元素。
     * @param string $key 键
     * @param array $value 值集合
     * @return bool
     */
    public function sRem($key, ...$value): bool {
        return !!$this->redis->sRem($key, $value);
    }

    /**
     * 获取默认的redis对象
     * @return \Redis
     */
    public function getRedis(): \Redis {
        return $this->redis;
    }
}
