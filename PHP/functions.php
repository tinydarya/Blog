<?php
/**
 * Created by PhpStorm.
 * User: tinydarya
 * Date: 29/04/15
 * Time: 21:00
 */

function convertMonth($monthNumber) {
    switch ($monthNumber) {
        case 1:
            return "Января";
        case 2:
            return "Февраля";
        case 3:
            return "Марта";
        case 4:
            return "Апреля";
        case 5:
            return "Мая";
        case 6:
            return "Июня";
        case 7:
            return "Июля";
        case 8:
            return "Августа";
        case 9:
            return "Сентября";
        case 10:
            return "Октября";
        case 11:
            return "Ноября";
        case 12:
            return "Декабря";
    }
    return "";
}

function convertWeekDay($weekDayNumber) {
    switch ($weekDayNumber) {
        case 0:
            return "Понедельник";
        case 1:
            return "Вторник";
        case 2:
            return "Среда";
        case 3:
            return "Четверг";
        case 4:
            return "Пятница";
        case 5:
            return "Суббота";
        case 6:
            return "Воскресенье";
    }
    return "";
}