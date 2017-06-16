<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Programa;
use app\models\Rol;
use app\models\DepartamentoDocenteCargo;

/**
 * ProgramaSearch represents the model behind the search form about `app\models\Programa`.
 */
class ProgramaSearch extends Programa
{

    public $idMateria;
    public $idEstadoP;
    public $cuatrimestre;
    public $idCarrera;
    public $idPlan;
    public $idDepartamento;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPrograma', 'idCursado' , 'idMateria', 'idEstadoP', 'idCarrera', 'idPlan', 'idDepartamento'], 'integer'],
            [['orientacion', 'anioActual', 'programaAnalitico', 'propuestaMetodologica', 'condicionesAcredEvalu', 'horariosConsulta', 'bibliografia', 'cuatrimestre'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
    /*public function search($params)
    {
        $query = Programa::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'programa.idPrograma' => $this->idPrograma,
            'programa.idCursado' => $this->idCursado,
            'programa.anioActual' => $this->anioActual,
            'materia.codigo' => $this->idMateria,
            'cambioestado.idEstadoP' => $this->idEstadoP,
            'carrera.idCarrera' => $this->idCarrera,
            'departamento.idDepartamento' => $this->idDepartamento,
            'plan.idPlan' => $this->idPlan,
        ]);

        $query->andFilterWhere(['like', 'orientacion', $this->orientacion])
            ->andFilterWhere(['like', 'programaAnalitico', $this->programaAnalitico])
            ->andFilterWhere(['like', 'propuestaMetodologica', $this->propuestaMetodologica])
            ->andFilterWhere(['like', 'condicionesAcredEvalu', $this->condicionesAcredEvalu])
            ->andFilterWhere(['like', 'horariosConsulta', $this->horariosConsulta])
            ->andFilterWhere(['like', 'bibliografia', $this->bibliografia])
            ->andFilterWhere(['like', 'bibliografia', $this->bibliografia])
            ->andFilterWhere(['like', 'cursado.cuatrimestre', $this->cuatrimestre]);

        return $dataProvider;
    }*/

    public function searchDocente($params)
    {
        /*
        Si es docente filtro por los programas que esten a su cargo y los que sean de su departamento siempre y cuando esten publicados. Ordenado por año materia cuatrimestre (descripcion) y cursado
        */
        $query = Programa::find();

        // add conditions that should always apply here
        $query->joinWith(['cambioestados','idCursado0.idMateria0']);
        //.departamentodocentecargos

        //PENDIENTE VALIDAR EL DEPARTAMENTO DEL DOCENTE Y LOS PROGRAMAS PUBLICADOS
          //  $query->andFilterWhere(['materia.idDepartamento'=>DepartamentoDocenteCargo::find()->where(['idDocente'=>Yii::$app->user->identity->id])->one()->idDepartamento]);            

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(isset($this->idEstadoP))
        {
            $query->andWhere('(SELECT idEstadoP FROM cambioestado WHERE idCambioEstado = (SELECT max(idCambioEstado) FROM cambioestado)) ='.$this->idEstadoP);
        }else{
           /* WHERE DPTO DEL DOCENTE
            SELECT * FROM departamentodocentecargo WHERE idDocente = logueadoDocente

            SELECT * FROM programa INNER JOIN cursado ON cursado.idCursado = programa.idCursado 
            INNER JOIN materia On materia.idCursado = cursado.idCursado WHERE materia.idDepartamento <> dptoDocente AND programa.idEstadoP = 3*/

            $query->andWhere('( 
                (materia.idDepartamento IN (SELECT idDepartamento FROM departamentodocentecargo WHERE idDocente = '.Usuario::find()->where(['idUsuario'=>Yii::$app->user->identity->id])->one()->idDocente.')
                    AND ((SELECT idEstadoP FROM cambioestado WHERE idCambioEstado = (SELECT max(idCambioEstado) FROM cambioestado)) IN (1,3,4))
                )
                OR 
                (
                materia.idDepartamento NOT IN (SELECT idDepartamento FROM departamentodocentecargo WHERE idDocente = '.Usuario::find()->where(['idUsuario'=>Yii::$app->user->identity->id])->one()->idDocente.') 
                    AND (
                            (SELECT idEstadoP FROM cambioestado WHERE idCambioEstado = (SELECT max(idCambioEstado) FROM cambioestado)) = 3
                        )
                )
            ) ');    
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'programa.idPrograma' => $this->idPrograma,
            'programa.idCursado' => $this->idCursado,
            'programa.anioActual' => $this->anioActual,
            'materia.codigo' => $this->idMateria,
            'cambioestado.idEstadoP' => $this->idEstadoP,
            'carrera.idCarrera' => $this->idCarrera,
            'departamento.idDepartamento' => $this->idDepartamento,
            'plan.idPlan' => $this->idPlan,
        ]);

        $query->andFilterWhere(['like', 'orientacion', $this->orientacion])
            ->andFilterWhere(['like', 'programaAnalitico', $this->programaAnalitico])
            ->andFilterWhere(['like', 'propuestaMetodologica', $this->propuestaMetodologica])
            ->andFilterWhere(['like', 'condicionesAcredEvalu', $this->condicionesAcredEvalu])
            ->andFilterWhere(['like', 'horariosConsulta', $this->horariosConsulta])
            ->andFilterWhere(['like', 'bibliografia', $this->bibliografia])
            ->andFilterWhere(['like', 'bibliografia', $this->bibliografia])
            ->andFilterWhere(['like', 'cursado.cuatrimestre', $this->cuatrimestre]);

        return $dataProvider;
    }

    public function searchJefe($params)
    {
        /*Si es jefedpto filtro por su departameto y ordeno por año materia cuatrimestre y cursado, este no puede ver los programas de otros dptos. Ordenado por año materia cuatrimestre (descripcion) y cursado*/
        $query = Programa::find();

        // add conditions that should always apply here
        $query->joinWith(['cambioestados','idCursado0.idMateria0.idDepartamento0']);

        //PENDIENTE VALIDAR EL DEPARTAMENTO DEL DOCENTE 

        $query->andFilterWhere(['materia.idDepartamento'=>DepartamentoDocenteCargo::find()->where(['idDocente'=>Usuario::find()->where(['idUsuario'=>Yii::$app->user->identity->id])->one()->idDocente])->one()->idDepartamento]);            

        //Busco ultimo estado del programa y verifico que este en revision
        


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        


        $this->load($params);

        if(isset($this->idEstadoP))
        {
            $query->andWhere('(SELECT idEstadoP FROM cambioestado WHERE idCambioEstado = (SELECT max(idCambioEstado) FROM cambioestado)) ='.$this->idEstadoP);
        }else{
            $query->andWhere('(SELECT idEstadoP FROM cambioestado WHERE idCambioEstado = (SELECT max(idCambioEstado) FROM cambioestado)) IN (2,3,4)');

            //$query->andFilterWhere(['cambioestado.idEstadoP' =>3]);
        }


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        

        // grid filtering conditions
        $query->andFilterWhere([
            'programa.idPrograma' => $this->idPrograma,
            'programa.idCursado' => $this->idCursado,
            'programa.anioActual' => $this->anioActual,
            'materia.codigo' => $this->idMateria,
            'carrera.idCarrera' => $this->idCarrera,
            'departamento.idDepartamento' => $this->idDepartamento,
            'plan.idPlan' => $this->idPlan,
        ]);

        $query->andFilterWhere(['like', 'orientacion', $this->orientacion])
            ->andFilterWhere(['like', 'programaAnalitico', $this->programaAnalitico])
            ->andFilterWhere(['like', 'propuestaMetodologica', $this->propuestaMetodologica])
            ->andFilterWhere(['like', 'condicionesAcredEvalu', $this->condicionesAcredEvalu])
            ->andFilterWhere(['like', 'horariosConsulta', $this->horariosConsulta])
            ->andFilterWhere(['like', 'bibliografia', $this->bibliografia])
            ->andFilterWhere(['like', 'bibliografia', $this->bibliografia])
            ->andFilterWhere(['like', 'cursado.cuatrimestre', $this->cuatrimestre]);

        return $dataProvider;
    }

    public function searchSecAcademico($params)
    {
        /*Si es sec academico filtro los programas publicados ordenados por año, carrera, materia, cuatrimestre (descripcion) y crusado. (Este no puede ver otros programas que no esten publicados, pero si ve aquellos que esten pendientes de publicar por el.)*/
        $query = Programa::find();

        // add conditions that should always apply here
        //$query->joinWith(['cambioestados']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(isset($this->idEstadoP))
        {
            $query->andWhere('(SELECT idEstadoP FROM cambioestado WHERE idCambioEstado = (SELECT max(idCambioEstado) FROM cambioestado)) ='.$this->idEstadoP);
        }else{
            $query->andWhere('(SELECT idEstadoP FROM cambioestado WHERE idCambioEstado = (SELECT max(idCambioEstado) FROM cambioestado)) IN (2,3)');

            //$query->andFilterWhere(['cambioestado.idEstadoP' =>3]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'programa.idPrograma' => $this->idPrograma,
            'programa.idCursado' => $this->idCursado,
            'programa.anioActual' => $this->anioActual,
            'materia.codigo' => $this->idMateria,
            //'cambioestado.idEstadoP' => self::PUBLICADO,
            'carrera.idCarrera' => $this->idCarrera,
            'departamento.idDepartamento' => $this->idDepartamento,
            'plan.idPlan' => $this->idPlan,
        ]);

        $query->andFilterWhere(['like', 'orientacion', $this->orientacion])
            ->andFilterWhere(['like', 'programaAnalitico', $this->programaAnalitico])
            ->andFilterWhere(['like', 'propuestaMetodologica', $this->propuestaMetodologica])
            ->andFilterWhere(['like', 'condicionesAcredEvalu', $this->condicionesAcredEvalu])
            ->andFilterWhere(['like', 'horariosConsulta', $this->horariosConsulta])
            ->andFilterWhere(['like', 'bibliografia', $this->bibliografia])
            ->andFilterWhere(['like', 'bibliografia', $this->bibliografia])
            ->andFilterWhere(['like', 'cursado.cuatrimestre', $this->cuatrimestre]);

        return $dataProvider;
    }
}