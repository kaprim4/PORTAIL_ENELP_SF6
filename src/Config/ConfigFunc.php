<?php

namespace App\Config;

use App\Entity\Parameter;
use App\Entity\Price;
use App\Repository\ParameterRepository;

abstract class ConfigFunc
{
    /**
     * @param int $length
     * @return string
     */
    public static function randomID(int $length = 8): string
    {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $count = strlen($chars);
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= substr($chars, $index, 1);
        }

        return strtolower($result);
    }


    /**
     * @param int $length
     * @return string
     */
    public static function generateRandomCode(int $length = 6): string
    {
        $chars = '0123456789';
        $count = strlen($chars);
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= substr($chars, $index, 1);
        }
        return $result;
    }

    /**
     * @param int $length
     * @return string
     */
    public static function generateRandomHash(int $length = 8): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $count = strlen($chars);
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= substr($chars, $index, 1);
        }
        return $result;
    }

    /**
     * @return array
     */
    public static function getBrowser(): array
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/OPR/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } elseif (preg_match('/Edge/i', $u_agent)) {
            $bname = 'Edge';
            $ub = "Edge";
        } elseif (preg_match('/Trident/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

    public static function getCycleList(ParameterRepository $parameterRepository): array
    {
        $interval_by_secs = intval($parameterRepository->findOneByAlias(['alias' => 'INTERVAL_BY_SECS'])->getValue());
        $CycleList = array();
        for ($i = 0; $i < 24; $i++) {
            $interval = 3600 / $interval_by_secs;
            $mins = 60 / $interval;
            $_mins = 0;
            for ($j = 0; $j < $interval; $j++) {
                $CycleList[] = str_pad($i, 2, "0", STR_PAD_LEFT) . ':' . str_pad($_mins, 2, "0", STR_PAD_LEFT);
                $_mins += $mins;
            }
        }
        return $CycleList;
    }

    public static function nextCycle(ParameterRepository $parameterRepository): string
    {
        $add_interval_per_day = intval($parameterRepository->findOneByAlias(['alias' => 'ADD_INTERVAL_PER_DAY'])->getValue()) / 60;
        $sys_minutes = intval(date("i"));
        if ($sys_minutes < $add_interval_per_day)
            return date("Y-m-d H", strtotime('+1 hour')) . ':00';
        else
            return date("Y-m-d H", strtotime('+2 hour')) . ':00';
    }

    public static function getDayWeekNumber(string $day_name): int
    {
        return match ($day_name) {
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6,
            default => 0,
        };
    }

    public static function frenchDayByNumber(int $c_m): string
    {
        $day_name = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
        return $day_name[$c_m];
    }

    public static function dateIntervalToSec($start, $end): string
    {
        // as datetime object returns difference in seconds
        $diff = $end->diff($start);
        return $diff->format('%r').( // prepend the sign - if negative, change it to R if you want the +, too
                ($diff->s)+ // seconds (no errors)
                (60*($diff->i))+ // minutes (no errors)
                (60*60*($diff->h))+ // hours (no errors)
                (24*60*60*($diff->d))+ // days (no errors)
                (30*24*60*60*($diff->m))+ // months (???)
                (365*24*60*60*($diff->y)) // years (???)
            );
    }

    public static function formatOrderRef(int $id): string
    {
        return strtoupper("CC" . $id);
    }

    /**
     * @param string $code_sap
     * @param $id
     * @return string
     */
    public static function formatClaimTicket(string $code_sap, $id): string
    {
        return strtoupper(trim($code_sap)) . "-" . str_pad(intval($id), 4, "0", STR_PAD_LEFT);
    }

    public static function generatePlainTextNewPriceMessage(Price $price): string
    {

    }
}