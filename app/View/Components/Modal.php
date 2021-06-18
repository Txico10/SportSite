<?php
/** 
 * Laravel Modal Component
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\View\Components;

use Illuminate\View\Component;
/**
 *  Users class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Modal extends Component
{
    public $title= '';
    public $id = '';
    public $type = '';
    public $icon = '';

    /**
     * Create a new component instance.
     * 
     * @param $title modal title
     * @param $id    modal id
     * @param $type  modal type
     * @param $icon  modal icon
     *
     * @return void
     */
    public function __construct($title, $id, $type, $icon)
    {
        $this->title = $title;
        $this->id = $id;
        $this->type=$type;
        $this->icon=$icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modal');
    }

    /**
     * Get modal id string
     * 
     * @return string
     */
    public function getModalIdString(): string
    {
        if ($this->id != '') {
            return $this->id;
        }

        return "modal" . rand(1111, 9999);
    }


}
