<?php

namespace app\Acme\Transformers;


use Acme\Transformer\Transformer;

class LessonTransformer extends Transformer
{
    public function transform($lesson)
    {
        return [
            'title' => $lesson['title'],
            'body' => $lesson['body'],
            'active' => (boolean)$lesson['some_bool']
        ];
    }
}