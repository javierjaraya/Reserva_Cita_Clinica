<?php

class CitaController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'viewReporte', 'viewGrafico'),
                'users' => array('Dentista', 'Asistente'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Cita;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Cita'])) {
            $model->attributes = $_POST['Cita'];
            $id_dia = $this->diaSemana($model->fecha);
            $modelBloque = Bloque::model()->findByAttributes(array('id_dia' => $id_dia, 'inicio' => $model->hora));
            $model->id_bloque = $modelBloque->id_bloque;
            $model->estado_cita = "Confirmada";
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionViewReporte() {
        $modelo = new ReporteCitas();
        if (isset($_POST['ReporteCitas'])) {
            $modelo->attributes = $_POST['ReporteCitas'];
            //Cambiar esto
            $connection = Yii::app()->db;
            $fecha1 = new DateTime($modelo->inicio);
            $fecha2 = $fecha1->format("d-m-Y");
            $fecha3 = new DateTime($modelo->fin);
            $fecha4 = $fecha3->format("d-m-Y");
            $sql = "SELECT * from CITA where CITA.fecha >=" . "'" . $modelo->inicio . "'" .
                    "and CITA.fecha <=" . "'" . $modelo->fin . "' and estado_cita = 'Confirmada' Order By (fecha) ASC";
            $command = $connection->createCommand($sql);
            $dataReader = $command->query();
            $rows = $dataReader->readAll();
            $mPDF1 = Yii::app()->ePdf->mpdf();
            $mPDF1->WriteHTML("<div align='center'><img src='slider/marca.jpg'></div>");
            $mPDF1->WriteHTML("<H3 align='center'>Citas Agendadas entre " . $fecha2 . " y " . $fecha4 . "<H3>");
            $mPDF1->WriteHTML("<br>");
            $i = 1;
            foreach ($rows as $row) {
                $consulta1 = "SELECT nombre_paciente, apellidos_paciente, paciente.rut_paciente 
                    FROM paciente, cita 
                    WHERE paciente.rut_paciente = cita.rut_paciente and id_cita = " . $row['id_cita'];
                $command = $connection->createCommand($consulta1);
                $dataReader = $command->query();
                $filas = $dataReader->readAll();
                foreach ($filas as $fila) {
                    $mPDF1->WriteHTML("Cita de " . $fila['nombre_paciente'] . $fila['apellidos_paciente'] . "<br><br>");
                }

                $i++;
                $mPDF1->WriteHTML("<table border='1'>");
                $mPDF1->WriteHTML("<tr>");
                $mPDF1->WriteHTML("<td>RUN: " . $fila['rut_paciente'] . "</td>");
                $mPDF1->WriteHTML("<td>Fecha: " . $row['fecha'] . "</td></tr>");

                $consulta2 = "SELECT * from bloque where bloque.id_bloque = " . $row['id_bloque'] . "";
                $command = $connection->createCommand($consulta2);
                $dataReader = $command->query();
                $filas2 = $dataReader->readAll();
                foreach ($filas2 as $fila2) {
                    $mPDF1->WriteHTML("<tr>");
                    $mPDF1->WriteHTML("<td>Hora:</td>");
                    $mPDF1->WriteHTML("<td>" . $fila2['inicio'] . "</td></tr>");
                }
                $consulta3 = "SELECT * from tratamiento where tratamiento.id_tratamiento = " . $row['id_tratamiento'] . "";
                $command = $connection->createCommand($consulta3);
                $dataReader = $command->query();
                $filas3 = $dataReader->readAll();
                foreach ($filas3 as $fila3) {
                    $mPDF1->WriteHTML("<tr>");
                    $mPDF1->WriteHTML("<td>Tratamiento:</td>");
                    $mPDF1->WriteHTML("<td>" . $fila3['nombre'] . "</td></tr>");
                }
                $mPDF1->WriteHTML("</table>");
                $mPDF1->WriteHTML("<br>");
            }

            $mPDF1->Output('Mi archivo', "I");
        }
        $this->render('reporteCita', array('model' => $modelo));
    }

    public function diaSemana($fecha) {
        $ano = substr($fecha, -10, 4);
        $mes = substr($fecha, -5, 2);
        $dia = substr($fecha, -2, 2);
        $valor = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
        return $valor;
    }

    public function actionViewGrafico() {
        //N°  de pacientes por residencia
        $model = new graficoTratamientos();
        if (isset($_POST['graficoTratamientos'])) {
            $model->attributes = $_POST['graficoTratamientos'];
            /* $sql = "SELECT C1 AS id_comuna, C2 AS comuna, COUNT( N1 ) AS numero_pacientes

              FROM (
              SELECT DISTINCT tbl_paciente.numero_ficha AS N1, tbl_comuna.id_comuna AS C1,  tbl_comuna.comuna as C2
              FROM tbl_comuna
              JOIN tbl_paciente ON tbl_comuna.id_comuna = tbl_paciente.comuna_paciente
              JOIN tbl_cita ON tbl_paciente.numero_ficha = tbl_cita.numero_ficha_paciente
              WHERE tbl_cita.fecha_cita >=  '".$fecha_inicio."'
              AND tbl_cita.fecha_cita <=  '".$fecha_fin."'
              ) AS TABLA

              GROUP BY C1"; */
            $connection = Yii::app()->db;
            $sql = "select tratamiento.nombre , count(cita.id_tratamiento) from tratamiento, cita where tratamiento.id_tratamiento = cita.id_tratamiento and fecha >= " . "'" . $model->inicio . "' and fecha <= " . "'" . $model->fin . "' group by (tratamiento.nombre)";
            $command = $connection->createCommand($sql);
            $dataReader = $command->query();
            $rows = $dataReader->readAll();
            $arregloGT = array();
            $total_pacientes = 0;
            /*foreach ($rows as $row) {
                $total_pacientes += (integer) $row['numero_pacientes'];
            }*/
            foreach ($rows as $row) {
                $arregloGT[] = array(
                    "name" => $row['nombre'],
                    "y" => ( (((integer) $row['count(cita.id_tratamiento)']))),
                    "cantidad" => 0, // no utilizada por el widget de gráfico, pero si nos resulta util para rescatar datos
                );
            }

            $this->render('graficoTratamientos', array(
                "ppc" => $arregloGT,
                'model'=>$model,
            ));
        }else{
            $this->render('fechasTratamiento', array('model' => $model));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Cita'])) {
            $model->attributes = $_POST['Cita'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_cita));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Cita');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Cita('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Cita']))
            $model->attributes = $_GET['Cita'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Cita the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Cita::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Cita $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cita-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
