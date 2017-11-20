<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Config;

use HTML;
use URL;
use Mail;
use App\Mail\ContactForm;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\SelectFilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\EloquentDataRow;

use function back;
use function view;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if($request->has('email')){
            // Try to create contact
            try{
                $contact = new Contact();
                $contact->setName($data['name']);
                $contact->setEmail($data['email']);
                $contact->setPhone($data['phone']);
                $contact->setMessage($data['message']);
                $contact->save();
                
                $contactPerson = (new Config())->getConfigByName('contact')->first();
                
                Mail::to($contactPerson->getValue())->send(new ContactForm($contact));
            } catch (Exception $ex) {
                return '<div class="error">'.$ex.'</div>';
            }
            return '<div class="success">'.__('Thank you! We will get back to you as soon as possible!').'</div>';
        }
    }
    
    /**
     * Delete the specified resource.
     *
     * @param  integer $id
     * @return Redirect
     */
    public function delete($id)
    {
        if ($id){
            $contact = Contact::find($id);
            if($contact){
                $contact->delete();
                return back()->with('status',  __('Contact has been deleted!') );
            }
        }
        return back()->with('error', __('Id was missing from the request, check data!'));
    }
    
    /**
     * Notify again by email
     *
     * @param  integer $id
     * @return Redirect
     */
    public function send($id)
    {
        if ($id){
            $contact = Contact::find($id);
            if($contact){
                try{
                    $contactPerson = (new Config())->getConfigByName('contact')->first();
                    
                    Mail::to($contactPerson->getValue())->send(new ContactForm($contact));
                } catch (Exception $ex) {
                    return '<div class="error">'.$ex.'</div>';
                }
            return back()->with('status',  __('Contact has been emailed!') );
            }
        }
        return back()->with('error', __('Id was missing from the request, check data!'));
    }
    
    /**
     * Display a listing of the resource.
     * @param  Request  $request
     * @return Response
     */
    public function view(Request $request)
    {
        $query = (new Contact)->newQuery();
        
        $cfg = (new GridConfig())
            ->setName('administrate')
            ->setDataProvider(
                    new EloquentDataProvider(
                        $query
                    )
            )
            ->setPageSize(10)
            ->setColumns([
                (new FieldConfig)
                    ->setName('id')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('id')
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('name')
                    ->setLabel('Name')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('name')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('email')
                    ->setLabel('Email')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('email')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('phone')
                    ->setLabel('Phone')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('phone')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('message')
                    ->setLabel('Message')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('message')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('action')
                    ->setLabel(__('Action'))
                    ->setCallback(function ($val, EloquentDataRow $row) {
                        $output = "<a class='btn btn btn-danger' href='".URL::route('contact.delete', array('id' => $row->getSrc()->id))."'><i class='glyphicon glyphicon-trash' aria-hidden='true'></i>".__('Delete')."</a>";
                        $output .= "<a class='btn btn btn-info' href='".URL::route('contact.send', array('id' => $row->getSrc()->id))."'><i class='glyphicon glyphicon-send' aria-hidden='true'></i>".__('Email')."</a>";
                        return $output;
                    })
            ])
            ->setComponents([ 
                (new OneCellRow)
                    ->setRenderSection(RenderableRegistry::SECTION_END)
                    ->setComponents([
                        new RecordsPerPage,
                    ]),
                (new THead)
                ->getComponentByName(FiltersRow::NAME)
                ->addComponent(
                    (new ExcelExport)
                        ->setFileName('contacts')
                        ->setRenderSection('filters_row_column_action')
                        ->setIgnoredColumns(['action'])
                )
                ->getParent()
            ,new TFoot ]);

        $grid = (new Grid($cfg))->render();
        
        return view('admin.grid.contacts', ['user' => $this->getUser()], compact('grid'));
    }
}
