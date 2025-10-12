<?php

namespace App\Enums;

enum QuestionTypeEnum
{
    public const single_select = 1;
    public const multi_select = 2;
    public const fill_in_the_plank = 3;

    public static function QuestionStatus()
    {
        return [
            self::single_select => 'Single Select',
            self::multi_select => 'Multi Select',
            self::fill_in_the_plank => 'Fill  in the Blank',
        ];
    }

    public static function getQuestionStatus($status)
    {
        return self::QuestionStatus()[$status];
    }


}
