<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class StaticData extends Model
{

    protected $table = "static_data";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [
        'type',
        'value',
        'label',
        'status',
    ];
    protected $casts = [
        'status'   => 'integer',
        
        
      
    ];

    //Function for the get staticData on the basis of type...
    protected function getStaticData($type){

        if (is_array($type)) {

            $static_data = self::whereIn('type',$type)
                ->where('status', 1)
                ->orderBy('value', `ASC`)
                ->get();

            $data = array();
            if(count($static_data)){
                foreach ($static_data as $key => $value) {
                    $data[$value->type][$key] = $value;
                }
            }
        } else {
            $data = self::where(['type' => $type,'status' => 1])->orderBy('value', `ASC`)->get();
        }

        return $data;
    }

    protected function getCheckMarkData($id){
        $data = self::where('type','checkmark')->where('status', 1)->whereIn('id',$id)->get();
        return $data;
    }
    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'StaticData "' . $this->label . '" was created';
        }

        if ($eventName == 'updated')
        {
            return 'StaticData "' . $this->label . '" was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'StaticData "' . $this->label . '" was deleted';
        }

        return '';
    }

}
