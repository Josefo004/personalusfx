<?php


namespace app\modules\Administracion\controllers;

use app\modules\Administracion\models\ItemsDao;
use app\modules\Administracion\models\Item;
use common\models\PlanificacionDao;
use app\modules\Administracion\models\SectorTrabajo;
use app\modules\Administracion\models\Unidad;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

class ItemsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == "listar-items-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $listaSectoresTrabajo = ArrayHelper::map(SectorTrabajo::find()->orderBy('NombreSectorTrabajo')->all(), 'CodigoSectorTrabajo', 'NombreSectorTrabajo');
        //$listaUnidades = PlanificacionDao::listaUnidades();
        return $this->render('items', [
            'sectoresTrabajo' => $listaSectoresTrabajo,
            //'unidades' => $listaUnidades,
        ]);
    }

    public function actionListarItemsAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $items = ItemsDao::listaItems();
            $datosJson = '{"data": [';
            $cantidad = count($items);
            for ($i = 0; $i < $cantidad; $i++) {
                $unidad = $items[$i]->NombreUnidad;
                $unidad .= "<br/>";
                if (($items[$i]->CodigoUnidadPadre != null) && ($items[$i]->CodigoUnidadPadre != "")) {
                    $unidad .= "<b><i>" . $items[$i]->NombreUnidadPadre . "</b></i>";
                } else {
                    $unidad .= "<b><i>CONSEJO UNIVERSITARIO</b></i>";
                }
                /*=============================================
                REVISAR ESTADO
                =============================================*/
                if ($items[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoItem = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $estadoItem = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivarItem' estado='" . $estadoItem . "' nroitem='" . $items[$i]->NroItem . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                /*$acciones .= "<button class='btn btn-warning btnEditarItem' nroitem='" . $items[$i]->NroItem . "' data-toggle='modal' data-target='#modalActualizarItem'><i class='fa fa-pen'></i></button>";*/
                $acciones .= "<button class='btn btn-danger btnEliminarItem' nroitem='" . $items[$i]->NroItem . "'><i class='fa fa-times'></i></button>";
                $acciones .= "</div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $items[$i]->NroItemPlanillas . '",
					 	"' . $items[$i]->NombreSectorTrabajo . '",
					 	"' . $unidad . '",
					 	"' . $items[$i]->NombreCargo . '",
					 	"' . $items[$i]->NombreCargoDependencia . '",
					 	"' . $estado . '",
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $items[$i]->NroItemPlanillas . '",
					 	"' . $items[$i]->NombreSectorTrabajo . '",
					 	"' . $unidad . '",
					 	"' . $items[$i]->NombreCargo . '",
					 	"' . $items[$i]->NombreCargoDependencia . '",
					 	"' . $estado . '",
				      	"' . $acciones . '"
  			  ],';
                }
            }
            $datosJson .= ']}';
            return $datosJson;
        } else {
            $datosJson = '{"data": [';
            $datosJson .= ']}';
            return $datosJson;
        }
    }

    public function actionActivarItemAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["nroitem"]) && $_POST["nroitem"] != "") {
                $item = Item::findOne($_POST["nroitem"]);
                if ($item->CodigoEstado == "V") {
                    $item->CodigoEstado = "C";
                } else {
                    $item->CodigoEstado = "V";
                }
                $item->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionBuscarItemAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["nroitem"]) && $_POST["nroitem"] != "") {
                $item = ItemsDao::buscaItem("array", $_POST["nroitem"]);
                return json_encode($item);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionCrearItemAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigosectortrabajo"]) && $_POST["codigosectortrabajo"] != "") {
                if (isset($_POST["codigocargo"]) && $_POST["codigocargo"] != "") {
                    if (isset($_POST["codigocargodependencia"]) && $_POST["codigocargodependencia"] != "") {
                        if (isset($_POST["codigounidad"]) && $_POST["codigounidad"] != "") {
                            if (isset($_POST["nroitemplanillas"]) && $_POST["nroitemplanillas"] != "") {
                                if (isset($_POST["nroitemplanillas"]) && $_POST["nroitemplanillas"] != "") {
                                    $maximo = ItemsDao::maximoItems();
                                    $nuevoNroItem = $maximo + 1;
                                    $item = new Item();
                                    $item->NroItem = $nuevoNroItem;
                                    $item->CodigoCargo = $_POST["codigocargo"];
                                    $item->CodigoCargoDependencia = $_POST["codigocargodependencia"];
                                    $item->CodigoUnidad = $_POST["codigounidad"];
                                    $item->NroItemPlanillas = $_POST["nroitemplanillas"];
                                    $item->NroItemRrhh = $_POST["nroitemrrhh"];
                                    $item->CodigoEstado = 'V';
                                    $item->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
                                    if (!$item->exist()) {
                                        $item->save();
                                        return "ok";
                                    } else {
                                        return "existe";
                                    }
                                } else {
                                    return "errorNroItemRrhh";
                                }
                            } else {
                                return "errorNroItemPlanillas";
                            }
                        } else {
                            return "errorUnidad";
                        }
                    } else {
                        return "errorCargoDependencia";
                    }
                } else {
                    return "errorCargo";
                }
            } else {
                return "errorSectorTrabajo";
            }
        } else {
            return "error";
        }
    }

    public function actionActualizarItemAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["nroitem"]) && $_POST["nroitem"] != "") {
                if (isset($_POST["codigocargo"]) && $_POST["codigocargo"] != "") {
                    if (isset($_POST["codigocargodependencia"]) && $_POST["codigocargodependencia"] != "") {
                        if (isset($_POST["codigounidad"]) && $_POST["codigounidad"] != "") {
                            if (isset($_POST["nroitemplanillas"]) && $_POST["nroitemplanillas"] != "") {
                                if (isset($_POST["nroitemplanillas"]) && $_POST["nroitemplanillas"] != "") {
                                    $item = Item::findOne($_POST["nroitem"]);
                                    $item->NroItemRrhh = $_POST["nroitemrrhh"];
                                    $item->NroItemPlanillas = $_POST["nroitemplanillas"];
                                    $item->CodigoCargo = $_POST["codigocargo"];
                                    $item->CodigoCargoDependencia = $_POST["codigocargodependencia"];
                                    $item->CodigoUnidad = $_POST["codigounidad"];
                                    //if (!$item->isUsed()) {
                                        $item->save();
                                        return "ok";
                                    //} else {
                                        //return "existe";
                                    //}
                                } else {
                                    return "errorNroItemRrhh";
                                }
                            } else {
                                return "errorNroItemPlanillas";
                            }
                        } else {
                            return "errorUnidad";
                        }
                    } else {
                        return "errorCargoDependencia";
                    }
                } else {
                    return "errorCargo";
                }
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionEliminarItemAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["nroitem"]) && $_POST["nroitem"] != "") {
                $item = Item::findOne($_POST["nroitem"]);
                //if (!$item->isUsed()) {
                    $item->delete();
                    return "ok";
                //} else {
                    //return "enUso";
                //}
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionListarCargosAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Seleccionar Cargo</option>";
            $codigoSectorTrabajo = $_POST["codigosectortrabajo"];
            $codigoUnidad = $_POST["codigounidad"];
            $cargos = PlanificacionDao::listaCargos($codigoSectorTrabajo,$codigoUnidad);
            foreach ($cargos as $cargo) {
                $opciones .= "<option value='" . $cargo->CodigoCargo . "'>" . $cargo->NombreCargo . "</option>";
            }
            return $opciones;
        }
    }

    public function actionListarUnidadesAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST['search'])) {
                $unidades = Unidad::find()->where(['like', 'NombreUnidad', '%' . $_POST['search'] . '%', false])->orderBy(['CodigoUnidad' => SORT_ASC])->all();
                //$unidades = PlanificacionDao::listaUnidades();
            } else {
                $unidades = Unidad::find()->orderBy(['CodigoUnidad' => SORT_ASC])->all();
                //$unidades = PlanificacionDao::listaUnidades();
            }

            $data = array();
            foreach ($unidades as $unidad) {
                $padre = Unidad::find()->where(['CodigoUnidad' => $unidad->CodigoUnidadPadre])->one();
                //$padre = PlanificacionDao::listaUnidades();
                if ($padre) {
                    $data[] = array('id' => $unidad->CodigoUnidad, 'text' => $unidad->NombreUnidad, 'padre' => $padre->NombreUnidad);
                } else {
                    $data[] = array('id' => $unidad->CodigoUnidad, 'text' => $unidad->NombreUnidad, 'padre' => 'CONSEJO UNIVERSITARIO');
                }
            }
            return json_encode($data);
            //return $data;
        } else {
            $data[] = array('id' => 0, 'text' => 'Error en el envio de datos');
            return json_encode($data);
            //return $data;
        }
       /* if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Seleccionar Unidad</option>";
            //$codigoUnidad = $_POST["codigosectortrabajo"];
            $unidades = PlanificacionDao::listaUnidades();
            foreach ($unidades as $unidad) {
                $opciones .= "<option value='" . $unidad->CodigoUnidad . "'>" . $unidad->NombreUnidad . "</option>";
            }
            return $opciones;
        }*/
    }
}