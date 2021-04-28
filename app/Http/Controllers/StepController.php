<?php

namespace App\Http\Controllers;

use App\Crayon;
use App\Element;
use App\Step;
use App\Rectangle;
use App\Page;
use App\Line;
use App\Scenario;
use App\Texte;
use Illuminate\Http\Request;

class StepController extends Controller {

    public function index() {
        //
    }

    public function showAllByScenario($scenario_id) {
        $steps = Step::where('scenario_id', $scenario_id)->get();
        $langs = trans('langs');
        $showByScenario = true;
        return view("administration/admin_steps", compact("steps", "showByScenario", "langs"));
    }

    public function showAll() {
        $langs = trans('langs');

        return view("administration/admin_steps", ["steps"         => Step::all(),
                                                    "showByScenario" => false,
                                                    $langs]);

    }

    public function getNumberStepByScenario($scenario_id) {
        $scenario = Scenario::where('id', $scenario_id)->firstOrFail();
        $pages = Page::where('site_id', $scenario->site_id)->get();

        return count($pages);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        //
    }


    public function show($id) {
        //
    }


    public function edit($id) {
        //
    }


    public function update(Request $request) {
        if ($step = Step::find($request['step']['id'])) {
            $step->name = $request['step']['name'];
            $step->description = $request['step']['description'];
            $step->context = $request['step']['context'];
            $step->priority = $request['step']['priority'];
            $step->state = $request['step']['state'];
            if (isset($request->elements)) {

                foreach ($request->elements as $e) {
                    if (!array_key_exists('id', $e['elementDef'])) {
                        $element = new Element;
                    } else {
                        $element = Element::find($e['elementDef']['id']);
                    }
                    if ($e['delete'] == "true") {
                        $element->delete = true;
                    }
                    $element->name = $e['elementDef']['name'];
                    $element->context = $e['elementDef']['context'];
                    $element->description = $e['elementDef']['description'];
                    $element->strokeWidth = $e['elementDef']['strokeWidth'];
                    $element->step_id = $step->id;
                    if (!isset($e['elementDef']['priority'])) {
                        $element->priority = "P4";
                    } else {
                        $element->priority = $e['elementDef']['priority'];
                    }
                    if (!isset($e['elementDef']['priority'])) {
                        $element->state = "ko";
                    } else {
                        $element->state = $e['elementDef']['state'];
                    }
                    $element->pos_y = $e['elementDef']['pos_y'];
                    $element->pos_x = $e['elementDef']['pos_x'];
                    switch ($e['elementableType']) {
                        case "Line" :
                            if (!isset($e['elementDef']['elementable_id'])) {
                                $elementSon = new Line;
                            } else {
                                $elementSon = Line::find($e['elementDef']['elementable_id']);
                            }
                            $elementSon->x1 = $e['elementSonDef']['x1'];
                            $elementSon->x2 = $e['elementSonDef']['x2'];
                            $elementSon->y1 = $e['elementSonDef']['y1'];
                            $elementSon->y2 = $e['elementSonDef']['y2'];
                            break;
                        case "Rectangle" :
                            if (!isset($e['elementDef']['elementable_id'])) {
                                $elementSon = new Rectangle;
                            } else {
                                $elementSon = Rectangle::find($e['elementDef']['elementable_id']);
                            }
                            $elementSon->height = $e['elementSonDef']['height'];
                            $elementSon->width = $e['elementSonDef']['width'];

                            break;
                        case "Text" :
                            if (!isset($e['elementDef']['elementable_id'])) {
                                $elementSon = new Texte;
                            } else {
                                $elementSon = Texte::find($e['elementDef']['elementable_id']);
                            }
                            $elementSon->fontFamily = $e['elementSonDef']['fontFamily'];
                            break;
                        case "Pen" :
                            if (!isset($e['elementDef']['elementable_id'])) {
                                $elementSon = new Crayon;
                            } else {
                                $elementSon = Crayon::find($e['elementDef']['elementable_id']);
                            }
                            $elementSon->points = $e['elementSonDef']['points'];
                            break;
                    }

                    $elementSon->save();
                    if (!isset($e['elementDef']['id'])) {
                        $element->elementable_type = $e['elementableType'];
                        $element->elementable_id = $elementSon->id;
                    }
                    $element->save();
                }
            }


            $step->save();

            return json_encode($request->all());
        }
        return false;
    }


    public function destroy($id) {
        //
    }
}
