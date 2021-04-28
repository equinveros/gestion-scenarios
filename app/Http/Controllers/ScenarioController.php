<?php

namespace App\Http\Controllers;

use App\Crayon;
use App\Scenario;
use App\Step;
use App\Page;
use App\Site;
use App\Element;
use App\Rectangle;
use App\Line;
use App\Texte;
use Illuminate\Http\Request;
use Phalcon\Mvc\Model\Query\Lang;

class ScenarioController extends Controller {
    public function index() {
        return view("scenario/scenario");
    }


    public function create() {
        return view("scenario/scenario_register");
    }

    public function store(Request $request) {

    }


    public function show($id) {
        return view("scenario/scenario")->with('id', $id);

    }

    public function showAll() {
        $scenarios = Scenario::where([['delete',0],['close',0]])->get();
        foreach ($scenarios as $scenario) {
            $scenario['siteTitle'] = Site::where('id', $scenario->site_id)->first()->title;
        }

        return view("administration/admin_scenarios", compact('scenarios'));
    }

    public function view($scenario_id, $step_number = false, $lang = false) {
        $scenario = Scenario::where('id', $scenario_id)->firstOrFail();
        $step = false;
        if ($step_number) {
            $step = Step::where([['scenario_id',
                                   $scenario->id],
                                  ['step_number',
                                    $step_number],
                                  ['lang',
                                    $lang]])->first();

        }
        if (!$step) {
            $step = new Step;
            $step->name = "Nouvelle étape";
            $step->description = "";
            $step->step_number = $step_number;
            $step->scenario_id = $scenario_id;
            $step->priority = "P3";
            $step->state = "ko";
            $step->lang = $lang;
            if (!$step_number) {
                $page = 0;
            } else {
                $page = $step_number - 1;
            }
            $step->page_id = Page::where("site_id", $scenario->site_id)->get()[$page]->id;
            $step->save();
        }
        $states = trans('states');
        $priorities = trans('priorities');
        $langs = trans('langs');
        $pages = Page::where("site_id", $scenario->site_id)->get();
        $site = Site::where("id", $scenario->site_id)->firstOrFail();
        return view('scenario/scenario', compact('scenario', 'step', 'states', 'priorities', 'site', 'pages', 'langs', 'lang'));
    }

    public function getScenarioStep($scenario_id, $step_number = false, $lang = false) {

        $scenario = Scenario::where('id', $scenario_id)->firstOrFail();
        if ($step_number) {
            $step = Step::where([['scenario_id',
                                   $scenario->id],
                                  ['step_number',
                                    $step_number],
                                  ['lang',
                                    $lang]])->first();


        } else {
            $step = Step::where('scenario_id', $scenario->id)->firstOrFail();
        }

        $page = Page::where('id', $step->page_id)->firstOrFail();
        $site = Site::where('id', $page->site_id)->firstOrFail();
        $elements = Element::where('step_id', $step->id)->get();
        $stepElements = array();
        foreach ($elements as $element) {
            if ($element->delete) {
                continue;
            }
            switch ($element->elementable_type) {
                case "Rectangle" :
                    $elementSon = Rectangle::find($element->elementable_id);
                    break;
                case "Line" :
                    $elementSon = Line::find($element->elementable_id);
                    break;
                case "Text" :
                    $elementSon = Texte::find($element->elementable_id);
                    break;
                case "Pen":
                    $elementSon = Crayon::find($element->elementable_id);
                default:

            }
            $e = array("elementableType" => $element->elementable_type,
                       "elementSonDef"   => $elementSon,
                       "elementDef"      => $element);
            $stepElements[] = $e;
        }

        if ($lang == "fr") {
            $lang = "";
        }
        $datas[] = ['url'      => $site->urlSrc . $lang . $page->url,
                    'step'    => $step,
                    'elements' => $stepElements

        ];

        return $datas;
    }


    public function viewGridSteps($id) {
        $scenario = Scenario::where('id', $id)->firstOrFail();

        return view('scenario/scenario', compact('scenario'));
    }

    public function getFormScenario($id = false) {
        $sites = Site::all();
        $states = trans('states');
        $priorities = trans('priorities');
        $newScenario = false;
        $scenario = false;
        if ($id) {
            $scenario = Scenario::where('id', $id)->firstOrFail();
        } else {
            $newScenario = true;
        }
        return view('scenario/scenario_register', compact('sites', 'states', 'newScenario', 'scenario', 'priorities'));
    }


    public function registerScenario() {
        if (request('scenario_id')) {
          return "ok";
            $scenario = Scenario::where('id', request('scenario_id'))->firstOrFail();
            $scenario->user_update_id = request('user_id');
        } else {
            $scenario = new Scenario;
            $scenario->user_create_id = request('user_id');
        }
        $scenario->name = request('name');
        $scenario->description = request('description');
        $scenario->context = request('context');
        $scenario->priority = request('priority');
        if (request('state')) {
            $scenario->state = request('state');
        } else {
            $scenario->state = "ko";
        }
        $scenario->site_id = request('model');

        $scenario->save();
        return $this->showAll();
    }

    public function edit($id) {

    }


    public function update($id) {
      $scenario = Scenario::where('id', $id)->firstOrFail();
      $scenario->user_update_id = request('user_id');
      $scenario->name = request('name');
      $scenario->description = request('description');
      $scenario->context = request('context');
      $scenario->priority = request('priority');
      if (request('state')) {
          $scenario->state = request('state');
      } else {
          $scenario->state = "ko";
      }
      $scenario->site_id = request('model');

      $scenario->save();
      return $this->showAll();
    }


    public function destroy($id) {
        Scenario::destroy($id);
        return $this->showAll();
    }

    public function delete($id) {
        $scenario = Scenario::where('id',$id)->firstOrFail();
        $scenario->delete = 1;
        $scenario->save();

        return $this->showAll();
    }

    public function closeScenario($id) {
        $scenario = Scenario::where('id',$id)->firstOrFail();
        $scenario->close = 1;
        $scenario->save();
        return $this->showAll();
    }
}
