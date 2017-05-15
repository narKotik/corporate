<?php


namespace Corp\Repositories;

use Config;

abstract class Repository
{
    protected $model = false;

    public function get($arr = []/*$select = '*', $take = false, $revert = false, $pagination = false*/)
    {
        $select = key_exists('select', $arr) ? $arr['select'] : '*';
        $take = key_exists('take', $arr) ? $arr['take'] : false;
        $revert = key_exists('revert', $arr) ? $arr['revert'] : false;
        $pagination = key_exists('pagination', $arr) ? $arr['pagination'] : false;
        $where = ( key_exists('where', $arr) && is_array($arr['where']) ) ? $arr['where'] : false;

        
        $builder = $this->model->select($select);

        if ($take) {
            $builder->take($take);
        }

        if ($revert) {
            $builder->orderBy($revert, 'desc');
        }
        
        if ($where) {
            $builder->where($where[0], $where[1]);
        }

        if ($pagination) {
            return $this->check($builder->paginate($pagination));
        }

        return $this->check($builder->get());
    }

    public function one($alias, $attr = false)
    {
        $result = $this->model->where('alias', $alias)->first();

        if ($result) {
            $result->images = json_decode($result->images);
        }
        
        return $result;
    }
    
    protected function check($result)
    {
        if ($result->isEmpty()) {
            return false;
        }

        $result->transform(function ($item, $k) {
            if ($item->images) {
                $item->images = json_decode($item->images);
            }

            return $item;
        });
        return $result;
    }


    public function transliterate($text)
    {
        $str = mb_strtolower($text, 'UTF-8');

        $leter_arr = [
            'a' => 'а',
            'b' => 'б',
            'v' => 'в',
            'g' => 'г,ґ',
            'd' => 'д',
            'e' => 'е,є,э',
            'jo' => 'ё',
            'zh' => 'ж',
            'z' => 'з',
            'i' => 'и,і',
            'ji' => 'ї',
            'j' => 'й',
            'k' => 'к',
            'l' => 'л',
            'm' => 'м',
            'n' => 'н',
            'o' => 'о',
            'p' => 'п',
            'r' => 'р',
            's' => 'с',
            't' => 'т',
            'u' => 'у',
            'f' => 'ф',
            'kh' => 'х',
            'ts' => 'ц',
            'ch' => 'ч',
            'sh' => 'ш',
            'shch' => 'щ',
            '' => 'ъ',
            'y' => 'ы',
            '' => 'ь',
            'yu' => 'ю',
            'ya' => 'я',
        ];

        foreach ($leter_arr as $leter => $kyr){
            $kyr = explode(',', $kyr);

            $str = str_replace($kyr, $leter, $str);
        }

        $str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '-', $str);
    
        return trim($str, '-');
    }


    public function deleteImages($article)
    {
        $images = json_decode($article->images);
        foreach ($images as $image){
            if(file_exists( public_path() . '/' . config('settings.theme') . '/images/articles/' . $image) ){
                unlink(public_path() . '/' . config('settings.theme') . '/images/articles/' . $image);
            }
        }
    }
}