<?php
/**
 * FileName:RedisStaticCall.php
 * Author:张哲
 * Email:1061180002@qq.com
 * Date:2021/10/30 0030
 * Time:9:23
 */
declare(strict_types=1);

namespace Zhe\laravelRedisClient;

/**
 * @method static string get(string $key)
 * @method static bool set(string $key, string $value)
 * @method static bool del(string $key)
 * @method static bool delByKeys(array $key)
 * @method static bool has(string $key)
 * @method static bool expire(string $key)
 * @method static bool incrInteger(string $key, int $num = 1)
 * @method static bool decrInteger(string $key, int $num = 1)
 * @method static bool sAdd(string $key, $value)
 * @method static array sMembers(string $key)
 * @method static bool sIsMember(string $key, $value)
 * @method static int sCard(string $key)
 * @method static bool sRem($key, ...$value)
 * @method static \Redis getRedis()
 */
class RedisStaticCall {

    public static function __callStatic($name, $arguments) {
        return call_user_func_array([RedisClient::getInstance(), $name], $arguments);
    }
}
