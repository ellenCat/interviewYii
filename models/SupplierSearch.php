<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Supplier;

/**
 * SupplierSearch represents the model behind the search form of `app\models\Supplier`.
 */
class SupplierSearch extends Supplier
{
    /**
     * {@inheritdoc}
     */
    public $flag;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['flag', 'name', 'code', 't_status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Supplier::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

         //grid filtering conditions

        if($this->id){
            $searchId = $this->id;
            $id = substr($searchId,4);
            $symbol = substr($searchId,0,4);
            $symbolArr = ["1111"=>">","2222"=>"<","3333"=>">=","4444"=>"<="];
            $query->andFilterWhere([$symbolArr[$symbol], 'id', $id]);
        }

//        $query->andFilterWhere([
//            'id' => $this->id,
//        ]);



//        echo "<pre>";
//        print_r($this->id);
//        echo "<br/>";
        //$query->andFilterWhere(['like', 'id', $this->name]);
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 't_status', $this->t_status]);

        return $dataProvider;
    }

    public function getPermissions() {
        return array (self::PERMISSIONS_PRIVATE=>'Private',self::PERMISSIONS_PUBLIC=>'Public');
    }

    public function getPermissionsLabel($permissions) {
        if ($permissions==self::PERMISSIONS_PUBLIC) {
            return 'Public';
        } else {
            return 'Private';
        }
    }

    public static function dropDown ($flag){
        $ids = [];
        if($flag=="id"){
            $result = Supplier::find()->all();
            foreach ($result as $row) {
                $ids['1111'.$row->attributes['id']] = ">".$row->attributes['id'];
                $ids['2222'.$row->attributes['id']] = "<".$row->attributes['id'];
                $ids['3333'.$row->attributes['id']] = ">=".$row->attributes['id'];
                $ids['4444'.$row->attributes['id']] = "<=".$row->attributes['id'];
            }
        }
        $dropDownList = [
            'id'=>$ids,
            'idinput'=>"",
            'status'=> ['ok'=>'ok', 'hold'=>'hold']];
        if($flag !=null && array_key_exists($flag, $dropDownList)){
            return $dropDownList[$flag];
        }else{
            return [];
        }

    }







}